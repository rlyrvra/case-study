<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../../Attendance.php';
require_once __DIR__ . '/../../AttendanceDao.php';
require_once __DIR__ . '/../../AttendanceRepository.php';
require_once __DIR__ . '/../../AttendanceService.php';

require_once __DIR__ . '/../../../breaks/EmployeeBreak.php';
require_once __DIR__ . '/../../../breaks/EmployeeBreakDao.php';
require_once __DIR__ . '/../../../breaks/EmployeeBreakRepository.php';
require_once __DIR__ . '/../../../breaks/EmployeeBreakService.php';

require_once __DIR__ . '/../../../includes/Helper.php';
require_once __DIR__ . '/../../../database/database.php';
require_once __DIR__ . '/../../../includes/session.php';

try {
    $attendanceDao = new AttendanceDao($pdo);
    $employeeBreakDao = new EmployeeBreakDao($pdo);
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

        // $filterCriteria[] = [
        //     "column" => "work_schedule_snapshot.employee_id",
        //     "operator" => "=",
        //     "value" => $_SESSION['id']
        // ];

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
        $myBreak;
        $myAttendance;
        if ($result !== ActionResult::FAILURE) {
            $myAttendance = $result['result_set'];

            $uniqueAttendanceRecords = [];
            foreach ($myAttendance as $attendanceRecord) {
                $uniqueAttendanceRecords[$attendanceRecord['date']][$attendanceRecord['work_schedule_snapshot_id']] = $attendanceRecord;
            }

            $employeeBreakRecords = [];
            foreach ($uniqueAttendanceRecords as $date => $uniqueRecords) {
                foreach ($uniqueRecords as $uniqueAttendanceRecord) {
                    $workScheduleSnapshotId = $uniqueAttendanceRecord['work_schedule_snapshot_id'        ];

                    $workScheduleStartTime  = $uniqueAttendanceRecord['work_schedule_snapshot_start_time'];
                    $workScheduleEndTime    = $uniqueAttendanceRecord['work_schedule_snapshot_end_time'  ];

                    $workScheduleStartDateTime = new DateTime($date . ' ' . $workScheduleStartTime);
                    $workScheduleEndDateTime   = new DateTime($date . ' ' . $workScheduleEndTime  );

                    if ($workScheduleEndDateTime <= $workScheduleStartDateTime) {
                        $workScheduleEndDateTime->modify('+1 day');
                    }

                    $earlyCheckInWindow = $uniqueAttendanceRecord['work_schedule_snapshot_minutes_can_check_in_before_shift'];
                    $adjustedWorkScheduleStartDateTime = (clone $workScheduleStartDateTime)
                        ->modify('-' . $earlyCheckInWindow . ' minutes');

                    $employeeBreakRecordColumns = [
                    ];

                    $employeeBreakRecordFilterCriteria = [
                        [
                            'column'   => 'employee_break.deleted_at',
                            'operator' => 'IS NULL'
                        ],
                        [
                            'column'   => 'break_schedule_snapshot.work_schedule_snapshot_id',
                            'operator' => '='                                                ,
                            'value'    => $workScheduleSnapshotId
                        ],
                        [
                            'column'      => 'employee_break.created_at'                              ,
                            'operator'    => 'BETWEEN'                                                ,
                            'lower_bound' => $adjustedWorkScheduleStartDateTime->format('Y-m-d H:i:s'),
                            'upper_bound' => $workScheduleEndDateTime          ->format('Y-m-d H:i:s')
                        ]
                    ];

                    $employeeBreakRecordSortCriteria = [
                        [
                            'column'    => 'employee_break.start_time',
                            'direction' => 'DESC'
                        ],
                        [
                            'column'    => 'employee_break.created_at',
                            'direction' => 'DESC'
                        ]
                    ];

                    $employeeBreakRecords[$workScheduleSnapshotId] = $employeeBreakDao->fetchAll(
                        columns       : $employeeBreakRecordColumns       ,
                        filterCriteria: $employeeBreakRecordFilterCriteria,
                        sortCriteria  : $employeeBreakRecordSortCriteria
                    );
                }
            }
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