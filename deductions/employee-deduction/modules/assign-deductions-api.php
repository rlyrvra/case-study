<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../../Deduction.php';
require_once __DIR__ . '/../../DeductionDao.php';
require_once __DIR__ . '/../../DeductionRepository.php';
require_once __DIR__ . '/../../DeductionService.php';

require_once __DIR__ . '/../../EmployeeDeduction.php';
require_once __DIR__ . '/../../EmployeeDeductionDao.php';
require_once __DIR__ . '/../../EmployeeDeductionRepository.php';
require_once __DIR__ . '/../../EmployeeDeductionService.php';

require_once __DIR__ . '/../../../includes/Helper.php';
require_once __DIR__ . '/../../../includes/enums/ActionResult.php';
require_once __DIR__ . '/../../../database/database.php';

try{
    $employeeDeductionDao = new EmployeeDeductionDao($pdo);
    $action = $_POST['action'] ?? '';


    if($action === 'fetchEmployeeDeductions'){
        $employeeId = isset($_POST['employee_id']) ? (int) $_POST['employee_id'] : null;

        if($employeeId == null){
            die("");
        }

        $selectedColumns = ["id", "deduction_name", "amount", "deduction_frequency"];
        $filterCriteria = [
            [
                "column" => "employee_deduction.employee_id",
                "operator" => "=", 
                "value" => $employeeId
            ],
            [
                "column" => "deduction.status",
                "operator" => "=", 
                "value" => 'Active'
            ],
            [
                "column" => "employee_deduction.deleted_at",
                "operator" => "IS NULL"
            ]
        ];
        $employeeDeductionRepository = new EmployeeDeductionRepository($employeeDeductionDao);
        $employeeDeductionService = new EmployeeDeductionService($pdo, $employeeDeductionRepository);
        $result = $employeeDeductionService->fetchAllEmployeeDeductions($selectedColumns, $filterCriteria);
        $employeeDeductions;
        if ($result !== ActionResult::FAILURE){
            $employeeDeductions = $result['result_set'];
        }
        include __DIR__ . '/assign-deductions-table.php';
        return;
    }

    if($action === 'assignDeductions'){
        $employeeDeductionsData = $_POST['selectedDeductions'] ?? null;
        if(!$employeeDeductionsData){
            return;
        }
        $employeeId = isset($_POST['employee_id']) ? (int) $_POST['employee_id'] : null;
        if(!$employeeId){
            return;
        }
        $assignResult = null;
        
        //print_r($employeeDeductionsData);

        $employeeDeductionRepository = new EmployeeDeductionRepository($employeeDeductionDao);
        $employeeDeductionService = new EmployeeDeductionService($pdo, $employeeDeductionRepository);
        foreach ($employeeDeductionsData as $employeeDeduction) {
            $newEmployeeDeduction = new EmployeeDeduction(
                id: null,
                employeeId: $employeeId,
                deductionId: $employeeDeduction['id'],
                amount: $employeeDeduction['amount']
            );
            $assignResult = $employeeDeductionService->createEmployeeDeduction($newEmployeeDeduction);
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

    if($action === 'deleteDeduction'){
        $employeeDeductionId = isset($_POST['employee_deduction_id']) ? (int) $_POST['employee_deduction_id'] : null;

        if($employeeDeductionId == null){
            die("");
        }

        $employeeDeductionRepository = new EmployeeDeductionRepository($employeeDeductionDao);
        $employeeDeductionService = new EmployeeDeductionService($pdo, $employeeDeductionRepository);
        $deleteresult = $employeeDeductionService->deleteEmployeeDeduction($employeeDeductionId);
        if ($deleteresult === ActionResult::SUCCESS){
            echo "
            <script>
            showSuccessDeleteDeduction();
            </script>
            ";
        }

        return;
    }

    echo "Invalid action specified";
} catch (Exception $e) {
echo "Error: " . $e->getMessage();
}


