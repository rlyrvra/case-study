<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../../PayrollGroup.php';
require_once __DIR__ . '/../../PayrollGroupDao.php';
require_once __DIR__ . '/../../PayrollGroupRepository.php';
require_once __DIR__ . '/../../PayrollGroupService.php';

require_once __DIR__ . '/../../../includes/Helper.php';
require_once __DIR__ . '/../../../database/database.php';


try {
    $payrollGroupDao = new PayrollGroupDao($pdo);
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
                "column" => "payroll_group.status",
                "operator" => "=",
                "value" => $status
            ];
        }

        if(empty($searchAt) && !empty($searchFilter)){
            $filterCriteria[] = [
                "column" => "payroll_group.name", 
                "operator" => "LIKE",
                "value" => "%$searchFilter%", 
                'boolean' => 'OR'

            ];
            $filterCriteria[] = [
                "column" => "payroll_group.payroll_frequency", 
                "operator" => "LIKE",
                "value" => "%$searchFilter%", 
                'boolean' => 'OR'
            ];
        }

        if(!empty($searchFilter) && !empty($searchAt)){
            $filterCriteria[] = [
                "column" => "payroll_group." . $searchAt, 
                "operator" => "LIKE",
                "value" => "%$searchFilter%"
            ];
        }

        if((!empty($dateFilterColumn) && $dateFilterColumn !== "none") && !empty($dateStart) && !empty($dateEnd)){
            $filterCriteria[] = [
                "column" => "payroll_group." . $dateFilterColumn,
                "operator" => "BETWEEN",
                "lower_bound" => $dateStart,
                "upper_bound" => $dateEnd
            ];
        }


        $sortCriteria = [
            [
                "column" => "payroll_group." . $_POST['sort_by'],
                "direction" => $_POST['sort_order']
            ]
        ];
        $payrollGroupRepository = new PayrollGroupRepository($payrollGroupDao);
        $payrollGroupService = new PayrollGroupService($payrollGroupRepository);
        $result = $payrollGroupService->fetchAllPayrollGroups([], $filterCriteria, $sortCriteria, $limit, $offset);
        $payrollGroups;
        if ($result !== ActionResult::FAILURE) {
            $payrollGroups = $result['result_set'];
        }

        $totalPayrollGroups = $result["total_row_count"];
        $totalPages = ceil($totalPayrollGroups / $limit);
        include __DIR__ . '/payroll-groups-table.php';
        return;
    }

    if($action === 'create'){
        $payrollGroupData = $_POST['payroll_groups_data'] ?? null;
        if ($payrollGroupData == null) {
            return;
        }

        //print_r($payrollGroupData);

        $name = isset($payrollGroupData['name']) && $payrollGroupData['name'] !== '' ? validateInput($payrollGroupData['name'], "Name") : null;
        $freq = isset($payrollGroupData['payroll_frequency']) && $payrollGroupData['payroll_frequency'] !== '' ? validateInput($payrollGroupData['payroll_frequency'], "Payroll Frequency") : null;
        $weeklyDay = isset($payrollGroupData['day_of_weekly_cutoff']) && $payrollGroupData['day_of_weekly_cutoff'] !== '' ? (int) validateInput($payrollGroupData['day_of_weekly_cutoff'], "Day of Weekly Cutoff") : null;
        $biWeeklyDay = isset($payrollGroupData['day_of_biweekly_cutoff']) && $payrollGroupData['day_of_biweekly_cutoff'] !== '' ? (int) validateInput($payrollGroupData['day_of_biweekly_cutoff'], "Day of Bi-Weekly Cutoff") : null;
        $semiFirst = isset($payrollGroupData['semi_monthly_first_cutoff']) && $payrollGroupData['semi_monthly_first_cutoff'] !== '' ? (int) validateInput($payrollGroupData['semi_monthly_first_cutoff'], "Semi First Cutoff") : null;
        $semiSecond = isset($payrollGroupData['semi_monthly_second_cutoff']) && $payrollGroupData['semi_monthly_second_cutoff'] !== '' ? (int) validateInput($payrollGroupData['semi_monthly_second_cutoff'], "Semi Second Cutoff") : null;
        $payOffset = isset($payrollGroupData['payday_offset']) && $payrollGroupData['payday_offset'] !== '' ? (int) validateInput($payrollGroupData['payday_offset'], "Payday Offset") : null;
        $payAdjustment = isset($payrollGroupData['payday_adjustment']) && $payrollGroupData['payday_adjustment'] !== '' ? validateInput($payrollGroupData['payday_adjustment'], "Payday Offset") : null;
        $status = isset($payrollGroupData['status']) && $payrollGroupData['status'] !== '' ? validateInput($payrollGroupData['status'], "Status") : null;

        $payrollGroupRepository = new PayrollGroupRepository($payrollGroupDao);
        $payrollGroupService = new PayrollGroupService($payrollGroupRepository);
        $newPayrolLGroup = new PayrollGroup(
            id: null,
            name: $name,
            payrollFrequency: $freq,
            dayOfWeeklyCutoff: $weeklyDay,
            dayOfBiweeklyCutoff: $biWeeklyDay,
            semiMonthlyFirstCutoff: $semiFirst,
            semiMonthlySecondCutoff: $semiSecond,
            paydayOffset: $payOffset,
            paydayAdjustment: $payAdjustment,
            status: $status
        );
        $createResult = $payrollGroupService->createPayrollGroup($newPayrolLGroup);
        switch ($createResult) {
            case ActionResult::FAILURE:
                
                break;
            case ActionResult::SUCCESS:
                die("
                <script>
                    showSuccessCreate();
                </script>
                ");
                break;
            default:
                
                break;
        }

        return;
    }

    if($action === 'update'){
        $payrollGroupData = $_POST['payroll_groups_data'] ?? null;
        if (!$payrollGroupData) {
            return;
        }
        if (!$payrollGroupData['token']){
            return;
        }

        // print_r($payrollGroupData);
        $token = isset($payrollGroupData['token']) && $payrollGroupData['token'] !== '' ? $payrollGroupData['token'] : null;
        $name = isset($payrollGroupData['name']) && $payrollGroupData['name'] !== '' ? validateInput($payrollGroupData['name'], "Name") : null;
        $freq = isset($payrollGroupData['payroll_frequency']) && $payrollGroupData['payroll_frequency'] !== '' ? validateInput($payrollGroupData['payroll_frequency'], "Payroll Frequency") : null;
        $weeklyDay = isset($payrollGroupData['day_of_weekly_cutoff']) && $payrollGroupData['day_of_weekly_cutoff'] !== '' ? (int) validateInput($payrollGroupData['day_of_weekly_cutoff'], "Day of Weekly Cutoff") : null;
        $biWeeklyDay = isset($payrollGroupData['day_of_biweekly_cutoff']) && $payrollGroupData['day_of_biweekly_cutoff'] !== '' ? (int) validateInput($payrollGroupData['day_of_biweekly_cutoff'], "Day of Bi-Weekly Cutoff") : null;
        $semiFirst = isset($payrollGroupData['semi_monthly_first_cutoff']) && $payrollGroupData['semi_monthly_first_cutoff'] !== '' ? (int) validateInput($payrollGroupData['semi_monthly_first_cutoff'], "Semi First Cutoff") : null;
        $semiSecond = isset($payrollGroupData['semi_monthly_second_cutoff']) && $payrollGroupData['semi_monthly_second_cutoff'] !== '' ? (int) validateInput($payrollGroupData['semi_monthly_second_cutoff'], "Semi Second Cutoff") : null;
        $payOffset = isset($payrollGroupData['payday_offset']) && $payrollGroupData['payday_offset'] !== '' ? (int) validateInput($payrollGroupData['payday_offset'], "Payday Offset") : null;
        $payAdjustment = isset($payrollGroupData['payday_adjustment']) && $payrollGroupData['payday_adjustment'] !== '' ? validateInput($payrollGroupData['payday_adjustment'], "Payday Offset") : null;
        $status = isset($payrollGroupData['status']) && $payrollGroupData['status'] !== '' ? validateInput($payrollGroupData['status'], "Status") : null;

        $payrollGroupRepository = new PayrollGroupRepository($payrollGroupDao);
        $payrollGroupService = new PayrollGroupService($payrollGroupRepository);
        $updatedPayrollGroup = new PayrollGroup(
            id: $token,
            name: $name,
            payrollFrequency: $freq,
            dayOfWeeklyCutoff: $weeklyDay,
            dayOfBiweeklyCutoff: $biWeeklyDay,
            semiMonthlyFirstCutoff: $semiFirst,
            semiMonthlySecondCutoff: $semiSecond,
            paydayOffset: $payOffset,
            paydayAdjustment: $payAdjustment,
            status: $status
        );
        $updateResult = $payrollGroupService->updatePayrollGroup($updatedPayrollGroup);
        switch ($updateResult) {
            case ActionResult::FAILURE:
                
                break;
            case ActionResult::SUCCESS:
                die("
                <script>
                    showSuccessUpdate();
                </script>
                ");
                break;
            default:
                
                break;
        }

        return;
    }



    


    if($action === 'delete'){
        $token = $_POST['token'] ?? null;
        if (!$token) {
            return;
        }
        $payrollGroupRepository = new PayrollGroupRepository($payrollGroupDao);
        $payrollGroupService = new PayrollGroupService($payrollGroupRepository);
        $deleteResult = $payrollGroupService->deletePayrollGroup($token);
        switch ($deleteResult) {
            case ActionResult::FAILURE:
                
                break;
            case ActionResult::SUCCESS:
                die("
                <script>
                    showSuccessDeletion();
                </script>
                ");
                break;
            default:
                
                break;
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