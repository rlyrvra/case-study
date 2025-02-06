<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../JobTitleDao.php';
require_once __DIR__ . '/../JobTitleService.php';
require_once __DIR__ . '/../JobTitleRepository.php';
require_once __DIR__ . '/../JobTitle.php';
require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../includes/enums/ErrorCode.php';
require_once __DIR__ . '/../../database/database.php';

try {
    $jobTitleDao = new JobTitleDao($pdo);
    $action = $_POST['action'] ?? '';

    if($action === 'fetchAll'){
        $status = $_POST['filter_status'];
        $searchAt = isset($_POST['filter_searchAt']) & $_POST['filter_searchAt'] !== "none" ? $_POST['filter_searchAt'] : null;
        $searchFilter = $_POST['filter_search'];
        $dateFilterColumn = $_POST['filter_date_column'];
        $dateStart = isset($_POST['filter_startDate']) && $dateFilterColumn !== "none" ? $_POST['filter_startDate'] : 0;
        $dateEnd = isset($_POST['filter_endDate']) && $dateFilterColumn !== "none" ? $_POST['filter_endDate'] : 0;
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $limit = isset($_POST['numberEntries']) ? $_POST['numberEntries'] : 5;
        $offset = ($page - 1) * $limit;
        
        
        $filterCriteria = [];
        
        if(!empty($status)){
            $filterCriteria[] = [
                "column" => "job_title.status",
                "operator" => "=",
                "value" => $status
            ];
        }
        if(!empty($searchFilter)){
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
        $result = $jobTitleService->fetchAllJobTitles([], $filterCriteria, $sortCriteria, $limit, $offset);
        $jobTitles;
        if ($result !== ActionResult::FAILURE) {
            $jobTitles = $result['result_set'];
        }

        $totalDepartments = $result["total_row_count"];
        $totalPages = ceil($totalDepartments / $limit);
        include __DIR__ . '/job-titles-table.php';
        return;

    }


    if ($action === 'create') {
        $jobTitleData = $_POST['job_title'] ?? null;

        if (!$jobTitleData) {
            echo "Invalid JT data.";
            return;
            
        } 

        $jobTitleTitle = $jobTitleData['title'] ?? '';
        $jobTitleDepartmentId = $jobTitleData['department_id'] ?? null;
        $jobTitledescription = $jobTitleData['description'] ?? null;
        $jobTitleStatus = $jobTitleData['status'] ?? null;

        $newJobTitle = new JobTitle(
            id: null,
            title: $jobTitleTitle,
            departmentId: $jobTitleDepartmentId,
            description: $jobTitledescription,
            status: $jobTitleStatus
        );

        $jobTitleRepository = new JobTitleRepository($jobTitleDao);
        $jobTitleService = new JobTitleService($jobTitleRepository);
        $result = $jobTitleService->createJobTitle($newJobTitle);

        if ($result) {
            echo "Job Title created successfully!";
        } else {
            echo "Failed to JT. Please try again.";
        }

        return;
    }

    if($action == 'update'){
        
        $jobTitleData = $_POST['job_title'] ?? null;
        if (!$jobTitleData) {
            echo "Invalid job title data.";
            return;
        }

        $hashed_id = $jobTitleData['md5_id'] ?? null;
        $jobTitleTitle = $jobTitleData['title'] ?? '';
        $jobTitleDepartmentId = $jobTitleData['department_id'] ?? null;
        $jobTitledescription = $jobTitleData['description'] ?? null;
        $jobTitleStatus = $jobTitleData['status'] ?? null;


        $updateJobTitle = new JobTitle(
            id: $hashed_id,
            title: $jobTitleTitle,
            departmentId: $jobTitleDepartmentId,
            description: $jobTitledescription,
            status: $jobTitleStatus
        );

        //echo "$hashed_id, $jobTitleTitle, $jobTitleDepartmentId, $jobTitledescription, $jobTitleStatus </br>";

        $jobTitleRepository = new JobTitleRepository($jobTitleDao);
        $jobTitleService = new JobTitleService($jobTitleRepository);
        $result = $jobTitleService->updateJobTitle($updateJobTitle);

        if ($result) {
            echo "Job Title updated successfully!";
        } else {
            echo "Failed to JT. Please try again.";
        }
        
        return;
    }

    if($action == 'delete'){
        $hashed_id = $_POST['md5_id'] ?? null;
        $jobTitleRepository = new JobTitleRepository($jobTitleDao);
        $jobTitleService = new JobTitleService($jobTitleRepository);
        $result = $jobTitleService->deleteJobTitle($hashed_id);

        if ($result) {
            echo "JT deleted successfully!";
        } else {
            echo "Failed to JT. Please try again.";
        }
        return;
    }




    echo "Invalid action specified.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}