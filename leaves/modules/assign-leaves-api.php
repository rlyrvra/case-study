<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../LeaveEntitlement.php';
require_once __DIR__ . '/../LeaveEntitlementRepository.php';
require_once __DIR__ . '/../LeaveEntitlementService.php';
require_once __DIR__ . '/../LeaveEntitlementDao.php';
require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../includes/enums/ActionResult.php';
require_once __DIR__ . '/../../includes/enums/ErrorCode.php';
require_once __DIR__ . '/../../database/database.php';

try{
    $leaveEntitlementDao = new LeaveEntitlementDao($pdo);
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
        $employeeId = $_POST['employee_id'];
        $deleteResult;
        forEach($employeeLeavesData as $employeeLeaves){
            $newLeaveEntitlement = new LeaveEntitlement(
                id: null,
                employeeId: $employeeId,
                leaveTypeId: $employeeLeaves['id'],
                numberOfEntitledDays: $employeeLeaves['credits'],
                numberOfDaysTaken: 0,
                remainingDays: $employeeLeaves['credits']
            );
            $leaveRepo = new LeaveEntitlementRepository($leaveEntitlementDao);
            $leaveService = new LeaveEntitlementService($leaveRepo);
            $deleteresult = $leaveService->createLeaveEntitlement($newLeaveEntitlement);
            
        }
        if ($deleteresult === ActionResult::SUCCESS){
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

