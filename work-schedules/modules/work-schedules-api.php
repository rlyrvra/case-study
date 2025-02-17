<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../WorkSchedule.php';
require_once __DIR__ . '/../WorkScheduleRepository.php';
require_once __DIR__ . '/../WorkScheduleService.php';
require_once __DIR__ . '/../WorkScheduleDao.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../database/database.php';


try {
    $workScheduleDao = new WorkScheduleDao($pdo);
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
        
        if(!empty($status) && $status == 'Archived'){
            $filterCriteria[] = [
                "column" => "employee.deleted_at",
                "operator" => "IS NULL"
            ];
        }else{
            $filterCriteria[] = [
                "column" => "employee.deleted_at",
                "operator" => "IS NULL"
            ];
        }

        if(empty($searchAt) && !empty($searchFilter)){
            $filterCriteria[] = [
                "column" => "employee.full_name", 
                "operator" => "LIKE",
                "value" => "%$searchFilter%", 
                'boolean' => 'OR'

            ];
            $filterCriteria[] = [
                "column" => "employee.email_address", 
                "operator" => "LIKE",
                "value" => "%$searchFilter%", 
                'boolean' => 'OR'
            ];
        }

        if(!empty($searchFilter) && !empty($searchAt)){
            $filterCriteria[] = [
                "column" => "employee." . $searchAt, 
                "operator" => "LIKE",
                "value" => "%$searchFilter%"
            ];
        }

        if((!empty($dateFilterColumn) && $dateFilterColumn !== "none") && !empty($dateStart) && !empty($dateEnd)){
            $filterCriteria[] = [
                "column" => "work_schedule." . $dateFilterColumn,
                "operator" => "BETWEEN",
                "lower_bound" => $dateStart,
                "upper_bound" => $dateEnd
            ];
        }
        
        $sortCriteria = [
            [
                "column" => "work_schedule." . $_POST['sort_by'],
                "direction" => $_POST['sort_order']
            ]
        ];
        
        $workScheduleRepository = new WorkScheduleRepository($workScheduleDao);
        $workScheduleService = new WorkScheduleService($workScheduleRepository);
        $result = $workScheduleService->fetchAllWorkSchedules([], $filterCriteria, $sortCriteria, $limit, $offset);

        if($result !== ActionResult::FAILURE){
            $workSchedules = $result["result_set"];
        }

        $totalLeaveTypes = $result["total_row_count"];
        $totalPages = ceil($totalLeaveTypes / $_POST['numberEntries']);
        include __DIR__ . '/work-schedules-table.php';
        return;

    }

    if($action === 'create'){
        $workScheduleData = $_POST['work_schedule'] ?? null;

        if (!$workScheduleData) {
            return;
        } 


        $employee = isset($workScheduleData['employee']) ? validateInput($workScheduleData['employee'], 'Employee') : '';
        $start_time = isset($workScheduleData['start_time']) ? 
            date('Y-m-d H:i:s', strtotime(validateInput($workScheduleData['start_time'], 'Start Time'))) : '1970-01-01 00:00:00';
        $end_time = isset($workScheduleData['end_time']) ? 
            date('Y-m-d H:i:s', strtotime(validateInput($workScheduleData['end_time'], 'End Time'))) : '1970-01-01 00:00:00';
        $is_flex_time = isset($workScheduleData['is_flex_time']) ? validateInput($workScheduleData['is_flex_time'], 'Is Flex Time') : null;
        $core_start_time = null; $core_end_time = null; $total_hrs_per_week = null;
        if($is_flex_time){
            // $core_start_time = isset($workScheduleData['core_start_time']) ? 
            //     date('Y-m-d H:i:s', strtotime(validateInput($workScheduleData['core_start_time'], 'Core Start Time'))) : '1970-01-01 00:00:00';

            // $core_end_time = isset($workScheduleData['core_end_time']) ? 
            //     date('Y-m-d H:i:s', strtotime(validateInput($workScheduleData['core_end_time'], 'Core End Time'))) : '1970-01-01 00:00:00';
            // $core_start_time = date('Y-m-d H:i:s', strtotime(validateInput('12:00AM', 'Core End Time')));
            // $core_end_time = date('Y-m-d H:i:s', strtotime(validateInput('11:59PM', 'Core End Time')));
            $total_hrs_per_week = isset($workScheduleData['total_hrs_per_week']) ? (int) validateInput($workScheduleData['total_hrs_per_week'], 'Total Hours Per Week') : null;
        }
        $total_work_hrs = isset($workScheduleData['total_work_hrs']) ? (int) (validateNumericIdentifier($workScheduleData['total_work_hrs'], 1, 3, 'Total Work Hours') * 6): null;
        $start_date = isset($workScheduleData['start_date']) ? validateInput($workScheduleData['start_date'], 'Start Date') : null;
        


        // echo "Employee: " . $employee . PHP_EOL;
        // echo "Start Time: " . $start_time . PHP_EOL;
        // echo "End Time: " . $end_time . PHP_EOL;
        // echo "Is Flex Time: " . ($is_flex_time === null ? 'null' : ($is_flex_time ? 'true' : 'false')) . PHP_EOL;

        // if ($is_flex_time) {
        //     echo "Core Start Time: " . $core_start_time . PHP_EOL;
        //     echo "Core End Time: " . $core_end_time . PHP_EOL;
        //     echo "Total Hours Per Week: " . ($total_hrs_per_week === null ? 'null' : $total_hrs_per_week) . PHP_EOL;
        // }

        // echo "Total Work Hours: " . ($total_work_hrs === null ? 'null' : $total_work_hrs) . PHP_EOL;
        // echo "Start Date: " . ($start_date === null ? 'null' : $start_date) . PHP_EOL;
        // echo "Formatted Start Date: " . $startDate . PHP_EOL;

        $newWorkSchedule = new WorkSchedule(
            id: null,
            employeeId: $employee,
            startTime: $start_time,
            endTime: $end_time,
            isFlextime: $is_flex_time,
            totalHoursPerWeek: $total_hrs_per_week,
            totalWorkHours: $total_work_hrs,
            startDate: '2024-01-01',
            recurrenceRule: "FREQ=WEEKLY;INTERVAL=1;DTSTART={$start_date};BYDAY=MO,TU,WE,TH,FR,SA"
        );

        $workScheduleRepository = new WorkScheduleRepository($workScheduleDao);
        $workScheduleService = new WorkScheduleService($workScheduleRepository);
        $createResult = $workScheduleService->createWorkSchedule($newWorkSchedule);
        if($createResult === ActionResult::SUCCESS){
            die("
            <script>
                showSuccessCreate();
            </script>
            ");
        }else {
            die("
            <script>
                showError();
            </script>
            ");
        }

        return;
    }
    echo "Invalid action specified.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

// Function to validate and sanitize input
function validateInput($input, $fieldName) {

    // Escape the field name for security
    $escapedFieldName = htmlspecialchars($fieldName, ENT_QUOTES, 'UTF-8');

    // Trim the input to remove extra whitespaces
    $input = trim($input);
    
    // Check if input is empty after trimming
    if (empty($input)) {
        die("
        <script>
            missingFieldValues('{$escapedFieldName}');
        </script>
        ");
    }
    
    // Additional validation can go here (e.g., regex for specific formats)
    
    return htmlspecialchars($input); // Sanitize to prevent XSS
}

function validateNumericIdentifier($value, $minLength, $maxLength, $fieldName = null) {
    $value = trim($value);

    // Escape the field name for security
    $escapedFieldName = htmlspecialchars($fieldName, ENT_QUOTES, 'UTF-8');

    // Check if the value is strictly numeric
    if (!ctype_digit($value)) {
        echo "
        <script>
            missingFieldValues('{$escapedFieldName}');
        </script>
        ";
        exit;
    }

    // Check the length range
    if (strlen($value) < $minLength || strlen($value) > $maxLength) {
        echo "
        <script>
            missingFieldValues('{$escapedFieldName}');
        </script>
        ";
        exit;
    }

    return $value;
}