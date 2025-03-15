<?php
if (
    !isset($_SERVER['HTTP_X_REQUESTED_BY']) || 
    $_SERVER['HTTP_X_REQUESTED_BY'] !== 'getDayType'
) {
    exit(json_encode(['error' => 'Unauthorized request.']));
}

require_once __DIR__ . '/../../holidays/HolidayService.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../database/database.php';

try {
    $holidayDao = new HolidayDao($pdo);
    $holidayRepository = new HolidayRepository($holidayDao);
    $holidayService = new HolidayService($holidayRepository);
    $action = $_SERVER['HTTP_X_REQUESTED_BY'] ?? '';
    if ($action === 'getDayType'){
        header('Content-Type: application/json');
        $originalDateTime = new DateTime();
        $recurringHolidays = findValidRecurringHolidays($originalDateTime, $holidayService);
        //echo $originalDateTime->format('Y-m-d');
        if(isset($recurringHolidays['is_recurring']) && $recurringHolidays['is_recurring']){
            echo json_encode([
                'dayType' => $recurringHolidays['dayType'],
                'is_recurring' => $recurringHolidays['is_recurring']
            ]);
            return;
        }
        $selectedColumns = [
            'is_paid'
        ];
        $filterCriteria = [
            [
                "column" => "DATE_FORMAT(holiday.start_date, '%Y-%m-%d')",
                "operator" => "<=",
                "value" => $originalDateTime->format('Y-m-d')
            ],
            [
                "column" => "DATE_FORMAT(holiday.end_date, '%Y-%m-%d')",
                "operator" => ">=",
                "value" => $originalDateTime->format('Y-m-d')
            ],
            [
                "column" => "holiday.status",
                "operator" => "=",
                "value" => "Active"
            ]
        ];
        $sortCriteria = [
            [
                "column" => "holiday.start_date",
                "direction" => "ASC"
            ]
        ];
        $result = $holidayService->fetchAllHolidays($selectedColumns, $filterCriteria, [], 1, 0, false);
        $dayType = 'Regular Day';
        if(isset($result['result_set']) && !empty($result['result_set'])){
            $dayType = $result['result_set'][0]['is_paid'] === 1 ? 'Regular Holiday' : 'Special Holiday';
        }else if($result['result_set'] === ActionResult::FAILURE){
            echo json_encode([
                'status' => 'error',
                'message' => 'An error occurred while processing your day type request. Please try again later.'
            ]);
        }
        echo json_encode([
            'dayType' => $dayType,
            'is_recurring' => false
        ]);
    }

}catch(Throwable $e){
    echo json_encode([
        'status' => 'error',
        'message' => 'A fatal error occurred while processing your day type request. Please try again later.',
        'error_message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
        'trace' => $e->getTraceAsString()
    ], JSON_PRETTY_PRINT);
    exit();
}

function findValidRecurringHolidays($originalDateTime, $holidayService): array{
    $selectedColumns = [
        'is_paid',
        'is_recurring_annually'
    ];
    $filterCriteria = [
        [
            "column" => "holiday.start_date",
            "operator" => "<=",
            "value" => $originalDateTime->format('Y-m-d')
        ],
        [
            "column" => "DATE_FORMAT(holiday.start_date, '%m-%d')",
            "operator" => "<=",
            "value" => $originalDateTime->format('m-d')
        ],
        [
            "column" => "DATE_FORMAT(holiday.end_date, '%m-%d')",
            "operator" => ">=",
            "value" => $originalDateTime->format('m-d')
        ],
        [
            "column" => "holiday.status",
            "operator" => "=",
            "value" => "Active"
        ],
        [
            "column" => "holiday.is_recurring_annually",
            "operator" => "=",
            "value" => 1
        ]
    ];
    $sortCriteria = [
        [
            "column" => "holiday.start_date",
            "direction" => "ASC"
        ]
    ];
    $result = $holidayService->fetchAllHolidays($selectedColumns, $filterCriteria, $sortCriteria, 1, 0, false);
    $dayType = 'Regular Day';
    $is_recurring = false;
    if(isset($result['result_set']) && !empty($result['result_set'])){
        $dayType = $result['result_set'][0]['is_paid'] === 1 ? 'Regular Holiday' : 'Special Holiday';
        $is_recurring = $result['result_set'][0]['is_recurring_annually'] ? true : false;
    }else if($result['result_set'] === ActionResult::FAILURE){
        echo json_encode([
            'status' => 'error',
            'message' => 'An error occurred while processing your day type request. Please try again later.'
        ]);
        return [];
    }
    return [
        'dayType' => $dayType,
        'is_recurring' => $is_recurring
    ];
}