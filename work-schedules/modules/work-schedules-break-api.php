<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../WorkSchedule.php';
require_once __DIR__ . '/../WorkScheduleRepository.php';
require_once __DIR__ . '/../WorkScheduleService.php';
require_once __DIR__ . '/../WorkScheduleDao.php';

require_once __DIR__ . '/../../breaks/BreakType.php';
require_once __DIR__ . '/../../breaks/BreakTypeDao.php';
require_once __DIR__ . '/../../breaks/BreakTypeRepository.php';
require_once __DIR__ . '/../../breaks/BreakTypeService.php';

require_once __DIR__ . '/../../breaks/BreakSchedule.php';
require_once __DIR__ . '/../../breaks/BreakScheduleDao.php';
require_once __DIR__ . '/../../breaks/BreakScheduleRepository.php';
require_once __DIR__ . '/../../breaks/BreakScheduleService.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../database/database.php';


try {
    $breakTypeDao = new BreakTypeDao($pdo);
    $breakScheduleDao = new BreakScheduleDao($pdo);
    $action = $_POST['action'] ?? '';

    if($action === 'fetchAll'){
        
        $filterCriteria = [];
    
        $sortCriteria = [
            [
                "column" => "break_type.created_at",
                "direction" => "DESC"
            ]
        ];

        $breakTypeRepo = new BreakTypeRepository($breakTypeDao);
        $breakTypeService = new BreakTypeService($breakTypeRepo);
        $result = $breakTypeService->fetchAllBreakTypes([], $filterCriteria, $sortCriteria);
        $breakTypes;
        if($result !== ActionResult::FAILURE){
            $breakTypes = $result["result_set"];
        }

        include __DIR__ . '/work-schedules-break-types-table.php';
        return;

    }

    if($action === 'fetchBreakTypes'){

        $selectedColumns = ['id', 'name', 'duration_in_minutes', "is_paid"];

        $filterCriteria = [];
    
        $sortCriteria = [
            [
                "column" => "break_type.created_at",
                "direction" => "DESC"
            ]
        ];

        $breakTypeRepo = new BreakTypeRepository($breakTypeDao);
        $breakTypeService = new BreakTypeService($breakTypeRepo);
        $result = $breakTypeService->fetchAllBreakTypes($selectedColumns, $filterCriteria, $sortCriteria);
        $breakTypes;
        if($result !== ActionResult::FAILURE){
            $breakTypes = $result["result_set"];
        }
        die("
        <script>
        breakTypes = " . json_encode($breakTypes) .
        "
        </script>
        ");
        return;
    }

    if($action === 'fetchBreakSchedule'){
        $token = $_POST['token'] ?? null;
        if (!$token) {
            return;
        } 

        $workScheduleDao = new WorkScheduleDao($pdo);
        $workScheduleRepo = new WorkScheduleRepository($workScheduleDao);
        $workScheduleService = new WorkScheduleService($workScheduleRepo);

        $selectedColumns = ['start_time', 'end_time', 'is_flextime', 'total_hours_per_week', 'total_work_hours'];
        $filterCriteria = [];
        $filterCriteria[] = [
            "column" => "work_schedule.id",
            "operator" => "=",
            "value" => $token
        ];

        $result = $workScheduleService->fetchAllWorkSchedules($selectedColumns, $filterCriteria, [], 1);
        $workScheduleData = $result['result_set'];

        $breakScheduleRepo = new BreakScheduleRepository($breakScheduleDao);
        $breakScheduleService = new BreakScheduleService($breakScheduleRepo);


        $selectedColumns = ['id', 'break_type_id', 'start_time', 'end_time'];
        $filterCriteria = [];

        $filterCriteria[] = [
            "column" => "break_schedule.work_schedule_id",
            "operator" => "=",
            "value" => $token
        ];

        $filterCriteria[] = [
            "column" => "break_schedule.deleted_at",
            "operator" => "IS NULL"
        ];

        $result = $breakScheduleService->fetchAllBreakSchedules($selectedColumns, $filterCriteria, [], 5);
        $breakScheduleData = $result['result_set'];


        $currentData = [
            ["work_schedule_data" => $workScheduleData],
            ["break_schedules_data" => $breakScheduleData]
        ];

        die("
        <script>
            currentBreakSchedule = " . json_encode($currentData) .
        "
        </script>
        ");
    }


    if($action === 'create'){
        $breakTypeData = $_POST['break_type'] ?? null;
        if (!$breakTypeData) {
            return;
        } 
        $breakTypeRepo = new BreakTypeRepository($breakTypeDao);
        $breakTypeService = new BreakTypeService($breakTypeRepo);
        $result = $breakTypeService->createBreakType($breakTypeData);
        if (isset($result['status']) && $result['status'] === 'success') {
            die("
            <script>
                showSuccessCreateBreak();
            </script>
            ");
        } else if (isset($result['status']) && $result['status'] === 'error') {
            die("
            <script>
                showError(" . json_encode($result['message']) . ")
            </script>
            ");
        } else if (isset($result['status']) && $result['status'] === 'invalid_input'){
            die("
            <script>
                showValidationError(" . json_encode($result['errors']) . ");
            </script>
            ");
        }
        return;
    }

    if($action === 'update'){
        $breakTypeData = $_POST['break_type'] ?? null;
        if (!$breakTypeData) {
            return;
        } 
        $breakTypeRepo = new BreakTypeRepository($breakTypeDao);
        $breakTypeService = new BreakTypeService($breakTypeRepo);
        $result = $breakTypeService->updateBreakType($breakTypeData);

        if (isset($result['status']) && $result['status'] === 'success') {
            die("
            <script>
                showSuccessUpdateBreak();
            </script>
            ");
        } else if (isset($result['status']) && $result['status'] === 'error') {
            die("
            <script>
                showError(" . json_encode($result['message']) . ")
            </script>
            ");
        } else if (isset($result['status']) && $result['status'] === 'invalid_input'){
            die("
            <script>
                showValidationError(" . json_encode($result['errors']) . ");
            </script>
            ");
        }
        return;
    }

    if($action === 'delete'){
        $breakTypeData = $_POST['break_type'] ?? null;
        if (!$breakTypeData) {
            return;
        } 
        $token = $breakTypeData['id'] ?? null;
        if (!$token) {
            return;
        } 

        $breakTypeRepo = new BreakTypeRepository($breakTypeDao);
        $breakTypeService = new BreakTypeService($breakTypeRepo);
        $result = $breakTypeService->deleteBreakType($token);

        if (isset($result['status']) && $result['status'] === 'success') {
            die("
            <script>
                showSuccessDeletionBreak();
            </script>
            ");
        } else if (isset($result['status']) && $result['status'] === 'error') {
            die("
            <script>
                showError(" . json_encode($result['message']) . ")
            </script>
            ");
        } else if (isset($result['status']) && $result['status'] === 'invalid_input'){
            die("
            <script>
                showValidationError(" . json_encode($result['errors']) . ");
            </script>
            ");
        }
        return;
    }

    if($action === 'deleteBreakSchedule'){
        $token = $_POST['token'] ?? null;
        if (!$token) {
            return;
        } 

        $breakScheduleRepo = new BreakScheduleRepository($breakScheduleDao);
        $breakScheduleService = new BreakScheduleService($breakScheduleRepo);
        $result = $breakScheduleService->deleteBreakSchedule($token);
        if ($result !== ActionResult::FAILURE) {
            die("
            <script>
                showSuccessDeletionBreakSchedule();
            </script>
            ");
        } else {
            die("
            <script>
                alert('Error encountered deleting break schedules');
            </script>
            ");
        }
        return;
    }


    $message = "Invalid action specified.";
    die('
    <script>
        showFatalError(' . json_encode($message) 
    . ');
    </script>');
} catch (Exception $e) {
    $message = "Fatal error: " . $e->getMessage();
    die('
    <script>
        showFatalError(' . json_encode($message) 
    . ');
    </script>');
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