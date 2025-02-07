<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../Deduction.php';
require_once __DIR__ . '/../DeductionDao.php';
require_once __DIR__ . '/../DeductionRepository.php';
require_once __DIR__ . '/../DeductionService.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../database/database.php';


try {
    $deductionDao = new DeductionDao($pdo);
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
                "column" => "deduction.status",
                "operator" => "=",
                "value" => $status
            ];
        }

        if(empty($searchAt) && !empty($searchFilter)){
            $filterCriteria[] = [
                "column" => "deduction.name", 
                "operator" => "LIKE",
                "value" => "%$searchFilter%", 
                'boolean' => 'OR'

            ];
            $filterCriteria[] = [
                "column" => "deduction.description", 
                "operator" => "LIKE",
                "value" => "%$searchFilter%", 
                'boolean' => 'OR'
            ];
        }

        if(!empty($searchFilter) && !empty($searchAt)){
            $filterCriteria[] = [
                "column" => "deduction." . $searchAt, 
                "operator" => "LIKE",
                "value" => "%$searchFilter%"
            ];
        }

        if((!empty($dateFilterColumn) && $dateFilterColumn !== "none") && !empty($dateStart) && !empty($dateEnd)){
            $filterCriteria[] = [
                "column" => "deduction." . $dateFilterColumn,
                "operator" => "BETWEEN",
                "lower_bound" => $dateStart,
                "upper_bound" => $dateEnd
            ];
        }


        $sortCriteria = [
            [
                "column" => "deduction." . $_POST['sort_by'],
                "direction" => $_POST['sort_order']
            ]
        ];
        $deductionRepository = new DeductionRepository($deductionDao);
        $deductionService = new DeductionService($deductionRepository);
        $result = $deductionService->fetchAllDeductions([], $filterCriteria, $sortCriteria, $limit, $offset);
        $deductions;
        if ($result !== ActionResult::FAILURE) {
            $deductions = $result['result_set'];
        }

        $totalDeductions = $result["total_row_count"];
        $totalPages = ceil($totalDeductions / $limit);
        include __DIR__ . '/deductions-table.php';
        return;
    }

    if($action === 'create'){
        $deductionsData = $_POST['deduction'] ?? null;
        if (!$deductionsData) {
            echo "Invalid deduction data.";
            return;
        }

        $name = isset($deductionsData['name']) && $deductionsData['name'] !== '' ? validateInput($deductionsData['name'], "Name") : null;
        $amount = isset($deductionsData['amount']) && $deductionsData['amount'] !== 0 ? validateNumericIdentifier((int) $deductionsData['amount'], 1, 30, "Amount") : null;
        $frequency = isset($deductionsData['frequency']) && $deductionsData['frequency'] !== '' ? validateInput($deductionsData['frequency'], "Frequency") : null;
        $description = isset($deductionsData['description']) ? $deductionsData['description'] : null;
        $status = isset($deductionsData['status']) ? validateInput($deductionsData['status'], "Status") : null;
        
        $newDeduction = new Deduction(
            id: null,
            name: $name,
            amount: $amount,
            frequency: $frequency,
            description: $description,
            status: $status
        );
        $deductionRepository = new DeductionRepository($deductionDao);
        $deductionService = new DeductionService($deductionRepository);
        $result = $deductionService->createDeduction($newDeduction);
        
        if ($result !== ActionResult::FAILURE) {
            die("
            <script>
                showSuccessCreate();
            </script>
            ");
        } else {
            echo "Failed to create deduction. Please try again.";
        }
        return;
    }

    if($action == 'update'){

        $deductionsData = $_POST['deduction'] ?? null;
        if (!$deductionsData) {
            return;
        }
        $hashed_id = $deductionsData['md5_id'] ?? null;
        if (!$hashed_id) {
            return;
        }

        $name = isset($deductionsData['name']) && $deductionsData['name'] !== '' ? validateInput($deductionsData['name'], "Name") : null;
        $amount = isset($deductionsData['amount']) && $deductionsData['amount'] !== 0 ? validateNumericIdentifier((int) $deductionsData['amount'], 1, 30, "Amount") : null;
        $frequency = isset($deductionsData['frequency']) && $deductionsData['frequency'] !== '' ? validateInput($deductionsData['frequency'], "Frequency") : null;
        $description = isset($deductionsData['description']) ? $deductionsData['description'] : null;
        $status = isset($deductionsData['status']) ? validateInput($deductionsData['status'], "Status") : null;
        
        $updateDeduction = new Deduction(
            id: $hashed_id,
            name: $name,
            amount: $amount,
            frequency: $frequency,
            description: $description,
            status: $status
        );
        $deductionRepository = new DeductionRepository($deductionDao);
        $deductionService = new DeductionService($deductionRepository);
        $result = $deductionService->updateDeduction($updateDeduction);
        
        if ($result !== ActionResult::FAILURE) {
            die("
            <script>
                showSuccessUpdate();
            </script>
            ");
        } else {
            echo "Failed to update deduction. Please try again.";
        }

        return;

    }

    if($action == 'delete'){
        $hashed_id = $_POST['md5_id'] ?? null;
        $deductionRepository = new DeductionRepository($deductionDao);
        $deductionService = new DeductionService($deductionRepository);
        $result = $deductionService->deleteDeduction($hashed_id);

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