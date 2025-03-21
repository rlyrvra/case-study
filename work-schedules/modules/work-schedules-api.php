<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../WorkSchedule.php';
require_once __DIR__ . '/../WorkScheduleRepository.php';
require_once __DIR__ . '/../WorkScheduleService.php';
require_once __DIR__ . '/../WorkScheduleDao.php';

require_once __DIR__ . '/../../breaks/BreakSchedule.php';
require_once __DIR__ . '/../../breaks/BreakScheduleDao.php';
require_once __DIR__ . '/../../breaks/BreakScheduleRepository.php';
require_once __DIR__ . '/../../breaks/BreakScheduleService.php';

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
        $viewMode = isset($_POST['view_mode']) ? $_POST['view_mode'] : 'table';
        
        $filterCriteria = [];
        
        if(!empty($status) && $status == 'Archived'){
            $filterCriteria[] = [
                "column" => "employee.deleted_at",
                "operator" => "IS NULL"
            ];
            $filterCriteria[] = [
                "column" => "work_schedule.deleted_at",
                "operator" => "IS NOT NULL"
            ];
        }else{
            $filterCriteria[] = [
                "column" => "employee.deleted_at",
                "operator" => "IS NULL"
            ];
            $filterCriteria[] = [
                "column" => "work_schedule.deleted_at",
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
                "column" => "department.name", 
                "operator" => "LIKE",
                "value" => "%$searchFilter%", 
                'boolean' => 'OR'
            ];
            $filterCriteria[] = [
                "column" => "job_title.title", 
                "operator" => "LIKE",
                "value" => "%$searchFilter%", 
                'boolean' => 'OR'
            ];
        }

        if(!empty($searchFilter) && !empty($searchAt)){
            $filterCriteria[] = [
                "column" => $searchAt, 
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
        if($viewMode == 'table'){
            include __DIR__ . '/work-schedules-table.php';
        }
        else{
            include __DIR__ . '/work-schedules-table-card.php';
        }
        
        return;

    }

    if($action === 'create'){
        $workScheduleData = $_POST['work_schedule'] ?? null;
        $breakScheduleData = $_POST['break_schedules'] ?? null; 
        if (!$workScheduleData) {
            return;
        }
        
        

        $employee = isset($workScheduleData['employee']) ? validateInput($workScheduleData['employee'], 'Employee') : '';
        $start_time = isset($workScheduleData['start_time']) && $workScheduleData['start_time'] !== '' ? 
            date('Y-m-d H:i:s', strtotime(validateInput($workScheduleData['start_time'], 'Start Time'))) : '2024-01-01 00:00:00';
        $end_time = isset($workScheduleData['end_time']) && $workScheduleData['end_time'] !== '' ? 
            date('Y-m-d H:i:s', strtotime(validateInput($workScheduleData['end_time'], 'End Time'))) : '2024-01-01 23:59:59';
        $is_flex_time = isset($workScheduleData['is_flex_time']) && $workScheduleData['is_flex_time'] === 'true' ? true : false;
        $core_start_time = null; $core_end_time = null; $total_hrs_per_week = null;
        if($is_flex_time === true){
            $start_time =  '2024-01-01 00:00:00';
            $end_time = '2024-01-01 23:59:59';
            $total_hrs_per_week = isset($workScheduleData['total_hrs_per_week']) ? (float) validateInput($workScheduleData['total_hrs_per_week'], 'Total Hours Per Week') * 6 : null;
        }
        $total_work_hrs = isset($workScheduleData['total_work_hrs']) ? (float) (validateNumericIdentifier($workScheduleData['total_work_hrs'], 1, 4, 'Total Work Hours')): null;
        $start_date = '2024-01-01';
        

        $newWorkSchedule = new WorkSchedule(
            id: null,
            employeeId: $employee,
            startTime: $start_time,
            endTime: $end_time,
            isFlextime: $is_flex_time,
            totalHoursPerWeek: $total_hrs_per_week,
            totalWorkHours: $total_work_hrs,
            startDate: $start_date,
            recurrenceRule: "FREQ=WEEKLY;INTERVAL=1;DTSTART={$start_date};BYDAY=MO,TU,WE,TH,FR,SA"
        );


        $workScheduleRepository = new WorkScheduleRepository($workScheduleDao);
        $workScheduleService = new WorkScheduleService($workScheduleRepository);
        $createResult = $workScheduleService->createWorkSchedule($newWorkSchedule);
        $lastWorkScheduleId = $pdo->lastInsertId();
        $messageComposed = '';
        $indicator = 'success';

        switch ($createResult) {
            case ActionResult::FAILURE:
                die("
                <script>
                    showError();
                </script>
                ");
                break;
            case ActionResult::SUCCESS:
                $messageComposed .= "Work Schedule was created successfully";
                break;
            default:
                $pdo->rollback();
                die("
                <script>
                    showError();
                </script>
                ");
                break;
        }
        
        $pdo->beginTransaction();

        
        if ($lastWorkScheduleId === 0) {
            $lastWorkScheduleId = getLastInsertIdBySql($pdo);
        }

        if ($createResult !== ActionResult::SUCCESS) {
            $pdo->rollback();
            return;
        }

        $breakScheduleResult = null;
        if ($breakScheduleData) {
            $breakScheduleResult = createBreakSchedules($pdo, getLastInsertIdBySql($pdo), $breakScheduleData);
        }
       
        if(isset($breakScheduleResult['action'])){
            switch ($breakScheduleResult['action']) {
                case ActionResult::FAILURE:
                    $messageComposed .= " and creating breaks had encountered an error";
                    $indicator = 'warning';
                    $pdo->rollback();
                    break;
                case ActionResult::SUCCESS:
                    $messageComposed .= " and " . $breakScheduleResult['number'] . " break(s) was attached successfully";
                    break;
                default:
                    $messageComposed .= " and creating breaks had an uncatchable error";
                    $indicator = 'warning';
                    break;
            }
        }
        

        $pdo->commit();

        // print_r($workScheduleData);
        // echo "<br> ID: " . $lastWorkScheduleId . "<br>";
        // echo "" . $messageComposed . "<br>";
        // print_r($breakScheduleData);
        // echo "" . $messageComposed . "<br>";

        if ($createResult === ActionResult::SUCCESS) {
            die("
            <script>
                showSuccessCreate('$messageComposed', '$indicator');
            </script>
            ");
        }

        return;
    }

    if($action === 'update'){
        $workScheduleData = $_POST['work_schedule'] ?? null;
        $breakDifferences = $_POST['break_schedules'] ?? null; 
        $workScheduleId = $_POST['token'] ?? null; 
        // echo "workScheduleId " . $workScheduleId . "<br>";
        if (!$workScheduleData) {
            return;
        }
        if (!$workScheduleId) {
            return;
        }


        $breakTobeUpdated = [];
        $breakTobeCreated = [];
        if ($breakDifferences && is_array($breakDifferences)) {
            foreach ($breakDifferences as $breakSchedule) {
                if (isset($breakSchedule['id'])) {
                    // If "id" exists, add to the "to be updated" array
                    $breakTobeUpdated[] = $breakSchedule;
                } else {
                    // If "id" does not exist, add to the "to be created" array
                    $breakTobeCreated[] = $breakSchedule;
                }
            }
        }
        

        $selectedColumns = ['employee_id'];
        $filterCriteria = [
            [
                "column" => "work_schedule.id",
                "operator" => "=",
                "value" => $workScheduleId
            ]
        ];

        $workScheduleRepository = new WorkScheduleRepository($workScheduleDao);
        $workScheduleService = new WorkScheduleService($workScheduleRepository);
        $employeeId = $workScheduleService->fetchAllWorkSchedules($selectedColumns, $filterCriteria, [], 1)['result_set'][0]['employee_id'];
        // echo "Emp-ID: " . $employeeId . "<br>";

        $employee = $employeeId;
        $start_time = isset($workScheduleData['start_time']) && $workScheduleData['start_time'] !== '' ? 
            date('Y-m-d H:i:s', strtotime(validateInput($workScheduleData['start_time'], 'Start Time'))) : '1970-01-01 00:00:00';
        $end_time = isset($workScheduleData['end_time']) && $workScheduleData['end_time'] !== ''? 
            date('Y-m-d H:i:s', strtotime(validateInput($workScheduleData['end_time'], 'End Time'))) : '1970-01-01 00:00:00';
        $is_flex_time = isset($workScheduleData['is_flex_time']) && $workScheduleData['is_flex_time'] === 'true' ? true : false;
        $core_start_time = null; $core_end_time = null; $total_hrs_per_week = null;
        if($is_flex_time === true){
            $start_time =  '2024-01-01 00:00:00';
            $end_time = '2024-01-01 23:59:59';
            $total_hrs_per_week = isset($workScheduleData['total_hrs_per_week']) ? (float) validateInput($workScheduleData['total_hrs_per_week'], 'Total Hours Per Week') * 6 : null;
        }
        $total_work_hrs = isset($workScheduleData['total_work_hrs']) ? (float) (validateNumericIdentifier($workScheduleData['total_work_hrs'], 1, 4, 'Total Work Hours')): null;
        $start_date = '2024-01-01';
        

        $updatedWorkSchedule = new WorkSchedule(
            id: $workScheduleId,
            employeeId: $employee,
            startTime: $start_time,
            endTime: $end_time,
            isFlextime: $is_flex_time,
            totalHoursPerWeek: $total_hrs_per_week,
            totalWorkHours: $total_work_hrs,
            startDate: $start_date,
            recurrenceRule: "FREQ=WEEKLY;INTERVAL=1;DTSTART={$start_date};BYDAY=MO,TU,WE,TH,FR,SA"
        );

        $updateResult = $workScheduleService->updateWorkSchedule($updatedWorkSchedule);

        $messageComposed = '';
        $indicator = 'success';

        switch ($updateResult) {
            case ActionResult::FAILURE:
                die("
                <script>
                    showError();
                </script>
                ");
                break;
            case ActionResult::SUCCESS:
                $messageComposed .= "Work Schedule was updated successfully";
                break;
            default:
                $pdo->rollback();
                die("
                <script>
                    showError();
                </script>
                ");
                break;
        }

        $pdo->beginTransaction();

        if ($updateResult !== ActionResult::SUCCESS) {
            $pdo->rollback();
            return;
        }

        // Normalize $breakTobeCreated by renaming break_type_id into id
        foreach ($breakTobeCreated as &$break) {
            if (isset($break['break_type_id'])) {
                $break['id'] = $break['break_type_id'];
                unset($break['break_type_id']);
            }
        }
        unset($break); // Break the reference

        $breakScheduleResult = null;
        if (!empty($breakTobeCreated)) {
            $breakScheduleResult = createBreakSchedules($pdo, $workScheduleId, $breakTobeCreated);
        }
       
        if(isset($breakScheduleResult['action'])){
            switch ($breakScheduleResult['action']) {
                case ActionResult::FAILURE:
                    $messageComposed .= " and creating breaks had encountered an error";
                    $indicator = 'warning';
                    $pdo->rollback();
                    break;
                case ActionResult::SUCCESS:
                    $messageComposed .= " and " . $breakScheduleResult['number'] . " break(s) was attached successfully";
                    break;
                default:
                    break;
            }
        }
        

        //echo $messageComposed . "<br>";

        $breakScheduleResult = null;
        if (!empty($breakTobeUpdated)) {
            $breakScheduleResult = updateBreakSchedules($pdo, $workScheduleId, $breakTobeUpdated);
        }
       
        if(isset($breakScheduleResult['action'])){
            switch ($breakScheduleResult['action']) {
                case ActionResult::FAILURE:
                    $messageComposed .= " and updating breaks had encountered an error";
                    $indicator = 'warning';
                    $pdo->rollback();
                    break;
                case ActionResult::SUCCESS:
                    $messageComposed .= " and " . $breakScheduleResult['number'] . " break(s) was updated successfully";
                    break;
                default:
                    break;
            }
        }
        


        $pdo->commit();

        if ($updateResult === ActionResult::SUCCESS) {
            die("
            <script>
                showSuccessCreate('$messageComposed', '$indicator');
            </script>
            ");
        }

        return;
    }


    
    if($action === 'delete'){
        $hashed_id = $_POST['token'] ?? null;
        if(!$hashed_id){
            return;
        }
        $pdo->beginTransaction();
        $workScheduleRepository = new WorkScheduleRepository($workScheduleDao);
        $workScheduleService = new WorkScheduleService($workScheduleRepository);
        $deleteResult = $workScheduleService->deleteWorkSchedule($hashed_id);

        if ($deleteResult === ActionResult::SUCCESS) {
            $pdo->commit();
            die("
            <script>
                showSuccessDeletion();
            </script>
            ");
        } else if($deleteResult === ActionResult::FAILURE){
            $pdo->rollback();
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
    if (!is_numeric($value)) {
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

function getLastInsertIdBySql($pdo): int {
    try {
        $stmt = $pdo->query("SELECT id FROM work_schedules ORDER BY id DESC LIMIT 1");
        $lastWorkScheduleId = $stmt->fetchColumn();
        return $lastWorkScheduleId !== false ? (int) $lastWorkScheduleId : 0;
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return 0; // Return 0 as a fallback
    }
}

function createBreakSchedules($pdo, $workScheduleId, $breakSchedules){
    $breakScheduleDao = new BreakScheduleDao($pdo);
    $breakScheduleRepo = new BreakScheduleRepository($breakScheduleDao);
    $breakScheduleService = new BreakScheduleService($breakScheduleRepo);
    $createdCounter = 0;
    foreach ($breakSchedules as $breakSchedule){
        $newBreakSchedule = new BreakSchedule(
            id: null,
            workScheduleId: $workScheduleId,
            breakTypeId: $breakSchedule['id'],
            startTime: $breakSchedule['start_time'],
            endTime: $breakSchedule['end_time']
        );
        $createResult = $breakScheduleService->createBreakSchedule($newBreakSchedule);

        if($createResult === ActionResult::SUCCESS){
            $createdCounter++;
        }else if($createResult === ActionResult::FAILURE){
            return ActionResult::FAILURE;
        }
    }
    return [
        "action" => ActionResult::SUCCESS,
        "number" => $createdCounter
    ];
}

function updateBreakSchedules($pdo, $workScheduleId, $breakSchedules){
    //print_r($breakSchedules);
    $breakScheduleDao = new BreakScheduleDao($pdo);
    $breakScheduleRepo = new BreakScheduleRepository($breakScheduleDao);
    $breakScheduleService = new BreakScheduleService($breakScheduleRepo);
    $updatedCounter = 0;
    foreach ($breakSchedules as $breakSchedule){
        $updatedBreakSchedule = new BreakSchedule(
            id: $breakSchedule['id'],
            workScheduleId: $workScheduleId,
            breakTypeId: $breakSchedule['break_type_id'],
            startTime: $breakSchedule['start_time'],
            endTime: $breakSchedule['end_time']
        );
        $updateResult = $breakScheduleService->updateBreakSchedule($updatedBreakSchedule);

        if($updateResult === ActionResult::SUCCESS){
            $updatedCounter++;
        }else if($updateResult === ActionResult::FAILURE){
            return ActionResult::FAILURE;
        }
    }
    return [
        "action" => ActionResult::SUCCESS,
        "number" => $updatedCounter
    ];
}