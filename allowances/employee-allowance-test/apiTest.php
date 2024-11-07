<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../EmployeeAllowanceDao.php';
require_once __DIR__ . '/../EmployeeAllowance.php';
require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../includes/enums/ErrorCode.php';
require_once __DIR__ . '/../../database/database.php';


try {
    $employeeAllowanceDao = new EmployeeAllowanceDao($pdo);
    $action = $_POST['action'] ?? '';
    $employeeId = $_POST['employee_id'] ?? null;

    if ($action === 'fetchAll') {
        include __DIR__ . '/allowanceDynamic.php';
        return;
    } 

    if ($action === 'fetchAllEmployeeAllowances') {
        include __DIR__ . '/allowanceDynamic copy.php';
        return;
    } 


    if ($action === 'create') {
        $employeeAllowances = $_POST['allowance'] ?? null;

        if (!$employeeAllowances) {
            echo "Invalid Employee allowance data.";
            return;
        }
        
        print_r($employeeAllowances);

        foreach ($employeeAllowances as $employeeAllowanceData){
            $allowanceId = $employeeAllowanceData['allowanceId'] ?? null;
            $amount = $employeeAllowanceData['amount'] ?? null;
            $newAllowance = new EmployeeAllowance(
                id: null,
                employeeId: $employeeId,
                allowanceId: $allowanceId,
                amount: $amount
            );

            $result = $employeeAllowanceDao->assignAllowanceToEmployee($newAllowance);
        }
        

        

        if ($result) {
            echo "Employee Allowance assigned successfully!";
        } else {
            echo "Failed to create allowance. Please try again.";
        }
        return;
        
    }

    

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}