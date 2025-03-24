<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../Employee.php';
require_once __DIR__ . '/../EmployeeDao.php';
require_once __DIR__ . '/../EmployeeService.php';
require_once __DIR__ . '/../EmployeeRepository.php';

require_once __DIR__ . '/../../leaves/LeaveEntitlement.php';
require_once __DIR__ . '/../../leaves/LeaveEntitlementRepository.php';
require_once __DIR__ . '/../../leaves/LeaveEntitlementService.php';
require_once __DIR__ . '/../../leaves/LeaveEntitlementDao.php';

require_once __DIR__ . '/../../employment-type-benefits/EmploymentTypeBenefit.php';
require_once __DIR__ . '/../../employment-type-benefits/EmploymentTypeBenefitDao.php';
require_once __DIR__ . '/../../employment-type-benefits/EmploymentTypeBenefitRepository.php';
require_once __DIR__ . '/../../employment-type-benefits/EmploymentTypeBenefitService.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . "/../../includes/enums/ActionResult.php";
require_once __DIR__ . '/../../database/database.php';

require_once __DIR__ . '/../../includes/session.php';

try {
    $employeeDao = new EmployeeDao($pdo);
    $action = $_POST['action'] ?? '';

    if($action == 'create'){
        if(!isset($_POST['employeeData'])){
            return;
        }
        $employeeData = isset($_POST['employeeData']) ? $_POST['employeeData'] : [];
        $employment_type = isset($employeeData['employment_type']) ? validateInput($employeeData['employment_type'], 'Employment Type') : '';

        // print_r($employeeData);

        $employeeRepo = new EmployeeRepository($employeeDao);
        $employeeService = new EmployeeService($employeeRepo);
        $result = $employeeService->createEmployee($employeeData);

        $lastemployeeId = $employeeService->fetchLastEmployeeId();

        assignLeaveEntitlements($lastemployeeId, $employment_type);


        if (isset($result['status']) && $result['status'] === 'success') {
            die("
            <script>
                showSuccessCreate();
            </script>
            ");
        } else if (isset($result['status']) && $result['status'] === 'error') {
            die("
            <script>
                showError(" . json_encode($result['message']) . ")
            </script>
            ");
        } else if (isset($result['status']) && $result['status'] === 'invalid_input'){
            die("
            <script>
                showValidationError(" . json_encode($result['errors']) . ");
            </script>
            ");
        }


        return;
    }

    if($action == 'update'){
        $employeeData = isset($_POST['employeeData']) ? $_POST['employeeData'] : null;
        if(!$employeeData){
            return;
        }
        $hashed_id = $employeeData['id'] ?? null;
        // Retrieve employee data from POST request
        $employeeData = isset($_POST['employeeData']) ? $_POST['employeeData'] : [];
        $employment_type = isset($employeeData['employment_type']) ? validateInput($employeeData['employment_type'], 'Employment Type') : '';

        $employeeRepo = new EmployeeRepository($employeeDao);
        $employeeService = new EmployeeService($employeeRepo);

        $empCode = $employeeService->fetchAllEmployees(
            ['employee_code'], 
            [
                [
                "column" => "SHA2(employee.id, 256)",
                "operator" => "=",
                "value" => $hashed_id
                ]
            ], [], 1
        );

        $employeeData['employee_code'] = $empCode['result_set'][0]['employee_code'];

        $result = $employeeService->updateEmployee($employeeData);

        assignLeaveEntitlementsHashed($hashed_id, $employment_type);

        if (isset($result['status']) && $result['status'] === 'success') {
            die("
            <script>
                showSuccessUpdate(". json_encode($hashed_id) .");
            </script>
            ");
        } else if (isset($result['status']) && $result['status'] === 'error') {
            die("
            <script>
                showError(" . json_encode($result['message']) . ")
            </script>
            ");
        } else if (isset($result['status']) && $result['status'] === 'invalid_input'){
            die("
            <script>
                showValidationError(" . json_encode($result['errors']) . ");
            </script>
            ");
        }

        
        return;
    }


    $message = "Invalid action specified.";
    die('
    <script>
        showFatalError(' . json_encode($message) 
    . ');
    </script>');
} catch (Exception $e) {
    $message = "Fatal error: " . $e->getMessage();
    die('
    <script>
        showFatalError(' . json_encode($message) 
    . ');
    </script>');
}

// Function to validate and sanitize input
function validateInput($input, $fieldName) {
    // Trim the input to remove extra whitespaces
    $input = trim($input);
    
    // Check if input is empty after trimming
    if (empty($input)) {
        die("
        <script>
            missingFieldValues('{$fieldName}');
        </script>
        ");
    }
    
    // Additional validation can go here (e.g., regex for specific formats)
    
    return htmlspecialchars($input); // Sanitize to prevent XSS
}

function assignLeaveEntitlementsHashed($employeeId, $employmentType){
    global $pdo;
    $leaveEntitlementDao = new LeaveEntitlementDao($pdo);
    $employmentTypeDao = new EmploymentTypeBenefitDao($pdo);
    $employeeDao = new EmployeeDao($pdo);

    $employmentTypeRepo = new EmploymentTypeBenefitRepository($employmentTypeDao);
    $employmentTypeService = new EmploymentTypeBenefitService($employmentTypeRepo);
    $leaveRepo = new LeaveEntitlementRepository($leaveEntitlementDao);
    $leaveService = new LeaveEntitlementService($leaveRepo);
    $employeeRepo = new EmployeeRepository($employeeDao);
    $employeeService = new EmployeeService($employeeRepo);



    $fetchEmployeeLeaves = $leaveService->getAllLeaveEntitlements(
        ['id'],
        [
            [
                "column" => "SHA2(leave_entitlement.employee_id, 256)",
                "operator" => "=",
                "value" => $employeeId  
            ],
        ]
    );

    $matchingEmployeeLeaves = $fetchEmployeeLeaves['result_set'];

    foreach ($matchingEmployeeLeaves as $matchingEmployeeLeave){
        $delete = $leaveService->deleteLeaveEntitlement($matchingEmployeeLeave['id']);
    }

    $fetchEmploymentTypeLeaves = $employmentTypeService->fetchAllEmploymentTypeBenefits(
        ['leave_type_id', 'leave_type_maximum_number_of_days'],
        [
            [
                "column" => "employment_type_benefit.employment_type",
                "operator" => "=",
                "value" => $employmentType  
            ],
        ]
    );

    
    $matchingEmploymentTypesLeaves = $fetchEmploymentTypeLeaves['result_set'];

    $fetchEmployeeId = $employeeService->fetchAllEmployees(['id'],
    [
        [
            "column" => "SHA2(employee.id, 256)",
            "operator" => "=",
            "value" => $employeeId  
        ],
    ]
    );

    $employeeNonHashed = $fetchEmployeeId['result_set'][0]['id'];

    foreach ($matchingEmploymentTypesLeaves as $matchingEmploymentTypeLeave){
        $newLeaveEntitlement = new LeaveEntitlement(
            id: null,
            employeeId: (int) $employeeNonHashed,
            leaveTypeId: (int) $matchingEmploymentTypeLeave['leave_type_id'],
            numberOfEntitledDays: (int) $matchingEmploymentTypeLeave['leave_type_maximum_number_of_days'],
            numberOfDaysTaken: 0,
            remainingDays: (int) $matchingEmploymentTypeLeave['leave_type_maximum_number_of_days']
        );

        $create = $leaveService->createLeaveEntitlement($newLeaveEntitlement);
    }

    


    return;
}


function assignLeaveEntitlements($employeeId, $employmentType){
    global $pdo;
    $leaveEntitlementDao = new LeaveEntitlementDao($pdo);
    $employmentTypeDao = new EmploymentTypeBenefitDao($pdo);
    $employeeDao = new EmployeeDao($pdo);

    $employmentTypeRepo = new EmploymentTypeBenefitRepository($employmentTypeDao);
    $employmentTypeService = new EmploymentTypeBenefitService($employmentTypeRepo);
    $leaveRepo = new LeaveEntitlementRepository($leaveEntitlementDao);
    $leaveService = new LeaveEntitlementService($leaveRepo);
    $employeeRepo = new EmployeeRepository($employeeDao);
    $employeeService = new EmployeeService($employeeRepo);



    $fetchEmployeeLeaves = $leaveService->getAllLeaveEntitlements(
        ['id'],
        [
            [
                "column" => "leave_entitlement.employee_id",
                "operator" => "=",
                "value" => $employeeId  
            ],
        ]
    );

    $matchingEmployeeLeaves = $fetchEmployeeLeaves['result_set'];

    foreach ($matchingEmployeeLeaves as $matchingEmployeeLeave){
        $delete = $leaveService->deleteLeaveEntitlement($matchingEmployeeLeave['id']);
    }

    $fetchEmploymentTypeLeaves = $employmentTypeService->fetchAllEmploymentTypeBenefits(
        ['leave_type_id', 'leave_type_maximum_number_of_days'],
        [
            [
                "column" => "employment_type_benefit.employment_type",
                "operator" => "=",
                "value" => $employmentType  
            ],
        ]
    );

    
    $matchingEmploymentTypesLeaves = $fetchEmploymentTypeLeaves['result_set'];

    foreach ($matchingEmploymentTypesLeaves as $matchingEmploymentTypeLeave){
        $newLeaveEntitlement = new LeaveEntitlement(
            id: null,
            employeeId: (int) $employeeId,
            leaveTypeId: (int) $matchingEmploymentTypeLeave['leave_type_id'],
            numberOfEntitledDays: (int) $matchingEmploymentTypeLeave['leave_type_maximum_number_of_days'],
            numberOfDaysTaken: 0,
            remainingDays: (int) $matchingEmploymentTypeLeave['leave_type_maximum_number_of_days']
        );

        $create = $leaveService->createLeaveEntitlement($newLeaveEntitlement);
    }

    


    return;
}