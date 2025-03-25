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
        $viewMode = isset($_POST['view_mode']) ? $_POST['view_mode'] : 'table';
        
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
        
        
        if($viewMode == 'table'){
            include __DIR__ . '/payroll-groups-table.php';
        }
        else{
            include __DIR__ . '/payroll-groups-table-card.php';
        }


        return;
    }

    if($action === 'create'){
        $payrollGroupData = $_POST['payroll_group'] ?? null;
        if ($payrollGroupData == null) {
            return;
        }

        //print_r($payrollGroupData);

        $payrollGroupRepository = new PayrollGroupRepository($payrollGroupDao);
        $payrollGroupService = new PayrollGroupService($payrollGroupRepository);
        $result = $payrollGroupService->createPayrollGroup($payrollGroupData);
        //print_r($result);
        if (isset($result['status']) && $result['status'] === 'success') {
            die("
            <script>
                showSuccessCreate();
            </script>
            ");
        } else if (isset($result['status']) && $result['status'] === 'error') {
            die("
            <script>
                showError(" . json_encode($result['message']) . ");
            </script>
            ");
        } else if (isset($result['status']) && $result['status'] === 'invalid_input'){
            die("
            <script>
                showValidationError(" . json_encode($result['errors']) . ");
                $('#add_payrollGroups_modal').modal('show');
            </script>
            ");
        }

        return;
    }

    if($action === 'update'){
        $payrollGroupData = $_POST['payroll_group'] ?? null;
        if (!$payrollGroupData) {
            return;
        }
        if (!$payrollGroupData['id']){
            return;
        }

        //print_r($payrollGroupData);
        $payrollGroupRepository = new PayrollGroupRepository($payrollGroupDao);
        $payrollGroupService = new PayrollGroupService($payrollGroupRepository);
        $result = $payrollGroupService->updatePayrollGroup($payrollGroupData);
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
                $('#update-payrollGroups-modal').modal('hide');
            </script>
            ");
        }

        return;
    }



    


    if($action === 'delete'){
        $payrollGroupData = $_POST['payroll_group'] ?? null;
        if (!$payrollGroupData) {
            return;
        }
        $token = $_POST['id'] ?? null;
        if (!$token) {
            return;
        }
        $payrollGroupRepository = new PayrollGroupRepository($payrollGroupDao);
        $payrollGroupService = new PayrollGroupService($payrollGroupRepository);
        $result = $payrollGroupService->deletePayrollGroup($token);
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