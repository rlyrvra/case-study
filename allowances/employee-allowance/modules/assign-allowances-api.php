<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../../Allowance.php';
require_once __DIR__ . '/../../AllowanceDao.php';
require_once __DIR__ . '/../../AllowanceRepository.php';
require_once __DIR__ . '/../../AllowanceService.php';

require_once __DIR__ . '/../../EmployeeAllowance.php';
require_once __DIR__ . '/../../EmployeeAllowanceDao.php';
require_once __DIR__ . '/../../EmployeeAllowanceRepository.php';
require_once __DIR__ . '/../../EmployeeAllowanceService.php';

require_once __DIR__ . '/../../../includes/Helper.php';
require_once __DIR__ . '/../../../includes/enums/ActionResult.php';
require_once __DIR__ . '/../../../database/database.php';

try{
    $employeeAllowanceDao = new EmployeeAllowanceDao($pdo);
    $action = $_POST['action'] ?? '';

    if($action === 'fetchEmployeeAllowances'){
        $employeeId = isset($_POST['employee_id']) ? (int) $_POST['employee_id'] : null;

        if($employeeId == null){
            die("");
        }

        $selectedColumns = ["id", "allowance_name", "amount", "allowance_frequency"];
        $filterCriteria = [
            [
                "column" => "employee_allowance.employee_id",
                "operator" => "=", 
                "value" => $employeeId
            ],
            [
                "column" => "allowance.status",
                "operator" => "=", 
                "value" => 'Active'
            ],
            [
                "column" => "employee_allowance.deleted_at",
                "operator" => "IS NULL"
            ]
        ];
        $employeeAllowanceRepository = new EmployeeAllowanceRepository($employeeAllowanceDao);
        $employeeAllowanceService = new EmployeeAllowanceService($pdo, $employeeAllowanceRepository);
        $result = $employeeAllowanceService->fetchAllEmployeeAllowances($selectedColumns, $filterCriteria);
        $employeeAllowances;
        if ($result !== ActionResult::FAILURE){
            $employeeAllowances = $result['result_set'];
        }
        include __DIR__ . '/assign-allowances-table.php';
        return;
    }

    if($action === 'assignAllowances'){
        $employeeAllowancesData = $_POST['selectedAllowances'] ?? null;
        if(!$employeeAllowancesData){
            return;
        }
        $employeeId = isset($_POST['employee_id']) ? (int) $_POST['employee_id'] : null;
        if(!$employeeId){
            return;
        }
        $assignResult = null;
        
        foreach ($employeeAllowancesData as $key => $employeeAllowance) {
            $employeeAllowancesData[$key]['employee_id'] = $employeeId;
        }

        $employeeAllowanceRepository = new EmployeeAllowanceRepository($employeeAllowanceDao);
        $employeeAllowanceService = new EmployeeAllowanceService($pdo, $employeeAllowanceRepository);
        $result = $employeeAllowanceService->createEmployeeAllowance($employeeAllowancesData);
        

        if (isset($result['status']) && $result['status'] === 'success') {
            die("
            <script>
                showSuccessEntitlement(" . json_encode($result['message']) . ");
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
                showValidationErrorAssign(" . json_encode($result['errors']) . ");
            </script>
            ");
        }
        
        return;
    }

    if($action === 'deleteAllowance'){
        $employeeAllowanceId = isset($_POST['employee_allowance_id']) ? (int) $_POST['employee_allowance_id'] : null;

        if($employeeAllowanceId == null){
            die("");
        }

        $employeeAllowanceRepository = new EmployeeAllowanceRepository($employeeAllowanceDao);
        $employeeAllowanceService = new EmployeeAllowanceService($pdo, $employeeAllowanceRepository);
        $result = $employeeAllowanceService->deleteEmployeeAllowance($employeeAllowanceId);
        

        if (isset($result['status']) && $result['status'] === 'success') {
            die("
            <script>
                showSuccessDeleteAllowance();
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
                showValidationErrorAssign(" . json_encode($result['errors']) . ");
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


