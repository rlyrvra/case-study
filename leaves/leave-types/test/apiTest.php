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
    $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
    $limit = 5;
    $offset = ($page - 1) * $limit;
    

    if ($action === 'fetchAll') {
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
                echo "LT updated successfully!";
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