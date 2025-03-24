<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../Allowance.php';
require_once __DIR__ . '/../AllowanceDao.php';
require_once __DIR__ . '/../AllowanceRepository.php';
require_once __DIR__ . '/../AllowanceService.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../database/database.php';


// echo "<br>";
// echo "[create] API FILE (allowanceData): ";
// print_r($allowanceData);
// echo "<br>";

try {
    $allowanceDao = new AllowanceDao($pdo);
    $allowanceRepository = new AllowanceRepository($allowanceDao);
    $allowanceService = new AllowanceService($allowanceRepository);
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

        $result = $allowanceService->fetchAllAllowances([], $filterCriteria, $sortCriteria, $limit, $offset);
        $allowances;
        if ($result !== ActionResult::FAILURE) {
            $allowances = $result['result_set'];
        }

        
        $totalAllowances = $result["total_row_count"];
        $totalPages = ceil($totalAllowances / $limit);
        
        if($viewMode == 'table'){
            include __DIR__ . '/allowance-table.php';
        }
        else{
            include __DIR__ . '/allowance-table-card.php';
        }
        return;
    }

    
    if($action === 'create'){
        $allowanceData = $_POST['allowance'] ?? null;
        
        if ($allowanceData == null) {
            return;
        }

        $result = $allowanceService->createAllowance($_POST['allowance']);

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
            </script>
            ");
        }

        return;
    }

    if($action == 'update'){
        $allowanceData = $_POST['allowance'] ?? null;
        if (!$allowanceData) {
            return;
        }
        $hashed_id = $allowanceData['id'] ?? null;
        if (!$hashed_id) {
            return;
        }


        $result = $allowanceService->updateAllowance($_POST['allowance']);
        

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
            </script>
            ");
        }
        
        return;
    }
        
    if($action == 'delete'){
        $allowance = $_POST['allowance'] ?? null;

        if (!$allowance) {
            return;
        }

        $result = $allowanceService->deleteAllowance($allowance['id']);

        if (isset($result['status']) && $result['status'] === 'success') {
            die("
            <script>
                showSuccessDeletion();
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