<?php

require_once __DIR__ . '/../../LeaveRequest.php';
require_once __DIR__ . '/../../LeaveRequestDao.php';
require_once __DIR__ . '/../../LeaveRequestRepository.php';
require_once __DIR__ . '/../../LeaveRequestService.php';
require_once __DIR__ . '/../../../includes/Helper.php';
require_once __DIR__ . '/../../../includes/enums/ErrorCode.php';
require_once __DIR__ . '/../../../includes/enums/ActionResult.php';
require_once __DIR__ . '/../../../database/database.php';
require_once __DIR__ . '/../../../includes/session.php';

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}



try {
    $leaveRequestDao = new LeaveRequestDao($pdo);
    $action = $_POST['action'] ?? '';

    if($action == 'fetchAll'){
        $employeeId = $_SESSION['id'];
        // $status = $_POST['filter_status'];
        // $page = isset($_POST['page']) ? (int)$_POST['page'] : 1;
        // $limit = isset($_POST['numberEntries']) ? $_POST['numberEntries'] : 5;
        // $offset = ($page - 1) * $limit;

        $filterCriteria = [];

        $filterCriteria[] = [
            "column" => "leave_request.employee_id",
            "operator" => "=",
            "value" => $employeeId
        ];

        $leaveRequestRepo = new LeaveRequestRepository($leaveRequestDao);
        $leaveRequestService = new LeaveRequestService($leaveRequestRepo);
        $result = $leaveRequestService->fetchAllLeaveRequests([], $filterCriteria);
        $employeeLeaveRequests;
        $employeeLeaveRequests = $result['result_set'];

        $totalEmployeeLeaves = $result["total_row_count"];
        //$totalPages = ceil($totalEmployeeLeaves / $_POST['numberEntries']);
        include __DIR__ . '/apply-leave-employee-table.php';
        return;
    }   

    if($action === 'create'){
        $leaveRequestData = $_POST['leave_request'] ?? null;
        if ($leaveRequestData == null) {
            return;
        }
        $employeeId = $_SESSION['id'];
        $leave_type_id = isset($leaveRequestData['leave_type_id']) ? (int) validateInput($leaveRequestData['leave_type_id'], 'Leave Type') : '';
        $start_date = isset($leaveRequestData['start_date']) ?  validateInput($leaveRequestData['start_date'], 'Start Date') : '';
        $end_date = isset($leaveRequestData['end_date']) ? validateInput($leaveRequestData['end_date'], 'End Date') : '';
        $reason = isset($leaveRequestData['reason']) ? validateInput($leaveRequestData['reason'], 'Reason') : '';
        $status = "Pending";
        $newLeaveRequest = new LeaveRequest(
            id: null,
            employeeId: $employeeId,
            leaveTypeId: $leave_type_id,
            startDate: $start_date,
            endDate: $end_date,
            reason: $reason,
            status: $status
        );
        $leaveRequestRepo = new LeaveRequestRepository($leaveRequestDao);
        $leaveRequestService = new LeaveRequestService($leaveRequestRepo);
        $createResult = $leaveRequestService->createLeaveRequest($newLeaveRequest);
        if($createResult === ActionResult::SUCCESS){
            echo "
            <script>
                showSuccessRequest();
            </script>
            ";
        }else{
            echo "
            <script>
                showError();
            </script>
            ";
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