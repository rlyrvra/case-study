<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../JobTitleDao.php';
require_once __DIR__ . '/../JobTitle.php';
require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../includes/enums/ErrorCode.php';
require_once __DIR__ . '/../../database/database.php';

try {
    $userId = 1;
    $jobTitleDao = new JobTitleDao($pdo);
    $action = $_POST['action'] ?? '';
    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $limit = 5;
    $offset = ($page - 1) * $limit;

    if ($action === 'fetchAll') {
        $data = $jobTitleDao->fetchAll([], [], [["column" => "job_title_name", "direction" => "DESC"], ["column" => "id", "direction" => "ASC"]]);
        $jobTitles = $data["result_set"];
        $totalJobTitles = $data["total_row_count"];
        $totalPages = ceil($totalJobTitles / $limit);
        include __DIR__ . '/jobTitlesTable.php';
        return;
    }
    
    if ($action === 'create') {
        // $job_titleData = $_POST['job_title'] ?? null;

        // if ($job_titleData) {
        //     $name = $job_titleData['name'] ?? '';
        //     $job_titleHeadId = $job_titleData['job_titleHeadId'] ?? null;

        //     $newjob_title = new job_title(
        //         id: null,
        //         name: $name,
        //         job_titleHeadId: $job_titleHeadId,
        //         description: null,
        //         status: "Active"
        //     );

        //     $result = $job_titleDao->create($newjob_title, 1);

        //     if ($result) {
        //         echo "job_title created successfully!";
        //     } else {
        //         echo "Failed to create job_title. Please try again.";
        //     }
        // } else {
        //     echo "Invalid job_title data.";
        // }
        // return;
    }

    if($action === 'fetchAllSort'){
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
        print_r($filterCriteria);
        
        $sortCriteria = [
            [
                "column" => "job_title." . $_POST['sort_by'],
                "direction" => $_POST['sort_order']
            ]
        ];
        print_r($sortCriteria);
        $data = $jobTitleDao->fetchAll([], $filterCriteria, $sortCriteria, $limit, $offset);
        $jobTitles = $data["result_set"];
        $total_job_titles = $data["total_row_count"];
        $totalPages = ceil($total_job_titles / $_POST['numberEntries']);
        include __DIR__ . '/jobTitlesTable.php';
        return;

    }

    if($action == 'updateJobTitleClick'){
        $hashed_id = $_POST['md5_id'] ?? null;
        

        echo $hashed_id;
        
        include __DIR__ . '/updateOverlay.php';
        return;
    }

    
    echo "Invalid action specified.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}