<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../../Attendance.php';
require_once __DIR__ . '/../../AttendanceDao.php';
require_once __DIR__ . '/../../AttendanceRepository.php';
require_once __DIR__ . '/../../AttendanceService.php';

require_once __DIR__ . '/../../../includes/Helper.php';
require_once __DIR__ . '/../../../database/database.php';
require_once __DIR__ . '/../../../includes/session.php';

try {
    $attendanceDao = new AttendanceDao($pdo);
    $action = $_POST['action'] ?? '';

    if ($action === 'fetchAll') {
        $status = isset($_POST['filter_status']) && $_POST['filter_status'] ? $_POST['filter_status'] : null;
        $dateFilterColumn = isset($_POST['filter_date_column']) ? $_POST['filter_date_column'] : null;
        $dateStart = isset($_POST['filter_startDate']) && $dateFilterColumn !== "none" ? $_POST['filter_startDate'] : 0;
        $dateEnd = isset($_POST['filter_endDate']) && $dateFilterColumn !== "none" ? $_POST['filter_endDate'] : 0;
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $limit = isset($_POST['numberEntries']) ? $_POST['numberEntries'] : 10;
        $offset = ($page - 1) * $limit;
        
        $filterCriteria = [];

        $filterCriteria[] = [
            "column" => "work_schedule_snapshot.employee_id",
            "operator" => "=",
            "value" => $_SESSION['id']
        ];

        if(!empty($status)){
            $filterCriteria[] = [
                "column" => "attendance.attendance_status",
                "operator" => "=",
                "value" => $status
            ];
        }

        $filterCriteria[] = [
            "column" => "attendance.deleted_at",
            "operator" => "IS NULL"
        ];
        

        if((!empty($dateFilterColumn) && $dateFilterColumn !== "none") && !empty($dateStart) && !empty($dateEnd)){
            $filterCriteria[] = [
                "column" => "attendance." . $dateFilterColumn,
                "operator" => "BETWEEN",
                "lower_bound" => $dateStart,
                "upper_bound" => $dateEnd
            ];
        }

        $sortCriteria = [
            [
                "column" => "attendance." . $_POST['sort_by'],
                "direction" => $_POST['sort_order']
            ]
        ];
        $result = $attendanceDao->fetchAll([], $filterCriteria, $sortCriteria, $limit, $offset);
        $myAttendance;
        if ($result !== ActionResult::FAILURE) {
            $myAttendance = $result['result_set'];
        }

        $totalAttendance = $result["total_row_count"];
        $totalPages = ceil($totalAttendance / $limit);
        include __DIR__ . '/attendance-table.php';
        return;
    }


    echo "Invalid action specified.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}