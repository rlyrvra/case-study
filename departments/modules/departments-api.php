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
        $selectedColumns = [
            "id", 
            "name", 
            "department_head_id", 
            "description", 
            "status", 
            "created_at", 
            "updated_at", 
            "deleted_at", 
            "department_head_full_name"
        ];
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
        $result = $departmentService->fetchAllDepartments($selectedColumns, $filterCriteria, $sortCriteria, $limit, $offset);
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
        
        $departmentRepository = new DepartmentRepository($departmentDao);
        $departmentService = new DepartmentService($departmentRepository);
        $result = $departmentService->createDepartment($_POST['department']);
        
        if (isset($result['status']) && $result['status'] === 'success') {
            die("
            <script>
                showSuccessCreate(" . json_encode($result['message']) . ");
            </script>
            ");
        } else if (isset($result['status']) && $result['status'] === 'error') {
            die("
            <script>
                showError(" . json_encode($result['message']) . ");
            </script>
            ");
        } else if (isset($result['status']) && $result['status'] === 'invalid_input'){
            die("
            <script>
                showValidationError(" . json_encode($result['errors']) . ");
                $('#add-departments-modal').modal('show');
            </script>
            ");
        }

        return;
    }

    if($action == 'delete'){

        $departmentData = $_POST['department'] ?? null;
        if ($departmentData == null) {
            die('
            <script>
                showCouldNotFindData();
            </script>');
            return;
        }
        $departmentId = $departmentData['id'];
        
        $departmentRepository = new DepartmentRepository($departmentDao);
        $departmentService = new DepartmentService($departmentRepository);
        $result = $departmentService->deleteDepartment($departmentId);

        if (isset($result['status']) && $result['status'] === 'success') {
            die("
            <script>
                showSuccessDelete();
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
                $('#update_departments_modal').modal('show');
            </script>
            ");
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

        $departmentRepository = new DepartmentRepository($departmentDao);
        $departmentService = new DepartmentService($departmentRepository);
        $result = $departmentService->updateDepartment($_POST['department']);

        if (isset($result['status']) && $result['status'] === 'success') {
            die("
            <script>
                showSuccessUpdate();
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

    if ($action === 'printFetch'){
        $type = isset($_POST['type']) && $_POST['type'] ? $_POST['type'] : null;
        if(!$type){
            return;
        }
        if($type === 'Department + Job Title'){
            fetchAllJoinedRecord($type);
            return;
        }
        if($type === 'Department + Job Title + Employees'){
            fetchAllJoinedRecord($type);
            return;
        }

        $selectedColumns = [
            "name", 
            "department_head_full_name", 
            "description", 
            "status", 
            "created_at", 
            "updated_at", 
            "deleted_at"
        ];

        $status = isset($_POST['filter_status']) && $_POST['filter_status'] ? $_POST['filter_status'] : null;
        $searchAt = isset($_POST['filter_searchAt']) && $_POST['filter_searchAt'] !== "none" ? $_POST['filter_searchAt'] : null;
        $searchFilter = isset($_POST['filter_search']) ? $_POST['filter_search'] : null;
        $dateFilterColumn = isset($_POST['filter_date_column']) ? $_POST['filter_date_column'] : null;
        $dateStart = isset($_POST['filter_startDate']) && $dateFilterColumn !== "none" ? $_POST['filter_startDate'] : 0;
        $dateEnd = isset($_POST['filter_endDate']) && $dateFilterColumn !== "none" ? $_POST['filter_endDate'] : 0;
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $limit = isset($_POST['numberEntries']) ? $_POST['numberEntries'] : 10;
        $offset = ($page - 1) * $limit;
        
        
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
                "column" => $searchAt, 
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
        $result = $departmentService->fetchAllDepartments($selectedColumns, $filterCriteria, $sortCriteria, $limit, $offset);
        $departments;
        if (isset($result['result_set']) && !empty($result['result_set'])) {
            $departments = $result['result_set'];
            $totalDepartments = $result["total_row_count"];
            $totalPages = ceil($totalDepartments / $limit);
        } else if(empty($departments)){
            $message = 'No records found. Printing failed.';
            die('
            <script>
            showError(' . json_encode($message) 
            . ');
            </script>');
        } else if($result === ActionResult::FAILURE){
            $message = 'Failed to fetch departments. Please try again.';
            die('
            <script>
            showError(' . json_encode($message) 
            . ');
            </script>');
        }

        include __DIR__ . '/department-pdf.php';
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


function fetchAllJoinedRecord($type){
    global $pdo;
    if($type === 'Department + Job Title'){
        $selectedColumns = [
            "name", 
            "department_head_full_name", 
            "description", 
            "status", 
            "created_at", 
            "updated_at", 
            "deleted_at", 
            "job_title",
            "job_title_status"
        ];
    }
    if($type === 'Department + Job Title + Employees'){
        $selectedColumns = [
            "name", 
            "department_head_full_name", 
            "description", 
            "status", 
            "created_at", 
            "updated_at", 
            "deleted_at", 
            "job_title",
            "job_title_status",
            "employee_full_name",
            "employee_code",
            "employee_supervisor_full_name",
            "employee_deleted_at"
        ];
    }
    $status = isset($_POST['filter_status']) && $_POST['filter_status'] ? $_POST['filter_status'] : null;
    $searchAt = isset($_POST['filter_searchAt']) && $_POST['filter_searchAt'] !== "none" ? $_POST['filter_searchAt'] : null;
    $searchFilter = isset($_POST['filter_search']) ? $_POST['filter_search'] : null;
    $dateFilterColumn = isset($_POST['filter_date_column']) ? $_POST['filter_date_column'] : null;
    $dateStart = isset($_POST['filter_startDate']) && $dateFilterColumn !== "none" ? $_POST['filter_startDate'] : 0;
    $dateEnd = isset($_POST['filter_endDate']) && $dateFilterColumn !== "none" ? $_POST['filter_endDate'] : 0;
    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $limit = isset($_POST['numberEntries']) ? $_POST['numberEntries'] : 10;
    $offset = ($page - 1) * $limit;
    
    
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
            "column" => $searchAt,
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
    $departmentDao = new DepartmentDao($pdo);
    $departmentRepo = new DepartmentRepository($departmentDao);
    $departmentService = new DepartmentService($departmentRepo);
    $result = $departmentService->fetchAllDepartments($selectedColumns, $filterCriteria, $sortCriteria, $limit, $offset);
    $departments = [];
    if ($result !== ActionResult::FAILURE) {
        $departments = $result['result_set'];
        $totalDepartments = $result["total_row_count"];
        $totalPages = ceil($totalDepartments / $limit);
    } else if(empty($departments)){
        $message = 'No records found. Printing failed.';
        die('
        <script>
        showError(' . json_encode($message) 
        . ');
        </script>');
    } else if($result === ActionResult::FAILURE){
        $message = 'Failed to fetch departments. Please try again.';
        die('
        <script>
        showError(' . json_encode($message) 
        . ');
        </script>');
    }
    
    include __DIR__ . '/department-pdf.php';
}