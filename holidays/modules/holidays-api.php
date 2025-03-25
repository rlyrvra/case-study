<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../Holiday.php';
require_once __DIR__ . '/../HolidayDao.php';
require_once __DIR__ . '/../HolidayRepository.php';
require_once __DIR__ . '/../HolidayService.php';

require_once __DIR__ . '/../../includes/Helper.php';
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
        $viewMode = isset($_POST['view_mode']) ? $_POST['view_mode'] : 'table';
        
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
        }else if($result === ActionResult::FAILURE){
            $message = 'Failed to fetch holidays. Please try again.';
            die('
            <script>
                showError(' . json_encode($message) 
            . ');
            </script>');
        }

        $totalHolidays = $result["total_row_count"];
        $totalPages = ceil($totalHolidays / $limit);
        
        if($viewMode == 'table'){
            include __DIR__ . '/holidays-table.php';
        }
        else{
            include __DIR__ . '/holidays-table-card.php';
        }
        return;
    }

    if($action === 'create'){
        $holidayData = $_POST['holiday'] ?? null;
        if ($holidayData == null) {
            echo "Invalid holiday data.";
            return;
        }
        
        $holidayRepository = new HolidayRepository($holidayDao);
        $holidayService = new HolidayService($holidayRepository);
        $result = $holidayService->createHoliday($holidayData);
    

        if (isset($result['status']) && $result['status'] === 'success') {
            die("
            <script>
                showSuccessCreate();
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
                $('#add-holidays-modal').modal('show');
            </script>
            ");
        }
        return;
    }


    if($action === 'update'){
        $holidayData = $_POST['holiday'] ?? null;
        if (!$holidayData) {
            return;
        }
        $hashed_id = $holidayData['id'] ?? null;
        if (!$hashed_id) {
            return;
        }

        $holidayRepository = new HolidayRepository($holidayDao);
        $holidayService = new HolidayService($holidayRepository);
        $result = $holidayService->updateHoliday($holidayData);


        if (isset($result['status']) && $result['status'] === 'success') {
            die("
            <script>
                showSuccessUpdate();
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
                $('#update-holidays-modal').modal('show');
            </script>
            ");
        }
        return;
    }


    if($action === 'delete'){
        $holidayData = $_POST['holiday'] ?? null;
        if (!$holidayData) {
            return;
        }
        $hashed_id = $holidayData['id'] ?? null;
        if (!$hashed_id) {
            return;
        }

        $holidayRepository = new HolidayRepository($holidayDao);
        $holidayService = new HolidayService($holidayRepository);
        $result = $holidayService->deleteHoliday($hashed_id);
        
        if (isset($result['status']) && $result['status'] === 'success') {
            die("
            <script>
                showSuccessDelete();
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