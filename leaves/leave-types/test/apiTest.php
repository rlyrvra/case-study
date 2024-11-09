<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../LeaveTypeDao.php';
require_once __DIR__ . '/../LeaveType.php';
require_once __DIR__ . '/../../../includes/Helper.php';
require_once __DIR__ . '/../../../includes/enums/ErrorCode.php';
require_once __DIR__ . '/../../../database/database.php';

try {
    $userId = 1;
    $leaveTypeDao = new LeaveTypeDao($pdo);
    $action = $_POST['action'] ?? '';
    

    if ($action === 'fetchAll') {
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;
        $filterCriteria = [
            ["column" => "status", "operator" => "=", "value" => "Active"]
        ];
        $sortCriteria = [
            ["column" => "leave_type.created_at", "direction" => "DESC"]
        ];
        $data = $leaveTypeDao->fetchAll([], $filterCriteria, $sortCriteria);
        $leaveTypes = $data["result_set"];
        $totalLeaveTypes = $data["total_row_count"];
        $totalPages = ceil($totalLeaveTypes / $limit);
        include __DIR__ . '/leaveTypesTable.php';
        return;
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
                "column" => "leave_type.status",
                "operator" => "=",
                "value" => $status
            ];
        }
        if(!empty($searchFilter)){
            $filterCriteria[] = [
                "column" => "leave_type." . $searchAt,
                "operator" => "LIKE",
                "value" => "%$searchFilter%"
            ];
        }
        if((!empty($dateFilterColumn) && $dateFilterColumn !== "none") && !empty($dateStart) && !empty($dateEnd)){
            $filterCriteria[] = [
                "column" => "leave_type." . $dateFilterColumn,
                "operator" => "BETWEEN",
                "lower_bound" => $dateStart,
                "upper_bound" => $dateEnd
            ];
        }
        print_r($filterCriteria);
        
        $sortCriteria = [
            [
                "column" => "leave_type." . $_POST['sort_by'],
                "direction" => $_POST['sort_order']
            ]
        ];
        print_r($sortCriteria);
        $data = $leaveTypeDao->fetchAll([], $filterCriteria, $sortCriteria, $limit, $offset);
        $leaveTypes = $data["result_set"];
        $total_leave_types = $data["total_row_count"];
        $totalPages = ceil($total_leave_types / $_POST['numberEntries']);
        include __DIR__ . '/leaveTypesTable.php';
        return;

    }


    if ($action === 'create') {
        $leaveTypesData = $_POST['leave_type'] ?? null;

        if ($leaveTypesData) {
            $name = $leaveTypesData['name'] ?? '';
            $maximumNumberOfDays = $leaveTypesData['maximum_number_of_days'] ?? null;
            $isPaid = $leaveTypesData['is_paid'] ?? null;
            $description = $leaveTypesData['description'] ?? '';
            $status = $leaveTypesData['status'] ?? '';

            $newLeaveType = new LeaveType(
                id: null,
                name: $name,
                maximumNumberOfDays: $maximumNumberOfDays,
                isPaid: $isPaid,
                description: $description,
                status: $status
            );

            $result = $leaveTypeDao->create($newLeaveType, $userId);

            if ($result) {
                echo "Leave Type created successfully!";
            } else {
                echo "Failed to create LT. Please try again.";
            }
        } else {
            echo "Invalid LT data.";
        }
        return;
    }

    if($action == 'update'){
        $leaveTypeData = $_POST['leave_type'] ?? null;
        if ($leaveTypeData) {
            print_r($leaveTypeData);
            $hashed_id = $leaveTypeData['md5_id'] ?? null;
            $name = $leaveTypeData['name'] ?? '';
            $maxNumberOfDays = $leaveTypeData['maxNumberOfDays'] ?? null;
            $isPaid = $leaveTypeData['isPaid'] ?? null;
            $description = $leaveTypeData['description'] ?? null;
            $status = $leaveTypeData['status'] ?? null;

            $updatedLeaveType = new LeaveType(
                id: null,
                name: $name,
                maximumNumberOfDays: $maxNumberOfDays,
                isPaid: $isPaid,
                description: $description,
                status: $status
            );

            $updateResult = $leaveTypeDao->updateThruHash($updatedLeaveType, $userId, $hashed_id);

            if ($updateResult) {
                echo "LT deleted successfully!";
            } else {
                echo "Failed to LT department. Please try again.";
            }
        } else {
            echo "Invalid LT data.";
        }

        
        
        return;
    }



    if ($action === 'delete') {
        $hashed_id = $_POST['md5_id'] ?? null;
        $deleteResult = $leaveTypeDao->softDeleteThruHash($hashed_id, $userId);

        if ($deleteResult) {
            echo "Leave Type deleted successfully!";
        } else {
            echo "Failed to delete leave type. Please try again.";
        }
        return;
    }





    echo "Invalid action specified.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}