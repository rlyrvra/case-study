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
        // $status = $_POST['filter_status'];
        $page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
        $limit = isset($_POST['numberEntries']) ? (int) $_POST['numberEntries'] : 10;
        $offset = ($page - 1) * $limit;

        $filterCriteria = [];

        $leaveRequestRepo = new LeaveRequestRepository($leaveRequestDao);
        $leaveRequestService = new LeaveRequestService($leaveRequestRepo);
        $result = $leaveRequestService->fetchAllLeaveRequests([], $filterCriteria);
        $employeeLeaveRequests;
        $employeeLeaveRequests = $result['result_set'];

        $totalEmployeeLeaves = $result["total_row_count"];
        $totalPages = ceil($totalEmployeeLeaves / $limit);
        include __DIR__ . '/apply-leave-employee-table.php';
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