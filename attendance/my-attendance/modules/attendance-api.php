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

require_once __DIR__ . '/../../../company-profile/CompanyProfileDao.php';

require_once __DIR__ . '/../../../includes/Helper.php';
require_once __DIR__ . '/../../../database/database.php';
require_once __DIR__ . '/../../../includes/session.php';

try {
    $attendanceDao = new AttendanceDao($pdo);
    $employeeBreakDao = new EmployeeBreakDao($pdo);
    $companyProfileDao = new CompanyProfileDao($pdo);
    $action = $_POST['action'] ?? '';

    if ($action === 'fetchAll') {
        $month = isset($_POST['filter_month']) && $_POST['filter_month'] ? $_POST['filter_month'] : null;
        $year = isset($_POST['filter_year']) && $_POST['filter_year'] ? $_POST['filter_year'] : null;
        $status = isset($_POST['filter_status']) && $_POST['filter_status'] ? $_POST['filter_status'] : null;
        $dateFilterColumn = isset($_POST['filter_date_column']) ? $_POST['filter_date_column'] : null;
        $dateStart = isset($_POST['filter_startDate']) && $dateFilterColumn !== "none" ? $_POST['filter_startDate'] : 0;
        $dateEnd = isset($_POST['filter_endDate']) && $dateFilterColumn !== "none" ? $_POST['filter_endDate'] : 0;
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $limit = isset($_POST['numberEntries']) ? $_POST['numberEntries'] : 10;
        $offset = ($page - 1) * $limit;
        $viewMode = isset($_POST['view_mode']) ? $_POST['view_mode'] : 'table';
        
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

        if(!empty($month) && !empty($year)){
            $filterCriteria[] = [
                "column" => "DATE_FORMAT(attendance.date, '%M')",
                "operator" => "=",
                "value" => $month
            ];
            $filterCriteria[] = [
                "column" => "YEAR(attendance.date)",
                "operator" => "=",
                "value" => $year
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
        if($viewMode == 'table'){
            include __DIR__ . '/attendance-table.php';
        }
        else{
            include __DIR__ . '/attendance-table-card.php';
        }
        
        return;
    }

    if ($action === 'downloadDTR'){
        $filterCriteria = [
            [
                "column" => "attendance.deleted_at",
                "operator" => "IS NULL"
            ],
            [
                'column'      => 'attendance.date'                              ,
                'operator'    => 'BETWEEN'                                                ,
                'lower_bound' => $_POST['pay_period_start_date'],
                'upper_bound' => $_POST['pay_period_end_date']
            ],
            [
                "column" => "work_schedule_snapshot.employee_id",
                "operator" => "=",
                "value" => $_SESSION['id']
            ]
        ];
        $result = $attendanceDao->fetchAll(
        [
            "date",
            "check_in_time",
            "check_out_time",
            "total_break_duration_in_minutes",
            "total_hours_worked",
            "late_check_in",
            "early_check_out",
            "overtime_hours",
            "is_overtime_approved",
            "attendance_status",
            "remarks",
            "work_schedule_snapshot_employee_id"
        ], $filterCriteria);
        $myAttendance;
        if ($result !== ActionResult::FAILURE) {
            $myAttendance = $result['result_set'];
        }
        //print_r($myAttendance);

        $totalAttendance = $result["total_row_count"];

        $employeeBreakFilterCriteria = [
            [
                'column'   => 'employee_break.deleted_at',
                'operator' => 'IS NULL'
            ],
            [
                'column'   => 'work_schedule_snapshot.employee_id'               ,
                'operator' => '='                                                ,
                'value'    => $_SESSION['id']
            ],
            [
                'column'      => 'employee_break.created_at'                              ,
                'operator'    => 'BETWEEN'                                                ,
                'lower_bound' => $_POST['pay_period_start_date'],
                'upper_bound' => $_POST['pay_period_end_date']
            ]
        ];

        $result = $employeeBreakDao->fetchAll(
        [
            'break_type_snapshot_name',
            'start_time',
            'end_time',
            'break_duration_in_minutes',
            "work_schedule_snapshot_employee_id"
        ], 
        $employeeBreakFilterCriteria);
        $myBreaks;
        if ($result !== ActionResult::FAILURE) {
            $myBreaks = $result['result_set'];
        }

        //print_r($myBreaks);

        $totalBreaks = $result["total_row_count"];

        $selectedCompanyInfo = new CompanyInformation();
        $selectedCompanyInfo->setId(1);
        $selectedCompanyInfo->name = "s";
        $selectedCompanyInfo->date_established = "s";
        $selectedCompanyInfo->img_location = "s";
        $selectedCompanyInfo->business_type = "s";
        $selectedCompanyInfo->industry = "s";
        $selectedCompanyInfo->address = "s";
        $selectedCompanyInfo->phone = "s";
        $selectedCompanyInfo->email = "s";
        $selectedCompanyInfo->website = "s";
        $companyProfileFilterCriteria = [
            [
                "column" => "id", 
                "operator" => "=", 
                "value" => $selectedCompanyInfo->getId()
            ]
        ];
        $companyProfileData = $companyProfileDao->fetchCompanyInformation($selectedCompanyInfo, $companyProfileFilterCriteria);
        if ($companyProfileData === ActionResult::FAILURE){
            echo "Fail to fetch Company Information";
            return;
        }
        //print_r($companyProfileData);
        //print_r($myAttendance);
        //print_r($myBreaks);

        include __DIR__ . '/attendance-pdf.php';
        return;
    }


    echo "Invalid action specified.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}