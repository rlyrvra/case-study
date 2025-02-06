<?php
require_once __DIR__ . '/../Holiday.php';
require_once __DIR__ . '/../HolidayDao.php';
require_once __DIR__ . '/../HolidayRepository.php';
require_once __DIR__ . '/../HolidayService.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../includes/enums/ErrorCode.php';
require_once __DIR__ . '/../../database/database.php';

function getHolidays(){
    global $pdo;
    $holidayDao = new HolidayDao($pdo);
    $holidayRepo = new HolidayRepository($holidayDao);
    $holidayService = new HolidayService($holidayRepo);
    $selectedColumns = ["id", "name", "start_date", "end_date", "description", "is_recurring_annually"];
    $filterCriteria = [
        [
            "column" => "holiday.status",
            "operator" => "=",
            "value" => "Active"
        ]
    ];
    $data = $holidayService->fetchAllHolidays($selectedColumns, $filterCriteria);
    $holidays = $data['result_set'];
    return $holidays;
}

?>

<script>
const holidays = getHolidays();
function getHolidays(){
    const values = <?php 
        $holidays = getHolidays();
        echo json_encode($holidays); 
        ?>;
    return values;
}


</script>