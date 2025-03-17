<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../DepartmentService.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../database/database.php';

try {
    $departmentDao = new DepartmentDao($pdo);
    $action = $_POST['action'] ?? '';

    if ($action === 'fetchAll') {
        $status = isset($_POST['filter_status']) && $_POST['filter_status'] ? $_POST['filter_status'] : null;
        $searchAt = isset($_POST['filter_searchAt']) && $_POST['filter_searchAt'] !== "none" ? $_POST['filter_searchAt'] : null;
        $searchFilter = isset($_POST['filter_search']) ? $_POST['filter_search'] : null;
        $dateFilterColumn = isset($_POST['filter_date_column']) ? $_POST['filter_date_column'] : null;
        $dateStart = isset($_POST['filter_startDate']) && $dateFilterColumn !== "none" ? $_POST['filter_startDate'] : 0;
        $dateEnd = isset($_POST['filter_endDate']) && $dateFilterColumn !== "none" ? $_POST['filter_endDate'] : 0;
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $limit = isset($_POST['numberEntries']) ? $_POST['numberEntries'] : 10;
        $offset = ($page - 1) * $limit;
        $viewMode = isset($_POST['view_mode']) ? $_POST['view_mode'] : 'table';
        
        $filterCriteria = [];
        
        if(!empty($status)){
            $filterCriteria[] = [
                "column" => "department.status",
                "operator" => "=",
                "value" => $status
            ];
        }

        if(empty($searchAt) && !empty($searchFilter)){
            $filterCriteria[] = 
            [
                [
                    "column" => "department.description", 
                    "operator" => "LIKE",
                    "value" => "%$searchFilter%", 
                    'boolean' => 'OR'
                ],
                [
                    "column" => "department.name", 
                    "operator" => "LIKE",
                    "value" => "%$searchFilter%", 
                    'boolean' => 'OR'
                ]
            ];
        }

        if(!empty($searchFilter) && !empty($searchAt)){
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
            $totalDepartments = $result["total_row_count"];
            $totalPages = ceil($totalDepartments / $limit);
        }else if($result === ActionResult::FAILURE){
            $message = 'Failed to fetch departments. Please try again.';
            die('
            <script>
            showError(' . json_encode($message) 
            . ');
            </script>');
        }

        if($viewMode == 'table'){
            include __DIR__ . '/departments-table.php';
        }
        else{
            include __DIR__ . '/departments-table-card.php';
        }
        return;
    }

    if ($action === 'create') {

        $departmentData = $_POST['department'] ?? null;

        if ($departmentData == null) {
            die('
            <script>
            showCouldNotFindData();
            </script>');
            return;
        }
        $name = isset($departmentData['name']) && $departmentData['name'] !== '' ? $departmentData['name'] : null;
        $departmentHeadId = $departmentData['departmentHeadId'] !== '' && $departmentData['departmentHeadId'] !== 'None' ? (int) $departmentData['departmentHeadId'] : null;
        $description = isset($departmentData['description']) ? $departmentData['description'] : null;
        $status = isset($departmentData['status']) ? $departmentData['status'] : null;
        
        $newDepartment = new Department(
            id: null,
            name: $name,
            departmentHeadId: $departmentHeadId,
            description: $description,
            status: $status
        );
        $departmentRepository = new DepartmentRepository($departmentDao);
        $departmentService = new DepartmentService($departmentRepository);
        $result = $departmentService->createDepartment($newDepartment);
        
        if ($result === ActionResult::SUCCESS) {
            die('
            <script>
            showSuccessCreate();
            </script>');
        }else if($result === ActionResult::FAILURE){
            $message = 'Failed to create department. Please try again.';
            die('
            <script>
            showError(' . json_encode($message) 
            . ');
            </script>');
        }
        return;
    }

    if($action == 'delete'){

        $hashed_id = $_POST['md5_id'] ?? null;
        $departmentRepository = new DepartmentRepository($departmentDao);
        $departmentService = new DepartmentService($departmentRepository);
        $deleteResult = $departmentService->deleteDepartment($hashed_id);

        if ($deleteResult === ActionResult::SUCCESS) {
            die('
            <script>
            showSuccessDelete();
            </script>');
        }else if($deleteResult === ActionResult::FAILURE){
            $message = 'Failed to delete department. Please try again.';
            die('
            <script>
            showError(' . json_encode($message) 
            . ');
            </script>');
        }
        return;
    }


    if($action == 'update'){
        $departmentData = $_POST['department'] ?? null;
        if (!$departmentData) {
            die('
            <script>
            showCouldNotFindData();
            </script>');
            return;
        }
        
        $name = $departmentData['name'] ?? '';
        $departmentHeadId = $departmentData['departmentHeadId'] !== '' && $departmentData['departmentHeadId'] !== 'None'  ? (int) $departmentData['departmentHeadId'] : null;
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

        if ($updateResult === ActionResult::SUCCESS) {
            die('
            <script>
            showSuccessUpdate();
            </script>');
        }else if($updateResult === ActionResult::FAILURE){
            $message = 'Failed to update department. Please try again.';
            die('
            <script>
            showError(' . json_encode($message) 
            . ');
            </script>');
        }
        return;
    }

    $message = "Invalid action specified.";
    die('
    <script>
    showFatalError(' . json_encode($message) 
    . ');
    </script>');
} catch (Throwable  $e) {
    $message = "Fatal error: " . $e->getMessage();
    die('
    <script>
    showFatalError(' . json_encode($message) 
    . ');
    </script>');
}