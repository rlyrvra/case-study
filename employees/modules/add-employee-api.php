<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../EmployeeDao.php';
require_once __DIR__ . '/../EmployeeService.php';
require_once __DIR__ . '/../EmployeeRepository.php';
require_once __DIR__ . '/../Employee.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../includes/enums/ErrorCode.php';
require_once __DIR__ . '/../../database/database.php';

require_once __DIR__ . '/../../includes/session.php';

try {
    $employeeDao = new EmployeeDao($pdo);
    $action = $_POST['action'] ?? '';

    if($action == 'update'){
        $hashed_id = $_POST['md5_id'] ?? null;
        $employeeRepository = new EmployeeRepository($employeeDao);
        $employeeService = new EmployeeService($employeeRepository);
        $updateResult = $employeeService->updateEmployeeThruHash($updatedEmployee, $hashed_id);

        if ($$updateResult) {
            echo "Employee deleted successfully!";
        } else {
            echo "Failed to delete employee. Please try again.";
        }
        return;
    }


    echo "Invalid action specified.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}