<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../DepartmentDao.php';
require_once __DIR__ . '/../DepartmentService.php';
require_once __DIR__ . '/../DepartmentRepository.php';
require_once __DIR__ . '/../Department.php';
require_once __DIR__ . '/../../job-titles/JobTitle.php';
require_once __DIR__ . '/../../job-titles/JobTitleDao.php';
require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../includes/enums/ErrorCode.php';
require_once __DIR__ . '/../../database/database.php';

try {
    $userId = 1;
    $departmentDao = new DepartmentDao($pdo);
    $action = $_POST['action'] ?? '';
    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $limit = 5;
    $offset = ($page - 1) * $limit;

    if ($action === 'fetchAll') {
        $data = $departmentDao->fetchAll([], [["column" => "status", "operator" => "=", "value" => "Active"]], [["column" => "department.created_at", "direction" => "DESC"]], $limit, $offset);
        $departments = $data["result_set"];
        $totalDepartments = $data["total_row_count"];
        $totalPages = ceil($totalDepartments / $limit);

        $jobTitleDao = new JobTitleDao($pdo);
        $filterCriteria = [
            [
                "column" => "job_title.status",
                "operator" => "=",
                "value" => "Active"
            ]
        ];
        $data2 = $jobTitleDao->fetchAll(["id", "title"], $filterCriteria);
        $jobTitles = $data2["result_set"];
        print_r($jobTitles);
        include __DIR__ . '/departmentsTable.php';
        return;
    }


    if ($action === 'create') {
        $departmentData = $_POST['department'] ?? null;
        if ($departmentData == null) {
            echo "Invalid department data.";
            return;
        }
        $name = $departmentData['name'] ?? '';
        $departmentHeadId = $departmentData['departmentHeadId'] !== '' ? (int) $departmentData['departmentHeadId'] : null;

        $newDepartment = new Department(
            id: null,
            name: $name,
            departmentHeadId: $departmentHeadId,
            description: null,
            status: "Active"
        );
        $departmentRepository = new DepartmentRepository($departmentDao);
        $departmentService = new DepartmentService($departmentRepository);
        $result = $departmentService->createDepartment($newDepartment);
        if ($result !== ActionResult::FAILURE) {
            echo "Department created successfully!";
        } else {
            echo "Failed to create department. Please try again.";
        }
        return;
    }


    if($action === 'fetchAllSort'){
        $status = $_POST['filter_status'] && $_POST['filter_status'] ? $_POST['filter_status'] : null;
        $searchAt = isset($_POST['filter_searchAt']) && $_POST['filter_searchAt'] !== "none" ? $_POST['filter_searchAt'] : null;
        $searchFilter = $_POST['filter_search'];
        $dateFilterColumn = $_POST['filter_date_column'];
        $dateStart = isset($_POST['filter_startDate']) && $dateFilterColumn !== "none" ? $_POST['filter_startDate'] : 0;
        $dateEnd = isset($_POST['filter_endDate']) && $dateFilterColumn !== "none" ? $_POST['filter_endDate'] : 0;
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $limit = isset($_POST['numberEntries']) ? $_POST['numberEntries'] : 5;
        $offset = ($page - 1) * $limit;
        // test data
        
        $filterCriteria = [];
        
        if(!empty($status)){
            $filterCriteria[] = [
                "column" => "department.status",
                "operator" => "=",
                "value" => $status
            ];
        }
        if(!empty($searchFilter)){
            $filterCriteria[] = [
                "column" => "department." . $searchAt, 
                "operator" => "LIKE",
                "value" => "%$searchFilter%"
            ];
        }
        if((!empty($dateFilterColumn) && $dateFilterColumn !== "none") && !empty($dateStart) && !empty($dateEnd)){
            $filterCriteria[] = [
                "column" => "department." . $dateFilterColumn,
                "operator" => "BETWEEN",
                "lower_bound" => $dateStart,
                "upper_bound" => $dateEnd
            ];
        }
        
        $sortCriteria = [
            [
                "column" => "department." . $_POST['sort_by'],
                "direction" => $_POST['sort_order']
            ]
        ];
        $departmentRepository = new DepartmentRepository($departmentDao);
        $departmentService = new DepartmentService($departmentRepository);
        $result = $departmentService->fetchAllDepartments([], $filterCriteria, $sortCriteria, $limit, $offset);
        $departments;
        if ($result !== ActionResult::FAILURE) {
            $departments = $result['result_set'];
        }

        $totalDepartments = $result["total_row_count"];
        $totalPages = ceil($totalDepartments / $_POST['numberEntries']);
        include __DIR__ . '/departmentsTable.php';
        return;

    }


    if($action == 'update'){
        $departmentData = $_POST['department'] ?? null;
        if ($departmentData) {
            print_r($departmentData);
            $name = $departmentData['name'] ?? '';
            $departmentHeadId = $departmentData['departmentHeadId'] !== '' ? (int) $departmentData['departmentHeadId'] : null;
            $departmentDescription = $departmentData['departmentDescription'] ?? null;
            $departmentStatus = $departmentData['departmentStatus'] ?? null;
            $hashed_id = $departmentData['md5_id'] ?? null;


            $updatedDepartment = new Department(
                id: $hashed_id,
                name: $name,
                departmentHeadId: $departmentHeadId,
                description: $departmentDescription,
                status: $departmentStatus
            );
            $departmentRepository = new DepartmentRepository($departmentDao);
            $departmentService = new DepartmentService($departmentRepository);
            $updateResult = $departmentService->updateDepartment($updatedDepartment);

            if ($updateResult) {
                echo "Department updated successfully!";
            } else {
                echo "Failed to update department. Please try again.";
            }
        } else {
            echo "Invalid department data.";
        }
        
        return;
    }


    if($action == 'delete'){
        $hashed_id = $_POST['md5_id'] ?? null;
        $departmentRepository = new DepartmentRepository($departmentDao);
        $departmentService = new DepartmentService($departmentRepository);
        $updateResult = $departmentService->deleteDepartment($hashed_id);

        if ($deleteResult) {
            echo "Department deleted successfully!";
        } else {
            echo "Failed to delete department. Please try again.";
        }
        return;
    }




    echo "Invalid action specified.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}