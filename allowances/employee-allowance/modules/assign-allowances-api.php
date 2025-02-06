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
require_once __DIR__ . '/../../../includes/enums/ErrorCode.php';
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
        $employeeAllowanceService = new EmployeeAllowanceService($employeeAllowanceRepository);
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
        
        //print_r($employeeAllowancesData);

        $employeeAllowanceRepository = new EmployeeAllowanceRepository($employeeAllowanceDao);
        $employeeAllowanceService = new EmployeeAllowanceService($employeeAllowanceRepository);
        foreach ($employeeAllowancesData as $employeeAllowance) {
            $newEmployeeAllowance = new EmployeeAllowance(
                id: null,
                employeeId: $employeeId,
                allowanceId: $employeeAllowance['id'],
                amount: $employeeAllowance['amount']
            );
            $assignResult = $employeeAllowanceService->createEmployeeAllowance($newEmployeeAllowance);
        }
        
        if ($assignResult === ActionResult::SUCCESS) {
            echo "
            <script>
                showSuccessEntitlement();
            </script>
            ";
        } else {
            echo "
            <script>
                showError();
            </script>
            ";
        }
        
        return;
    }

    if($action === 'deleteAllowance'){
        $employeeAllowanceId = isset($_POST['employee_allowance_id']) ? (int) $_POST['employee_allowance_id'] : null;

        if($employeeAllowanceId == null){
            die("");
        }

        $employeeAllowanceRepository = new EmployeeAllowanceRepository($employeeAllowanceDao);
        $employeeAllowanceService = new EmployeeAllowanceService($employeeAllowanceRepository);
        $deleteresult = $employeeAllowanceService->deleteEmployeeAllowance($employeeAllowanceId);
        if ($deleteresult === ActionResult::SUCCESS){
            echo "
            <script>
            showSuccessDeleteAllowance();
            </script>
            ";
        }

        return;
    }
    
    echo "Invalid action specified";
} catch (Exception $e) {
echo "Error: " . $e->getMessage();
}


