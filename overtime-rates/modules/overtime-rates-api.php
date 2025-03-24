<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}


require_once __DIR__ . '/../OvertimeRate.php';
require_once __DIR__ . '/../OvertimeRateDao.php';
require_once __DIR__ . '/../OvertimeRateRepository.php';
require_once __DIR__ . '/../OvertimeRateService.php';

require_once __DIR__ . '/../OvertimeRateAssignment.php';
require_once __DIR__ . '/../OvertimeRateAssignmentDao.php';
require_once __DIR__ . '/../OvertimeRateAssignmentRepository.php';
require_once __DIR__ . '/../OvertimeRateAssignmentService.php';

require_once __DIR__ . '/../../departments/DepartmentDao.php';
require_once __DIR__ . '/../../job-titles/JobTitleDao.php';
require_once __DIR__ . '/../../employees/EmployeeDao.php';


require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../database/database.php';

try {
    $overtimeRateDao = new OvertimeRateDao($pdo);
    $departmentDao = new DepartmentDao($pdo);
    $jobTitleDao = new JobTitleDao($pdo);
    $employeeDao = new EmployeeDao($pdo);
    $overtimeRateAssignmentDao = new OvertimeRateAssignmentDao($pdo, $overtimeRateDao, $departmentDao, $jobTitleDao, $employeeDao);
    $overtimeRateAssignmentRepo = new OvertimeRateAssignmentRepository($overtimeRateAssignmentDao);
    $overtimeRateAssignmentService = new OvertimeRateAssignmentService($overtimeRateAssignmentRepo);
    $action = $_POST['action'] ?? '';
    if ($action === 'fetchAll'){
        $overtimeRatesId = isset($_POST['overtime_rates_assignment_id']) && $_POST['overtime_rates_assignment_id'] != null && $_POST['overtime_rates_assignment_id'] != '' ? (int) $_POST['overtime_rates_assignment_id'] : null;
        $departmentId = isset($_POST['department_id']) && $_POST['department_id'] != null && $_POST['department_id'] != '' ? (int) $_POST['department_id'] : null;
        $jobTitleId = isset($_POST['job_title_id']) && $_POST['job_title_id'] != null && $_POST['job_title_id'] != '' ? (int) $_POST['job_title_id'] : null;
        $employeeId = isset($_POST['employee_id']) && $_POST['employee_id'] != null && $_POST['employee_id'] != '' ? (int) $_POST['employee_id'] : null;
        $overtimeRateRepo = new OvertimeRateRepository($overtimeRateDao);
        $overtimeRateService = new OvertimeRateService($pdo, $overtimeRateRepo);
        $overtimeRateAssignment = new OvertimeRateAssignment(
            id: $overtimeRatesId,
            departmentId: $departmentId,
            jobTitleId: $jobTitleId,
            employeeId: $employeeId
        );
        $overtimeRateAssId = $overtimeRateAssignmentService->findOvertimeRateAssignmentId($overtimeRateAssignment);
        $result = $overtimeRateService->fetchOvertimeRates($overtimeRateAssId);
        $overtimeRates;
        if ($result !== ActionResult::FAILURE) {
            $overtimeRates = $result;
        }
        //print_r($overtimeRates);

        include __DIR__ . '/overtime-rates-table.php';
        return;
    }

    if ($action === 'assign'){
        $rates = isset($_POST['rates']) ? $_POST['rates'] : null;
        if(!$rates){
            return;
        }
        $overtimeRatesId = isset($_POST['overtime_rates_assignment_id']) && $_POST['overtime_rates_assignment_id'] != null && (int) $_POST['overtime_rates_assignment_id'] != '' ? (int) $_POST['overtime_rates_assignment_id'] : null;
        $departmentId = isset($_POST['department_id']) && $_POST['department_id'] != null && $_POST['department_id'] != '' ? (int) $_POST['department_id'] : null;
        $jobTitleId = isset($_POST['job_title_id']) && $_POST['job_title_id'] != null && $_POST['job_title_id'] != '' ? (int) $_POST['job_title_id'] : null;
        $employeeId = isset($_POST['employee_id']) && $_POST['employee_id'] != null && $_POST['employee_id'] != '' ? (int) $_POST['employee_id'] : null;
        foreach ($rates as $key => $rate) {
            $rates[$key]['overtime_rate_assignment_id'] = $overtimeRatesId;
        }
        // print_r($rates);
        // echo "Overtime Rates ID: " . ($overtimeRatesId ?? 'null') . "<br>";
        // echo "Department ID: " . ($departmentId ?? 'null') . "<br>";
        // echo "Job Title ID: " . ($jobTitleId ?? 'null') . "<br>";
        // echo "Employee ID: " . ($employeeId ?? 'null') . "<br>";
        $overtimeRateRepo = new OvertimeRateRepository($overtimeRateDao);
        $overtimeRateService = new OvertimeRateService($pdo, $overtimeRateRepo);
        $overtimeRateAssignment = [
            'id' => $overtimeRatesId,
            'department_id' => $departmentId,
            'job_title_id' => $jobTitleId,
            'employee_id' => $employeeId
        ];        

        $result = $overtimeRateAssignmentService->assignOvertimeRateAssignment($overtimeRateAssignment, $rates);
        //print_r($createResult);
        $createResult;

        if (isset($result['status']) && $result['status'] === 'success') {
            die("
            <script>
                showSuccessCreation();
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
        
        //print_r($overtimeRates);

        return;
    }



    echo "Invalid action specified.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}