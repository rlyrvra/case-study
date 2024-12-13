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

    if ($action === 'fetchAll') {
        $selectedColumns = ["id", "full_name", "job_title_title", "profile_picture", "access_role", "department_name", "email_address", "employee_code", "phone_number", "date_of_hire", "created_at"];
        $status = isset($_POST['filter_status']) && $_POST['filter_status'] ? $_POST['filter_status'] : "";
        $searchAt = isset($_POST['filter_searchAt']) && $_POST['filter_searchAt'] !== "none" ? $_POST['filter_searchAt'] : "";
        $searchFilter = isset($_POST['filter_search']) ? $_POST['filter_search'] : "";
        $departmentFilter = isset($_POST['filter_department_id']) && !empty($_POST['filter_department_id']) ? $_POST['filter_department_id'] : "";
        $dateFilterColumn = isset($_POST['filter_date_column']) ? $_POST['filter_date_column'] : "";
        $dateStart = isset($_POST['filter_startDate']) && $dateFilterColumn !== "none" ? $_POST['filter_startDate'] : 0;
        $dateEnd = isset($_POST['filter_endDate']) && $dateFilterColumn !== "none" ? $_POST['filter_endDate'] : 0;
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $limit = isset($_POST['numberEntries']) ? $_POST['numberEntries'] : 10;
        $offset = ($page - 1) * $limit;
        
        $filterCriteria = [];
        
        if(!empty($status) && $status == 'Archived'){
            $filterCriteria[] = [
                "column" => "employee.deleted_at",
                "operator" => "IS NULL"
            ];
        }else{
            $filterCriteria[] = [
                "column" => "employee.deleted_at",
                "operator" => "IS NULL"
            ];
        }

        if($_SESSION['access_role'] === 'Admin'){
            // do nothing
        }else if($_SESSION['access_role'] === 'Manager'){
            $filterCriteria[] = [
                "column" => "employee.manager_id" ,
                "operator" => "=",
                "value" => $_SESSION['id']
            ];
        }else if($_SESSION['access_role'] === 'Supervisor'){
            $filterCriteria[] = [
                "column" => "employee.supervisor_id" ,
                "operator" => "=",
                "value" => $_SESSION['id']
            ];
        }

        if(empty($searchAt) && !empty($searchFilter)){
            $filterCriteria[] = [
                'column' => 'employee.full_name', 
                'operator' => 'LIKE', 
                'value' => "%$searchFilter%", 
                'boolean' => 'OR'

            ];
            $filterCriteria[] = [
                'column' => 'job_title.title', 
                'operator' => 'LIKE', 
                'value' => "%$searchFilter%", 
                'boolean' => 'OR'
            ];
            $filterCriteria[] = [
                'column' => 'employee.email_address', 
                'operator' => 'LIKE', 
                'value' => "%$searchFilter%", 
                'boolean' => 'OR'
            ];
            $filterCriteria[] = [
                'column' => 'employee.employee_code', 
                'operator' => 'LIKE', 
                'value' => "%$searchFilter%", 
                'boolean' => 'OR'
            ];
        }

        if(!empty($searchAt) && !empty($searchFilter && $searchAt === "title")){
            $filterCriteria[] = [
                "column" => "job_title." . $searchAt, 
                "operator" => "LIKE",
                "value" => "%$searchFilter%"
            ];
        }else if(!empty($searchAt) && !empty($searchFilter)){
            $filterCriteria[] = [
                "column" => "employee." . $searchAt, 
                "operator" => "LIKE",
                "value" => "%$searchFilter%"
            ];
        }else{

        }

        if((!empty($dateFilterColumn) && $dateFilterColumn !== "none") && !empty($dateStart) && !empty($dateEnd)){
            $filterCriteria[] = [
                "column" => "employee." . $dateFilterColumn,
                "operator" => "BETWEEN",
                "lower_bound" => $dateStart,
                "upper_bound" => $dateEnd
            ];
        }

        if(!empty($departmentFilter)){
            $filterCriteria[] = [
                "column" => "employee.department_id", 
                "operator" => "=",
                "value" => $departmentFilter
            ];
        }
        



        $sortCriteria = [
            [
                "column" => "employee." . $_POST['sort_by'],
                "direction" => $_POST['sort_order']
            ]
        ];
        $employeeRepository = new EmployeeRepository($employeeDao);
        $employeeService = new EmployeeService($employeeRepository);
        $result = $employeeService->fetchAllEmployees($selectedColumns, $filterCriteria, $sortCriteria, $limit, $offset);
        $employees;
        if ($result !== ActionResult::FAILURE) {
            $employees = $result['result_set'];
        }

        $totalEmployees = $result["total_row_count"];
        $totalPages = ceil($totalEmployees / $limit);
        include __DIR__ . '/manage-employee-table.php';
        return;
    }

    if($action == 'delete'){
        $hashed_id = $_POST['md5_id'] ?? null;
        $employeeRepository = new EmployeeRepository($employeeDao);
        $employeeService = new EmployeeService($employeeRepository);
        $deleteResult = $employeeService->deleteEmployee($hashed_id);

        if ($deleteResult) {
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