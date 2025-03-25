<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../leave-types/LeaveType.php';
require_once __DIR__ . '/../leave-types/LeaveTypeRepository.php';
require_once __DIR__ . '/../leave-types/LeaveTypeService.php';
require_once __DIR__ . '/../leave-types/LeaveTypeDao.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../database/database.php';

try {
    $userId = 1;
    $leaveTypeDao = new LeaveTypeDao($pdo);
    $action = $_POST['action'] ?? '';
    

    if($action === 'fetchAll'){
        $status = $_POST['filter_status'];
        $searchAt = isset($_POST['filter_searchAt']) & $_POST['filter_searchAt'] !== "none" ? $_POST['filter_searchAt'] : null;
        $searchFilter = $_POST['filter_search'];
        $dateFilterColumn = $_POST['filter_date_column'];
        $dateStart = isset($_POST['filter_startDate']) && $dateFilterColumn !== "none" ? $_POST['filter_startDate'] : 0;
        $dateEnd = isset($_POST['filter_endDate']) && $dateFilterColumn !== "none" ? $_POST['filter_endDate'] : 0;
        $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        $limit = isset($_POST['numberEntries']) ? $_POST['numberEntries'] : 5;
        $offset = ($page - 1) * $limit;
        $viewMode = isset($_POST['view_mode']) ? $_POST['view_mode'] : 'table';
        
        $filterCriteria = [];
        
        if(!empty($status)){
            $filterCriteria[] = [
                "column" => "leave_type.status",
                "operator" => "=",
                "value" => $status
            ];
        }

        $searchColumns = ['name', 'description'];
        if(empty($searchAt) && !empty($searchFilter)){
            foreach($searchColumns as $searchColumn){
                $filterCriteria[] = [
                    "column" => "leave_type." . $searchColumn, 
                    "operator" => "LIKE",
                    "value" => "%$searchFilter%", 
                    'boolean' => 'OR'
    
                ];
            }
            
        }


        if(!empty($searchFilter) && !empty($searchAt)){
            $filterCriteria[] = [
                "column" => "leave_type." . $searchAt,
                "operator" => "LIKE",
                "value" => "%$searchFilter%"
            ];
        }


        if((!empty($dateFilterColumn) && $dateFilterColumn !== "none") && !empty($dateStart) && !empty($dateEnd)){
            $filterCriteria[] = [
                "column" => "leave_type." . $dateFilterColumn,
                "operator" => "BETWEEN",
                "lower_bound" => $dateStart,
                "upper_bound" => $dateEnd
            ];
        }
        
        $sortCriteria = [
            [
                "column" => "leave_type." . $_POST['sort_by'],
                "direction" => $_POST['sort_order']
            ]
        ];

        //print_r($filterCriteria);
        
        $leaveTypeRepository = new LeaveTypeRepository($leaveTypeDao);
        $leaveTypeService = new LeaveTypeService($leaveTypeRepository);
        $result = $leaveTypeService->fetchAllLeaveTypes([], $filterCriteria, $sortCriteria, $limit, $offset);

        if($result !== ActionResult::FAILURE){
            $leaveTypes = $result["result_set"];
        }

        $totalLeaveTypes = $result["total_row_count"];
        $totalPages = ceil($totalLeaveTypes / $_POST['numberEntries']);
        if($viewMode == 'table'){
            include __DIR__ . '/leave-types-table.php';
        }
        else{
            include __DIR__ . '/leave-types-table-card.php';
        }
        
        return;

    }

    if ($action === 'create') {
        $leaveTypesData = $_POST['leave_type'] ?? null;
        if (!$leaveTypesData) {
            return;
        } 


        $leaveTypeRepository = new LeaveTypeRepository($leaveTypeDao);
        $leaveTypeService = new LeaveTypeService($leaveTypeRepository);
        $result = $leaveTypeService->createLeaveType($leaveTypesData);

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
                $('#add_leave_types_modal').modal('show');
            </script>
            ");
        }

        return;
    }
    
    if($action == 'delete'){
        $leaveTypesData = $_POST['leave_type'] ?? null;
        if (!$leaveTypesData) {
            return;
        } 
        $hashed_id = $leaveTypesData['id'] ?? null;
        if (!$hashed_id) {
            return;
        }


        $leaveTypeRepository = new LeaveTypeRepository($leaveTypeDao);
        $leaveTypeService = new LeaveTypeService($leaveTypeRepository);
        $result = $leaveTypeService->deleteLeaveType($hashed_id);

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


    if($action == 'update'){
        $leaveTypeData = $_POST['leave_type'] ?? null;
        if(!$leaveTypeData){
            return;
        }
        $hashed_id = $leaveTypeData['id'] ?? null;
        if (!$hashed_id) {
            return;
        }
    

        $leaveTypeRepository = new LeaveTypeRepository($leaveTypeDao);
        $leaveTypeService = new LeaveTypeService($leaveTypeRepository);
        $result = $leaveTypeService->updateLeaveType($leaveTypeData);

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
                $('#update_leave_types_modal').modal('show');
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