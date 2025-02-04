<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../Allowance.php';
require_once __DIR__ . '/../AllowanceDao.php';
require_once __DIR__ . '/../AllowanceRepository.php';
require_once __DIR__ . '/../AllowanceService.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../includes/enums/ErrorCode.php';
require_once __DIR__ . '/../../database/database.php';

try {
    $allowanceDao = new AllowanceDao($pdo);
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
                "column" => "allowance.status",
                "operator" => "=",
                "value" => $status
            ];
        }

        if(empty($searchAt) && !empty($searchFilter)){
            $filterCriteria[] = [
                "column" => "allowance.name", 
                "operator" => "LIKE",
                "value" => "%$searchFilter%", 
                'boolean' => 'OR'

            ];
            $filterCriteria[] = [
                "column" => "allowance.description", 
                "operator" => "LIKE",
                "value" => "%$searchFilter%", 
                'boolean' => 'OR'
            ];
        }

        if(!empty($searchFilter) && !empty($searchAt)){
            $filterCriteria[] = [
                "column" => "allowance." . $searchAt, 
                "operator" => "LIKE",
                "value" => "%$searchFilter%"
            ];
        }

        if((!empty($dateFilterColumn) && $dateFilterColumn !== "none") && !empty($dateStart) && !empty($dateEnd)){
            $filterCriteria[] = [
                "column" => "allowance." . $dateFilterColumn,
                "operator" => "BETWEEN",
                "lower_bound" => $dateStart,
                "upper_bound" => $dateEnd
            ];
        }


        $sortCriteria = [
            [
                "column" => "allowance." . $_POST['sort_by'],
                "direction" => $_POST['sort_order']
            ]
        ];
        $allowanceRepository = new AllowanceRepository($allowanceDao);
        $allowanceService = new AllowanceService($allowanceRepository);
        $result = $allowanceService->fetchAllAllowances([], $filterCriteria, $sortCriteria, $limit, $offset);
        $allowances;
        if ($result !== ActionResult::FAILURE) {
            $allowances = $result['result_set'];
        }

        $totalAllowances = $result["total_row_count"];
        $totalPages = ceil($totalAllowances / $limit);
        include __DIR__ . '/allowance-table.php';
        return;
    }

    
    if($action === 'create'){
        $allowanceData = $_POST['allowance'] ?? null;
        if ($allowanceData == null) {
            echo "Invalid allowance data.";
            return;
        }

        $name = isset($allowanceData['name']) && $allowanceData['name'] !== '' ? validateInput($allowanceData['name'], "Name") : null;
        $amount = isset($allowanceData['amount']) && $allowanceData['amount'] !== 0 ? validateNumericIdentifier((int) $allowanceData['amount'], 1, 30, "Amount") : null;
        $frequency = isset($allowanceData['frequency']) && $allowanceData['frequency'] !== '' ? validateInput($allowanceData['frequency'], "Frequency") : null;
        $description = isset($allowanceData['description']) ? $allowanceData['description'] : null;
        $status = isset($allowanceData['status']) ? validateInput($allowanceData['status'], "Status") : null;
        
        $newAllowance = new Allowance(
            id: null,
            name: $name,
            amount: $amount,
            frequency: $frequency,
            description: $description,
            status: $status
        );
        $allowanceRepository = new AllowanceRepository($allowanceDao);
        $allowanceService = new AllowanceService($allowanceRepository);
        $result = $allowanceService->createAllowance($newAllowance);
        
        if ($result !== ActionResult::FAILURE) {
            die("
            <script>
                showSuccessCreate();
            </script>
            ");
        } else {
            echo "Failed to create department. Please try again.";
        }
        return;
    }

    if($action == 'update'){
        $allowanceData = $_POST['allowanceData'] ?? null;
        if (!$allowanceData) {
            echo "Invalid allowance data.";
            return;
        }


        $name = isset($allowanceData['name']) && $allowanceData['name'] !== '' ? validateInput($allowanceData['name'], "Name") : null;
        $amount = isset($allowanceData['amount']) && $allowanceData['amount'] !== 0 ? validateNumericIdentifier((int) $allowanceData['amount'], 1, 30, "Amount") : null;
        $frequency = isset($allowanceData['frequency']) && $allowanceData['frequency'] !== '' ? validateInput($allowanceData['frequency'], "Frequency") : null;
        $description = isset($allowanceData['description']) ? $allowanceData['description'] : null;
        $status = isset($allowanceData['status']) ? validateInput($allowanceData['status'], "Status") : null;
        $hashed_id = $allowanceData['md5_id'] ?? '';

        $updatedAllowance = new Allowance(
            id: $hashed_id,
            name: $name,
            amount: $amount,
            frequency: $frequency,
            description: $description,
            status: $status
        );
        $allowanceRepository = new AllowanceRepository($allowanceDao);
        $allowanceService = new AllowanceService($allowanceRepository);
        $result = $allowanceService->updateAllowance($updatedAllowance);
        
        if ($result !== ActionResult::FAILURE) {
            die("
            <script>
                showSuccessUpdate();
            </script>
            ");
        } else {
            echo "Failed to create department. Please try again.";
        }
        return;
    }
        
    if($action == 'delete'){
        $hashed_id = $_POST['md5_id'] ?? null;
        $allowanceRepository = new AllowanceRepository($allowanceDao);
        $allowanceService = new AllowanceService($allowanceRepository);
        $result = $allowanceService->deleteAllowance($hashed_id);

        if ($result) {
            die("
            <script>
                showSuccessDeletion();
            </script>
            ");
        } else {
            echo "Failed to delete department. Please try again.";
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