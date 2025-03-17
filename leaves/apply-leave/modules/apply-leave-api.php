<?php

require_once __DIR__ . '/../../LeaveRequest.php';
require_once __DIR__ . '/../../LeaveRequestDao.php';
require_once __DIR__ . '/../../LeaveRequestRepository.php';
require_once __DIR__ . '/../../LeaveRequestService.php';

require_once __DIR__ . '/../../LeaveRequestAttachment.php';
require_once __DIR__ . '/../../LeaveRequestAttachmentDao.php';
require_once __DIR__ . '/../../LeaveRequestAttachmentRepository.php';

require_once __DIR__ . '/../../../includes/Helper.php';
require_once __DIR__ . '/../../../includes/enums/ActionResult.php';
require_once __DIR__ . '/../../../database/database.php';
require_once __DIR__ . '/../../../includes/session.php';

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}



try {
    $leaveRequestDao = new LeaveRequestDao($pdo);
    $leaveRequestAttachmentDao = new LeaveRequestAttachmentDao($pdo);
    $action = $_POST['action'] ?? '';

    if($action == 'fetchAll'){
        $employeeId = $_SESSION['id'];
        $status = isset($_POST['filter_status']) && $_POST['filter_status'] ? $_POST['filter_status'] : null;
        $page = isset($_POST['page']) ? (int) $_POST['page'] : 1;
        $limit = isset($_POST['numberEntries']) ? (int) $_POST['numberEntries'] : 10;
        $offset = ($page - 1) * $limit;

        $filterCriteria = [];

        $filterCriteria[] = [
            "column" => "leave_request.employee_id",
            "operator" => "=",
            "value" => $employeeId
        ];

        $filterCriteria[] = [
            "column" => "leave_request.deleted_at",
            "operator" => "IS NULL"
        ];

        if(!empty($status)){
            $filterCriteria[] = [
                "column" => "leave_request.status",
                "operator" => "=",
                "value" => $status
            ];
        }

        $sortCriteria = [
            [
                "column" => "leave_request." . $_POST['sort_by'],
                "direction" => $_POST['sort_order']
            ]
        ];

        $leaveRequestRepo = new LeaveRequestRepository($leaveRequestDao);
        $leaveRequestAttachmentRepo = new LeaveRequestAttachmentRepository($leaveRequestAttachmentDao);
        $leaveRequestService = new LeaveRequestService($leaveRequestRepo, $leaveRequestAttachmentRepo);
        $result = $leaveRequestService->fetchAllLeaveRequests([], $filterCriteria, $sortCriteria, $limit, $offset);
        $employeeLeaveRequests;
        $employeeLeaveRequests = $result['result_set'];

        $totalEmployeeLeaves = $result["total_row_count"];
        $totalPages = ceil($totalEmployeeLeaves / $limit);
        include __DIR__ . '/apply-leave-employee-table.php';
        return;
    }   

    if($action === 'create'){
        $employeeId = $_SESSION['id'];
        $leave_type_id = isset($_POST['leave_type_id']) ? (int) validateInput($_POST['leave_type_id'], 'Leave Type') : '';
        $start_date = isset($_POST['start_date']) ?  validateInput($_POST['start_date'], 'Start Date') : '';
        $end_date = isset($_POST['end_date']) ? validateInput($_POST['end_date'], 'End Date') : '';
        $isHalfDay = isset($_POST['is_half_day']) && $_POST['is_half_day'] === 'true' ? true : false;
        $halfDayPart = '';
        if($isHalfDay){
            $halfDayPart = isset($_POST['half_day_part']) ? validateInput($_POST['half_day_part'], 'Half Day Part') : null;
        }
        $reason = isset($_POST['reason']) ? validateInput($_POST['reason'], 'Reason') : '';
        $status = "Pending";
        $newLeaveRequest = new LeaveRequest(
            id: null,
            employeeId: $employeeId,
            leaveTypeId: $leave_type_id,
            startDate: $start_date,
            endDate: $end_date,
            reason: $reason,
            isHalfDay: $isHalfDay,
            halfDayPart: $halfDayPart,
            status: $status
        );


        $leaveRequestRepo = new LeaveRequestRepository($leaveRequestDao);
        $leaveRequestAttachmentRepo = new LeaveRequestAttachmentRepository($leaveRequestAttachmentDao);
        $leaveRequestService = new LeaveRequestService($leaveRequestRepo, $leaveRequestAttachmentRepo);

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

        $fetchLastCreated = new LeaveRequestService($leaveRequestRepo, $leaveRequestAttachmentRepo);
        // $lastCreatedLeaveRequest = $fetchLastCreated->fetchAllLeaveRequests(
        //     ["id"], [
        //     [
        //         "column" => "leave_request.employee_id",
        //         "operator" => "=",
        //         "value" => $employeeId
        //     ],
        //     [
        //         "column" => "leave_request.deleted_at",
        //         "operator" => "IS NOT NULL"
        //     ]
        // ], [
        //     [
        //         "column" => "leave_request.created_at",
        //         "direction" => "DESC"
        //     ]
        // ], 1, 0

        // );
        // print_r($lastCreatedLeaveRequest);

        $leaveRequestId = getLastInsertIdBySql($pdo, $employeeId);

        // Save file attachments
        $attachments = [];
        // Directory to save uploaded files
        $uploadDir = realpath(__DIR__ . '/../../../uploads') . DIRECTORY_SEPARATOR; 
        //echo $uploadDir;

        // Ensure the upload directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create directory with proper permissions
        }

        if (isset($_FILES['attachments'])) {
            $success = true;
            $message = '';
            foreach ($_FILES['attachments']['tmp_name'] as $key => $tmpName) {
                $originalFileName = basename($_FILES['attachments']['name'][$key]);
                $uniqueFileName = uniqid() . '-' . $originalFileName; // Generate a unique name
                $filePath = $uploadDir . $uniqueFileName;
                $relativeUploadDir = '/uploads/'; // Relative path from the main directory
                // Validate file size (e.g., max 2MB) and type (e.g., only images or PDFs)
                $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
                $maxFileSize = 2 * 1024 * 1024; // 2MB

                if ($_FILES['attachments']['size'][$key] > $maxFileSize) {
                    $success = false;
                    $message .= "File size exceeds limit: $originalFileName";
                    continue;
                }

                if (!in_array($_FILES['attachments']['type'][$key], $allowedTypes)) {
                    $success = false;
                    error_log("Invalid file type: $originalFileName");
                    $message .= "Invalid file type: $originalFileName";
                    continue;
                }

                // Save the file
                if (move_uploaded_file($tmpName, $filePath)) {
                    $attachments[] = $filePath;

                    $createLeaveRequestAttachment = new LeaveRequestAttachment(
                        id: null,
                        leaveRequestId: $leaveRequestId, 
                        filePath: $filePath
                    );

                    $attachmentResult = $leaveRequestService->createLeaveRequestAttachment($createLeaveRequestAttachment);

                    if ($attachmentResult !== ActionResult::SUCCESS) {
                        $success = false;
                        error_log("Failed to save attachment to database: $filePath");
                        $message .= "Failed to save attachment to database: $filePath";
                    }
                } else {
                    $success = false;
                    error_log("Failed to move uploaded file: $originalFileName");
                    $message .= "Failed to move uploaded file: $originalFileName";
                }
            }

            // Finalize response based on success
            if ($success) {
                die(`<div class="my-5 alert alert-success text-center">All files have been successfully uploaded.</div>`);
            } else {
                die(`<div class="my-5 alert alert-danger text-center">$message</div>`);
            }
        }
        return;
    }

    if($action === 'delete'){
        $hashed_id = $_POST['md5_id'] ?? null;
        $leaveRequestRepo = new LeaveRequestRepository($leaveRequestDao);
        $leaveRequestAttachmentRepo = new LeaveRequestAttachmentRepository($leaveRequestAttachmentDao);
        $leaveRequestService = new LeaveRequestService($leaveRequestRepo, $leaveRequestAttachmentRepo);
        $deleteResult = $leaveRequestService->deleteLeaveRequest($hashed_id);
        $deleteAttachmentsResult = $leaveRequestService->deleteLeaveRequestAttachment($hashed_id);
        if($deleteResult === ActionResult::SUCCESS){
            echo "
            <script>
                showSuccessDeleteRequest();
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
    

    if($action === 'cancel'){
        $hashed_id = $_POST['md5_id'] ?? null;
        $leaveRequestRepo = new LeaveRequestRepository($leaveRequestDao);
        $leaveRequestAttachmentRepo = new LeaveRequestAttachmentRepository($leaveRequestAttachmentDao);
        $leaveRequestService = new LeaveRequestService($leaveRequestRepo, $leaveRequestAttachmentRepo);
        $deleteResult = $leaveRequestService->updateLeaveRequestStatus($hashed_id, "Canceled");
        if($deleteResult === ActionResult::SUCCESS){
            echo "
            <script>
                showSuccessDeleteRequest();
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

function getLastInsertIdBySql($pdo, $employeeId): int {
    try {
        $stmt = $pdo->query("SELECT id FROM leave_requests WHERE employee_id = $employeeId ORDER BY id DESC LIMIT 1");
        $lastLeaveRequestId = $stmt->fetchColumn();
        return $lastLeaveRequestId !== false ? (int) $lastLeaveRequestId : 0;
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return 0; // Return 0 as a fallback
    }
}