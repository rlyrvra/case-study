<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

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
        $viewMode = isset($_POST['view_mode']) ? $_POST['view_mode'] : 'table';
        
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
        
        if($viewMode == 'table'){
            include __DIR__ . '/deductions-table.php';
        }
        else{
            include __DIR__ . '/deductions-table-card.php';
        }
        return;
    }

    if($action === 'create'){
        $deductionsData = $_POST['deduction'] ?? null;
        if (!$deductionsData) {
            return;
        }

        $deductionRepository = new DeductionRepository($deductionDao);
        $deductionService = new DeductionService($deductionRepository);
        $result = $deductionService->createDeduction($_POST['deduction']);
        
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

        $deductionsData = $_POST['deduction'] ?? null;
        if (!$deductionsData) {
            return;
        }
        
        $deductionId = $deductionsData['id'] ?? null;
        if (!$deductionId) {
            return;
        }

        $deductionRepository = new DeductionRepository($deductionDao);
        $deductionService = new DeductionService($deductionRepository);
        $result = $deductionService->updateDeduction($deductionsData);
        

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
        $deductionData = $_POST['deduction'] ?? null;
        if (!$deductionData) {
            return;
        }

        $deductionData = json_decode($deductionData, true);
        $deductionId = $deductionData['id'] ?? null;
        if (!$deductionId) {
            return;
        }

        $deductionRepository = new DeductionRepository($deductionDao);
        $deductionService = new DeductionService($deductionRepository);
        $result = $deductionService->deleteDeduction($deductionId);

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