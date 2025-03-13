<?php

require_once __DIR__ . '/../../LeaveRequest.php';
require_once __DIR__ . '/../../LeaveRequestDao.php';
require_once __DIR__ . '/../../LeaveRequestRepository.php';
require_once __DIR__ . '/../../LeaveRequestService.php';

require_once __DIR__ . '/../../LeaveEntitlement.php';
require_once __DIR__ . '/../../LeaveEntitlementDao.php';
require_once __DIR__ . '/../../LeaveEntitlementRepository.php';
require_once __DIR__ . '/../../LeaveEntitlementService.php';

require_once __DIR__ . '/../../LeaveRequestAttachment.php';
require_once __DIR__ . '/../../LeaveRequestAttachmentDao.php';
require_once __DIR__ . '/../../LeaveRequestAttachmentRepository.php';

require_once __DIR__ . '/../../../departments/DepartmentService.php';
require_once __DIR__ . '/../../../employees/EmployeeService.php';


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
    $leaveEntitlementDao = new LeaveEntitlementDao($pdo);
    $departmentDao = new DepartmentDao($pdo);
    $departmentRepo = new DepartmentRepository($departmentDao);
    $departmentService = new DepartmentService($departmentRepo);
    $employeeDao = new EmployeeDao($pdo);
    $employeeRepo = new EmployeeRepository($employeeDao);
    $employeeService = new EmployeeService($employeeRepo);

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
                "column" => "leave_request.status",
                "operator" => "=",
                "value" => $status
            ];
        }

        // if($_SESSION['access_role'] === 'Admin'){
        //     //do nothing
        // }
    
        // if($_SESSION['access_role'] === 'Manager'){
        //     if(!$departmentService->isEmployeeDepartmentHead($_SESSION['id'])){
        //         return;
        //     }
        //     $departmentId = $employeeService->fetchAllEmployees(
        //         ['department_id'],
        //         [
        //             [
        //                 "column" => "employee.id",
        //                 "operator" => "=",
        //                 "value" => $_SESSION['id']
        //             ]
        //         ],
        //         [],
        //         1
        //     )['result_set'][0]['department_id'];
        //     $filterCriteria[] = [
        //         "column" => "employee.department_id",
        //         "operator" => "=",
        //         "value" => $departmentId
        //     ];
        // }
    
        // if($_SESSION['access_role'] === 'Supervisor'){
        //     $filterCriteria[] = [
        //         "column" => "employee.supervisor_id",
        //         "operator" => "=",
        //         "value" => $_SESSION['id']
        //     ];
        // }

        if(empty($searchAt) && !empty($searchFilter)){
            $filterCriteria[] = [
                "column" => "employee.full_name", 
                "operator" => "LIKE",
                "value" => "%$searchFilter%", 
                'boolean' => 'OR'

            ];
            $filterCriteria[] = [
                "column" => "employee.email_address", 
                "operator" => "LIKE",
                "value" => "%$searchFilter%", 
                'boolean' => 'OR'
            ];
        }

        if(!empty($searchFilter) && !empty($searchAt)){
            $filterCriteria[] = [
                "column" => "employee." . $searchAt, 
                "operator" => "LIKE",
                "value" => "%$searchFilter%"
            ];
        }

        if((!empty($dateFilterColumn) && $dateFilterColumn !== "none") && !empty($dateStart) && !empty($dateEnd)){
            $filterCriteria[] = [
                "column" => "leave_request." . $dateFilterColumn,
                "operator" => "BETWEEN",
                "lower_bound" => $dateStart,
                "upper_bound" => $dateEnd
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
        $leaveRequests;
        $leaveRequests = $result['result_set'];

        $totalEmployeeLeaves = $result["total_row_count"];
        $totalPages = ceil($totalEmployeeLeaves / $limit);
        include __DIR__ . '/leave-requests-table.php';
        return;
    }

    if($action === 'review'){
        $leaveRequestId = $_POST['md5_id'] ?? null;
        $status = $_POST['status'] ?? null;
        $leaveRequestRepo = new LeaveRequestRepository($leaveRequestDao);
        $leaveRequestAttachmentRepo = new LeaveRequestAttachmentRepository($leaveRequestAttachmentDao);
        $leaveRequestService = new LeaveRequestService($leaveRequestRepo, $leaveRequestAttachmentRepo);
        $leaveEntitlementRepo = new LeaveEntitlementRepository($leaveEntitlementDao);
        $leaveEntitlementService = new LeaveEntitlementService($leaveEntitlementRepo);
        $fetchLeaveRequest = $leaveRequestService->fetchAllLeaveRequests(
            ['employee_id', 'leave_type_id', 'start_date', 'end_date'],
            [
                [
                "column" => "id",
                "operator" => "=",
                "value" => $leaveRequestId
                ],
            ], [], 1
        );

        $matchingLeaveRequest = $fetchLeaveRequest['result_set'];

        $startDate = new DateTime($matchingLeaveRequest[0]['start_date']);
        $endDate = new DateTime($matchingLeaveRequest[0]['end_date']);
        $interval = $startDate->diff($endDate);

        $daysTaken = $interval->days;
        $employeeId = $matchingLeaveRequest[0]['employee_id'];
        $leaveTypeId = $matchingLeaveRequest[0]['leave_type_id'];

        $fetchLeaveEntitlements = $leaveEntitlementService->getAllLeaveEntitlements(
            [],
            [
                [
                    "column" => "leave_entitlement.employee_id",
                    "operator" => "=",
                    "value" => $employeeId
                ],
                [
                    "column" => "leave_entitlement.leave_type_id",
                    "operator" => "=",
                    "value" => $leaveTypeId
                ],
                [
                    'column' => 'leave_entitlement.deleted_at',
                    'operator' => 'IS NULL'
                ],
            ], [], 1
        );

        $matchingLeaveEntitlement = $fetchLeaveEntitlements['result_set'];

        $numberOfEntitledDays = $matchingLeaveEntitlement[0]['number_of_entitled_days'];
        $remainingDays = $matchingLeaveEntitlement[0]['remaining_days'] - $daysTaken;

        // echo "
        //     employeeId: $employeeId,
        //     leaveTypeId: $leaveTypeId,
        //     Days Taken: $daysTaken,
        //     entitledDays: $numberOfEntitledDays,
        //     remainingDays: $remainingDays
        // ";

        if($status === 'Approved'){
            $updateResult = $leaveRequestService->updateLeaveRequestStatus($leaveRequestId, $status);


            $updatedLeaveEntitlement = new LeaveEntitlement(
                id: null,
                employeeId: (int) $employeeId,
                leaveTypeId: (int) $leaveTypeId,
                numberOfEntitledDays: $numberOfEntitledDays,
                numberOfDaysTaken: $daysTaken,
                remainingDays: $remainingDays
            );
            

            
            $updateBalance = $leaveEntitlementService->updateLeaveEntitlementBalance($updatedLeaveEntitlement);
            
            if($updateBalance === ActionResult::SUCCESS){
                echo "
                <script>
                    showReviewSuccess();
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


        $updateResult = $leaveRequestService->updateLeaveRequestStatus($leaveRequestId, $status);

        if($updateResult === ActionResult::SUCCESS){
            echo "
            <script>
                showReviewSuccess();
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
        error
        missingFieldValues('{$escapedFieldName}');
        <script>
            
        </script>
        ");
    }
    
    // Additional validation can go here (e.g., regex for specific formats)
    
    return htmlspecialchars($input); // Sanitize to prevent XSS
}