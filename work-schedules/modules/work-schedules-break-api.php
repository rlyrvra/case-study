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

        $breakScheduleDao = new BreakScheduleDao($pdo);
        $breakScheduleRepo = new BreakScheduleRepository($breakScheduleDao);
        $breakScheduleService = new BreakScheduleService($breakScheduleRepo);


        $selectedColumns = ['break_type_id', 'start_time', 'end_time'];
        $filterCriteria = [];
        $filterCriteria[] = [
            "column" => "break_schedule.work_schedule_id",
            "operator" => "=",
            "value" => $token
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
        $breakTypeData = $_POST['breakTypeData'] ?? null;
        if (!$breakTypeData) {
            return;
        } 
        $name = isset($breakTypeData['name']) && $breakTypeData['name'] !== '' ? validateInput($breakTypeData['name'], "Name") : null;
        $isPaid = isset($breakTypeData['is_paid']) && $breakTypeData['is_paid'] === 'Paid' ? true : false;
        $duration = isset($breakTypeData['duration']) && $breakTypeData['duration'] !== '' ? validateInput($breakTypeData['duration'], "Duration") : null;

        $newBreakType = new BreakType(
            id: null,
            name: $name,
            durationInMinutes: $duration,
            isPaid: $isPaid,
            requireBreakInAndBreakOut: 0
        );
        $breakTypeRepo = new BreakTypeRepository($breakTypeDao);
        $breakTypeService = new BreakTypeService($breakTypeRepo);
        $result = $breakTypeService->createBreakType($newBreakType);
        if ($result !== ActionResult::FAILURE) {
            die("
            <script>
                showSuccessCreateBreak();
            </script>
            ");
        } else {
            echo "Failed to create breaks. Please try again.";
        }
        return;
    }

    if($action === 'update'){
        $breakTypeData = $_POST['breakTypeData'] ?? null;
        if (!$breakTypeData) {
            return;
        } 
        $id = isset($breakTypeData['id']) && $breakTypeData['id'] !== '' ? validateInput($breakTypeData['id'], "ID") : null;
        $name = isset($breakTypeData['name']) && $breakTypeData['name'] !== '' ? validateInput($breakTypeData['name'], "Name") : null;
        $isPaid = isset($breakTypeData['is_paid']) && $breakTypeData['is_paid'] === 'Paid' ? true : false;
        $duration = isset($breakTypeData['duration']) && $breakTypeData['duration'] !== '' ? validateInput($breakTypeData['duration'], "Duration") : null;

        $updatedBreakType = new BreakType(
            id: $id,
            name: $name,
            durationInMinutes: $duration,
            isPaid: $isPaid,
            requireBreakInAndBreakOut: 0
        );
        $breakTypeRepo = new BreakTypeRepository($breakTypeDao);
        $breakTypeService = new BreakTypeService($breakTypeRepo);
        $result = $breakTypeService->updateBreakType($updatedBreakType);
        if ($result !== ActionResult::FAILURE) {
            die("
            <script>
                showSuccessUpdateBreak();
            </script>
            ");
        } else {
            echo "Failed to update breaks. Please try again.";
        }
        return;
    }

    if($action === 'delete'){
        $token = $_POST['token'] ?? null;
        if (!$token) {
            return;
        } 

        $breakTypeRepo = new BreakTypeRepository($breakTypeDao);
        $breakTypeService = new BreakTypeService($breakTypeRepo);
        $result = $breakTypeService->deleteBreakType($token);
        if ($result !== ActionResult::FAILURE) {
            die("
            <script>
                showSuccessDeletionBreak();
            </script>
            ");
        } else {
            echo "Failed to create breaks. Please try again.";
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