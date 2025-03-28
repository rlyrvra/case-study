<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../../database/database.php'           ;

require_once __DIR__ . '/../../attendance/AttendanceService.php';
require_once __DIR__ . '/../../breaks/EmployeeBreakService.php' ;

$attendanceDao    = new AttendanceDao   ($pdo);
$employeeDao      = new EmployeeDao     ($pdo);
$holidayDao       = new HolidayDao      ($pdo);
$leaveRequestDao  = new LeaveRequestDao ($pdo);
$workScheduleDao  = new WorkScheduleDao ($pdo);
$settingDao       = new SettingDao      ($pdo);
$breakScheduleDao = new BreakScheduleDao($pdo);
$employeeBreakDao = new EmployeeBreakDao($pdo);
$breakTypeDao     = new BreakTypeDao    ($pdo);

$attendanceRepository    = new AttendanceRepository   ($attendanceDao   );
$employeeRepository      = new EmployeeRepository     ($employeeDao     );
$holidayRepository       = new HolidayRepository      ($holidayDao      );
$leaveRequestRepository  = new LeaveRequestRepository ($leaveRequestDao );
$workScheduleRepository  = new WorkScheduleRepository ($workScheduleDao );
$settingRepository       = new SettingRepository      ($settingDao      );
$breakScheduleRepository = new BreakScheduleRepository($breakScheduleDao);
$employeeBreakRepository = new EmployeeBreakRepository($employeeBreakDao);
$breakTypeRepository     = new BreakTypeRepository    ($breakTypeDao    );

$attendanceService = new AttendanceService(
    pdo                    : $pdo                    ,
    attendanceRepository   : $attendanceRepository   ,
    employeeRepository     : $employeeRepository     ,
    holidayRepository      : $holidayRepository      ,
    leaveRequestRepository : $leaveRequestRepository ,
    workScheduleRepository : $workScheduleRepository ,
    settingRepository      : $settingRepository      ,
    breakScheduleRepository: $breakScheduleRepository,
    employeeBreakRepository: $employeeBreakRepository,
    breakTypeRepository    : $breakTypeRepository
);

$employeeBreakService = new EmployeeBreakService(
    employeeBreakRepository: $employeeBreakRepository,
    employeeRepository     : $employeeRepository     ,
    attendanceRepository   : $attendanceRepository
);

try {
    $action = $_POST['action'] ?? '';

    if ($action === 'handleRfid'){
        $employeeRfidUid = $_POST['rfid'];
        $currentDateTime = $_POST['date'];

        //echo $_POST['rfid'];
        //echo $_POST['date'];
        if(isset($_POST['type']) && $_POST['type'] === 'Attendance'){
            $attendanceResponse = $attendanceService->handleRfidTap($employeeRfidUid, $currentDateTime);
            $status = $attendanceResponse['status'];
            $message = $attendanceResponse['message'];
            $errors = $attendanceResponse['errors'] ?? null;
            //print_r($attendanceResponse);
            $employeeRecord = [];
            if($status === 'success'){
                $employeeRecord = $attendanceService->fetchAllAttendance(
                    ['employee_profile_picture', 'employee_code', 'check_in_time', 'check_out_time', 'attendance_status'], 
                    [
                        [
                            "column" => "employee.rfid_uid",
                            "operator" => "=",
                            "value" => $employeeRfidUid
                        ]
                    ], 
                    [
                        [
                            "column" => "attendance.created_at",
                            "direction" => "DESC"
                        ]
                    ],
                    1)['result_set'];
            }
            $employeeJson = json_encode($employeeRecord);
            $errorJson = isset($errors) && !empty($errors) ? json_encode($errors) : json_encode([]);
            die(
            "
                <script>
                    showResponse('$status', '$message', $errorJson, $employeeJson);
                </script>
            "
            );
        }else if(isset($_POST['type']) && $_POST['type'] === 'Break'){
            $breakResponse = $employeeBreakService->handleRfidTap($employeeRfidUid, $currentDateTime);
            $status = $breakResponse['status'];
            $message = $breakResponse['message'];
            $errors = $breakResponse['errors'] ?? null;
            //print_r($breakResponse);
            $employeeRecord = [];
            if($status === 'success'){
                $employeeRecord = $employeeBreakService->fetchAllEmployeeBreaks(
                    ['employee_profile_picture', 'employee_code', 'start_time', 'end_time'], 
                    [
                        [
                            "column" => "employee.rfid_uid",
                            "operator" => "=",
                            "value" => $employeeRfidUid
                        ]
                    ], 
                    [
                        [
                            "column" => "employee_break.created_at",
                            "direction" => "DESC"
                        ]
                    ],
                    [],
                    1)['result_set'];
            }
            $employeeJson = json_encode($employeeRecord);
            $errorJson = isset($errors) && !empty($errors) ? json_encode($errors) : json_encode([]);
            die(
            "
                <script>
                    showResponse('$status', '$message', $errorJson, $employeeJson);
                </script>
            "
            );
        }

        return;
    }

    if ($action === 'fetchAllAttendance'){
        $selectedColumns = ['employee_code', 'check_in_time', 'check_out_time', 'date'];
        $sortCriteria = [
            [
                "column" => "attendance.created_at",
                "direction" => "DESC"
            ]
        ];
        $attendanceRecords = $attendanceService->fetchAllAttendance($selectedColumns, [], $sortCriteria, 5, false)['result_set'];
        include __DIR__ . '/attendance-table.php';
        return;
    }

    if ($action === 'fetchAllBreaks'){
        $selectedColumns = ['employee_code', 'start_time', 'end_time'];
        $sortCriteria = [
            [
                "column" => "employee_break.created_at",
                "direction" => "DESC"
            ]
        ];
        $breakRecords = $employeeBreakService->fetchAllEmployeeBreaks($selectedColumns, [], $sortCriteria, [], 5, false)['result_set'];
        include __DIR__ . '/breaks-table.php';
        return;
    }

    echo "Invalid action specified.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

