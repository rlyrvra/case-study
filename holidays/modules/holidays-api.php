<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../Holiday.php';
require_once __DIR__ . '/../HolidayDao.php';
require_once __DIR__ . '/../HolidayRepository.php';
require_once __DIR__ . '/../HolidayService.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../includes/enums/ErrorCode.php';
require_once __DIR__ . '/../../database/database.php';

try {
    $holidayDao = new HolidayDao($pdo);
    $action = $_POST['action'] ?? '';

    if($action === 'fetchAll'){
        $status = isset($_POST['filter_status']) && $_POST['filter_status'] ? $_POST['filter_status'] : null;
        $searchAt = isset($_POST['filter_searchAt']) && $_POST['filter_searchAt'] !== "none" ? $_POST['filter_searchAt'] : null;
        $searchFilter = isset($_POST['filter_search']) ? $_POST['filter_search'] : null;
        $dateFilterColumn = isset($_POST['filter_date_column']) ? $_POST['filter_date_column'] : null;
        $dateStart = isset($_POST['filter_startDate']) && $dateFilterColumn !== "none" ? $_POST['filter_startDate'] : 0;
        $dateEnd = isset($_POST['filter_endDate']) && $dateFilterColumn !== "none" ? $_POST['filter_endDate'] : 0;
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $limit = isset($_POST['numberEntries']) ? $_POST['numberEntries'] : 10;
        $offset = ($page - 1) * $limit;
        
        $filterCriteria = [];
        
        if(!empty($status)){
            $filterCriteria[] = [
                "column" => "holiday.status",
                "operator" => "=",
                "value" => $status
            ];
        }

        if(empty($searchAt) && !empty($searchFilter)){
            $filterCriteria[] = [
                "column" => "holiday.name", 
                "operator" => "LIKE",
                "value" => "%$searchFilter%", 
                'boolean' => 'OR'

            ];
            $filterCriteria[] = [
                "column" => "holiday.description", 
                "operator" => "LIKE",
                "value" => "%$searchFilter%", 
                'boolean' => 'OR'
            ];
        }

        if(!empty($searchFilter) && !empty($searchAt)){
            $filterCriteria[] = [
                "column" => "holiday." . $searchAt, 
                "operator" => "LIKE",
                "value" => "%$searchFilter%"
            ];
        }

        if((!empty($dateFilterColumn) && $dateFilterColumn !== "none") && !empty($dateStart) && !empty($dateEnd)){
            $filterCriteria[] = [
                "column" => "holiday." . $dateFilterColumn,
                "operator" => "BETWEEN",
                "lower_bound" => $dateStart,
                "upper_bound" => $dateEnd
            ];
        }


        $sortCriteria = [
            [
                "column" => "holiday." . $_POST['sort_by'],
                "direction" => $_POST['sort_order']
            ]
        ];
        $holidayRepository = new HolidayRepository($holidayDao);
        $holidayService = new HolidayService($holidayRepository);
        $result = $holidayService->fetchAllHolidays([], $filterCriteria, $sortCriteria, $limit, $offset);
        $holidays;
        if ($result !== ActionResult::FAILURE) {
            $holidays = $result['result_set'];
        }

        $totalHolidays = $result["total_row_count"];
        $totalPages = ceil($totalHolidays / $limit);
        include __DIR__ . '/holidays-table.php';
        return;
    }

    if($action === 'create'){
        $holidayData = $_POST['holidayData'] ?? null;
        if ($holidayData == null) {
            echo "Invalid holiday data.";
            return;
        }

        print_r($holidayData);

        $name = isset($holidayData['name']) && $holidayData['name'] !== '' ? validateInput($holidayData['name'], "Name") : null;
        $startDate = isset($holidayData['start_date']) ? 
                date('Y-m-d', strtotime(validateInput($holidayData['start_date'], 'Start Date'))) : '1970-01-01';
        $endDate = isset($holidayData['end_date']) ? 
                date('Y-m-d', strtotime(validateInput($holidayData['end_date'], 'End Date'))) : '1970-01-01';
        $isPaid = isset($holidayData['isPaid']) && $holidayData['isPaid'] !== '' ? $holidayData['isPaid'] : null;
        $isRecurring = isset($holidayData['isRecurring']) && $holidayData['isRecurring'] !== '' ? $holidayData['isRecurring'] : null;
        $description = isset($holidayData['description']) ? $holidayData['description'] : null;
        $status = isset($holidayData['status']) ? validateInput($holidayData['status'], "Status") : null;
        
        $newHoliday = new Holiday(
            id: null,
            name: $name,
            startDate: $startDate,
            endDate: $endDate,
            isPaid: $isPaid,
            isRecurringAnnually: $isRecurring,
            description: $description,
            status: $status
        );
        $holidayRepository = new HolidayRepository($holidayDao);
        $holidayService = new HolidayService($holidayRepository);
        $result = $holidayService->createHoliday($newHoliday);
        
        if ($result !== ActionResult::FAILURE) {
            die("
            <script>
                showSuccessCreate();
            </script>
            ");
        } else {
            echo "Failed to create holidays. Please try again.";
        }
        return;
    }


    if($action === 'update'){
        $holidayData = $_POST['holidayData'] ?? null;
        if (!$holidayData) {
            echo "Invalid holiday data.";
            return;
        }
        $hashed_id = $holidayData['md5_id'] ?? null;
        if (!$hashed_id) {
            return;
        }

        print_r($holidayData);

        $name = isset($holidayData['name']) && $holidayData['name'] !== '' ? validateInput($holidayData['name'], "Name") : null;
        $startDate = isset($holidayData['start_date']) ? 
                date('Y-m-d', strtotime(validateInput($holidayData['start_date'], 'Start Date'))) : '1970-01-01';
        $endDate = isset($holidayData['end_date']) ? 
                date('Y-m-d', strtotime(validateInput($holidayData['end_date'], 'End Date'))) : '1970-01-01';
        $isPaid = isset($holidayData['isPaid']) && $holidayData['isPaid'] !== '' ? $holidayData['isPaid'] : null;
        $isRecurring = isset($holidayData['isRecurring']) && $holidayData['isRecurring'] !== '' ? $holidayData['isRecurring'] : null;
        $description = isset($holidayData['description']) ? $holidayData['description'] : null;
        $status = isset($holidayData['status']) ? validateInput($holidayData['status'], "Status") : null;
        
        $updatedHoliday = new Holiday(
            id: $hashed_id,
            name: $name,
            startDate: $startDate,
            endDate: $endDate,
            isPaid: $isPaid,
            isRecurringAnnually: $isRecurring,
            description: $description,
            status: $status
        );
        $holidayRepository = new HolidayRepository($holidayDao);
        $holidayService = new HolidayService($holidayRepository);
        $result = $holidayService->updateHoliday($newHoliday);
        
        if ($result !== ActionResult::FAILURE) {
            die("
            <script>
                showSuccessUpdate();
            </script>
            ");
        } else {
            echo "Failed to update holidays. Please try again.";
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