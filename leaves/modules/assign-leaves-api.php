<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../LeaveEntitlement.php';
require_once __DIR__ . '/../LeaveEntitlementRepository.php';
require_once __DIR__ . '/../LeaveEntitlementService.php';
require_once __DIR__ . '/../LeaveEntitlementDao.php';
require_once __DIR__ . '/../../employees/Employee.php';
require_once __DIR__ . '/../../employees/EmployeeDao.php';
require_once __DIR__ . '/../../employees/EmployeeRepository.php';
require_once __DIR__ . '/../../employees/EmployeeService.php';
require_once __DIR__ . '/../../employment-type-benefits/EmploymentTypeBenefit.php';
require_once __DIR__ . '/../../employment-type-benefits/EmploymentTypeBenefitDao.php';
require_once __DIR__ . '/../../employment-type-benefits/EmploymentTypeBenefitRepository.php';
require_once __DIR__ . '/../../employment-type-benefits/EmploymentTypeBenefitService.php';
require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../includes/enums/ActionResult.php';
require_once __DIR__ . '/../../includes/enums/ErrorCode.php';
require_once __DIR__ . '/../../database/database.php';

try{
    $leaveEntitlementDao = new LeaveEntitlementDao($pdo);
    $employmentTypeDao = new EmploymentTypeBenefitDao($pdo);
    $employeeDao = new EmployeeDao($pdo);
    $action = $_POST['action'] ?? '';

    if($action === 'fetchEmployeeLeave'){
        $employeeId = isset($_POST['employee_id']) ? (int) $_POST['employee_id'] : null;

        if($employeeId == null){
            die("");
        }

        $selectedColumns = ["id", "leave_type_name", "number_of_entitled_days", "number_of_days_taken", "remaining_days", "deleted_at"];
        $filterCriteria = [
            [
            "column" => "leave_entitlement.employee_id",
            "operator" => "=", 
            "value" => $employeeId
            ],
            [
            "column" => "leave_entitlement.deleted_at",
            "operator" => "IS NULL",
            ]
        ];
        $leaveRepo = new LeaveEntitlementRepository($leaveEntitlementDao);
        $leaveService = new LeaveEntitlementService($leaveRepo);
        $result = $leaveService->getAllLeaveEntitlements($selectedColumns, $filterCriteria);
        $employeeLeaves;
        if ($result !== ActionResult::FAILURE){
            $employeeLeaves = $result['result_set'];
        }
        include __DIR__ . '/assign-leaves-table.php';
        return;
    }

    if($action === 'assignLeaves'){
        $employeeLeavesData = $_POST['selected_leaves'] ?? null;
        if(!$employeeLeavesData){
            return;
        }
        $employmentType = $_POST['employment_type'] ?? '';
        if(empty($employmentType)){
            return;
        }

        

        $assignResult;
        $employmentTypeRepo = new EmploymentTypeBenefitRepository($employmentTypeDao);
        $employmentTypeService = new EmploymentTypeBenefitService($employmentTypeRepo);
        $employeeRepo = new EmployeeRepository($employeeDao);
        $employeeService = new EmployeeService($employeeRepo);
        $leaveRepo = new LeaveEntitlementRepository($leaveEntitlementDao);
        $leaveService = new LeaveEntitlementService($leaveRepo);

        $fetchEmployeeTypesResult = $employeeService->fetchAllEmployees(["id"], [
            [
                "column" => "employee.employment_type",
                "operator" => "=",
                "value" => $employmentType
            ]
        ]);

        $matchingEmployees = $fetchEmployeeTypesResult['result_set'];

        $fetchExistingLeaves = $employmentTypeService->fetchAllEmploymentTypeBenefits(['leave_type_id'],
        [
            [
                "column" => "employment_type_benefit.employment_type",
                "operator" => "=",
                "value" => $employmentType
            ]
        ]
        );

        $matchingLeaves = $fetchExistingLeaves['result_set'];
        
        $onQueueDeletionLeaves = [];
        // Extract `id` values from $employeeLeavesData into a new array
        $employeeLeaveIds = array_map('intval', array_column($employeeLeavesData, 'id'));
        foreach ($matchingLeaves as $leave) {
            if (!in_array($leave['leave_type_id'], $employeeLeaveIds, true)) {
                $onQueueDeletionLeaves[] = $leave;
            }
            
        }
        // print_r($matchingLeaves);
        // echo "<br>";
        // print_r($employeeLeaveIds);
        // echo "<br>";
        // print_r($onQueueDeletionLeaves);
        // echo "<br>";
        foreach ($employeeLeavesData as $employeeLeaves) {
            $newEmploymentTypeLeave = new EmploymentTypeBenefit(
                id: null,
                employmentType: $employmentType,
                leaveTypeId: $employeeLeaves['id'],
                allowanceId: null,
                deductionId: null
            );


            $createEmploymentTypeServiceResult = $employmentTypeService->createEmploymentTypeBenefit($newEmploymentTypeLeave);


            foreach ($matchingEmployees as $matchingEmployee) {
                $newLeaveEntitlement = new LeaveEntitlement(
                    id: null,
                    employeeId: $matchingEmployee['id'],
                    leaveTypeId: $employeeLeaves['id'],
                    numberOfEntitledDays: $employeeLeaves['credits'],
                    numberOfDaysTaken: 0,
                    remainingDays: $employeeLeaves['credits']
                );

                $assignResult = $leaveService->createLeaveEntitlement($newLeaveEntitlement);
            }

        }

        foreach ($onQueueDeletionLeaves as $deletedLeaveId){
            // print_r($deletedLeaveId);
            // echo $deletedLeaveId['leave_type_id'];
            $currentDeletedId = (int) $deletedLeaveId['leave_type_id'];
            $deleteEmploymentTypeServiceResult = $employmentTypeService->deleteEmploymentTypeBenefit($currentDeletedId);
            $fetchLeaveTypeIdByEntitlement = $leaveService->getAllLeaveEntitlements(["id"],
                [
                    [
                    "column" => "leave_entitlement.leave_type_id",
                    "operator" => "=",
                    "value" => $currentDeletedId
                    ],
                ]
                );
            $matchingLeaveEntitlements = $fetchLeaveTypeIdByEntitlement['result_set'];
            foreach ($matchingLeaveEntitlements as $matchingLeaveEntitlement) {
                $matchingLeaveEntitlementId = (int) $matchingLeaveEntitlement['id'];
                $deleteResult = $leaveService->deleteLeaveEntitlement($matchingLeaveEntitlementId);
            }
        }

        
        

        if ($assignResult === ActionResult::SUCCESS) {
            echo "
            <script>
                showSuccessLeaveEntitlement();
            </script>
            ";
        }
        
        return;
    }

    if($action === 'deleteEmployeeLeave'){
        $leave_entitlement_id = isset($_POST['leave_entitlement_id']) ? (int) $_POST['leave_entitlement_id'] : null;

        if($leave_entitlement_id == null){
            die("");
        }

        $leaveRepo = new LeaveEntitlementRepository($leaveEntitlementDao);
        $leaveService = new LeaveEntitlementService($leaveRepo);
        $deleteresult = $leaveService->deleteLeaveEntitlement($leave_entitlement_id);
        $employeeLeaves;
        if ($deleteresult === ActionResult::SUCCESS){
            echo "
            <script>
            showSuccessDeleteLeaveEntitlement();
            </script>
            ";
        }

        return;
    }
    echo "Invalid action specified";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

