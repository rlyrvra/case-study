<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../JobTitleService.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../database/database.php';

try {
    $jobTitleDao = new JobTitleDao($pdo);
    $action = $_POST['action'] ?? '';

    if($action === 'fetchAll'){
        $selectedColumns = [
            "id", 
            "title", 
            "department_id",
            "department_name",
            "description", 
            "status", 
            "created_at", 
            "updated_at", 
            "deleted_at"
        ];
        $status = $_POST['filter_status'];
        $searchAt = isset($_POST['filter_searchAt']) & $_POST['filter_searchAt'] !== "none" ? $_POST['filter_searchAt'] : null;
        $searchFilter = $_POST['filter_search'];
        $dateFilterColumn = $_POST['filter_date_column'];
        $dateStart = isset($_POST['filter_startDate']) && $dateFilterColumn !== "none" ? $_POST['filter_startDate'] : 0;
        $dateEnd = isset($_POST['filter_endDate']) && $dateFilterColumn !== "none" ? $_POST['filter_endDate'] : 0;
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $limit = isset($_POST['numberEntries']) ? $_POST['numberEntries'] : 5;
        $offset = ($page - 1) * $limit;
        $viewMode = isset($_POST['view_mode']) ? $_POST['view_mode'] : 'table';
        
        
        $filterCriteria = [];
        

        if(!empty($status)){
            $filterCriteria[] = [
                "column" => "job_title.status",
                "operator" => "=",
                "value" => $status
            ];
        }

        $searchColumns = ['title', 'description'];
        if(empty($searchAt) && !empty($searchFilter)){
            foreach($searchColumns as $searchColumn){
                $filterCriteria[] = [
                    "column" => "job_title." . $searchColumn, 
                    "operator" => "LIKE",
                    "value" => "%$searchFilter%", 
                    'boolean' => 'OR'
    
                ];
            }
            
        }

        if(!empty($searchFilter) && !empty($searchAt)){
            $filterCriteria[] = [
                "column" => "job_title." . $searchAt,
                "operator" => "LIKE",
                "value" => "%$searchFilter%"
            ];
        }


        if((!empty($dateFilterColumn) && $dateFilterColumn !== "none") && !empty($dateStart) && !empty($dateEnd)){
            $filterCriteria[] = [
                "column" => "job_title." . $dateFilterColumn,
                "operator" => "BETWEEN",
                "lower_bound" => $dateStart,
                "upper_bound" => $dateEnd
            ];
        }
        
        $sortCriteria = [
            [
                "column" => "job_title." . $_POST['sort_by'],
                "direction" => $_POST['sort_order']
            ]
        ];
        $jobTitleRepository = new JobTitleRepository($jobTitleDao);
        $jobTitleService = new JobTitleService($jobTitleRepository);
        $result = $jobTitleService->fetchAllJobTitles($selectedColumns, $filterCriteria, $sortCriteria, $limit, $offset);
        $jobTitles;
        $totalJobTitles = 0;
        if ($result !== ActionResult::FAILURE){
            $jobTitles = $result['result_set'];
        }else if($result === ActionResult::FAILURE){
            $message = 'Failed to fetch job titles. Please try again.';
            die('
            <script>
            showError(' . json_encode($message) 
            . ');
            </script>');
        }

        $totalJobTitles = $result["total_row_count"];
        $totalPages = ceil($totalJobTitles / $limit);
        if($viewMode == 'table'){
            include __DIR__ . '/job-titles-table.php';
        }
        else{
            include __DIR__ . '/job-titles-table-card.php';
        }
        
        return;

    }


    if ($action === 'create') {
        $jobTitleData = $_POST['job_title'] ?? null;

        if ($jobTitleData == null) {
            die('
            <script>
            showCouldNotFindData();
            </script>');
            return;
        }

        $jobTitleRepository = new JobTitleRepository($jobTitleDao);
        $jobTitleService = new JobTitleService($jobTitleRepository);
        $result = $jobTitleService->createJobTitle($jobTitleData);

        if (isset($result['status']) && $result['status'] === 'success') {
            die("
            <script>
                showSuccessCreate();
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

    if($action == 'update'){
        
        $jobTitleData = $_POST['job_title'] ?? null;
        if (!$jobTitleData) {
            die('
            <script>
                showCouldNotFindData();
            </script>');
            return;
        }

        //echo "$hashed_id, $jobTitleTitle, $jobTitleDepartmentId, $jobTitledescription, $jobTitleStatus </br>";

        $jobTitleRepository = new JobTitleRepository($jobTitleDao);
        $jobTitleService = new JobTitleService($jobTitleRepository);
        $result = $jobTitleService->updateJobTitle($jobTitleData);

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

    if($action == 'delete'){
        $jobTitleData = $_POST['job_title'] ?? null;
        if (!$jobTitleData) {
            die('
            <script>
                showCouldNotFindData();
            </script>');
            return;
        }

        $hashed_id = $jobTitleData['id'] ?? null;
        $jobTitleRepository = new JobTitleRepository($jobTitleDao);
        $jobTitleService = new JobTitleService($jobTitleRepository);
        $result = $jobTitleService->deleteJobTitle($hashed_id);

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