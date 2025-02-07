<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../leave-types/LeaveType.php';
require_once __DIR__ . '/../leave-types/LeaveTypeRepository.php';
require_once __DIR__ . '/../leave-types/LeaveTypeService.php';
require_once __DIR__ . '/../leave-types/LeaveTypeDao.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../includes/enums/ErrorCode.php';
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
        include __DIR__ . '/leave-types-table.php';
        return;

    }

    if ($action === 'create') {
        $leaveTypesData = $_POST['leave_type'] ?? null;

        if (!$leaveTypesData) {
            return;
        } 
        $name = isset($leaveTypesData['name']) ? validateInput($leaveTypesData['name'], 'Name') : '';
        $maximumNumberOfDays = isset($leaveTypesData['maximum_number_of_days']) ? validateNumericIdentifier($leaveTypesData['maximum_number_of_days'], 1, 30, 'Maximum Number of Days') : null;
        $isPaid = isset($leaveTypesData['is_paid']) ? validateInput($leaveTypesData['is_paid'], 'Is Paid') : null;
        $description = isset($leaveTypesData['description']) ? validateInput($leaveTypesData['description'], 'Description') : '';
        $status = isset($leaveTypesData['status']) ? validateInput($leaveTypesData['status'], 'Status') : '';

        $newLeaveType = new LeaveType(
            id: null,
            name: $name,
            maximumNumberOfDays: $maximumNumberOfDays,
            isPaid: $isPaid,
            description: $description,
            status: $status
        );


        $leaveTypeRepository = new LeaveTypeRepository($leaveTypeDao);
        $leaveTypeService = new LeaveTypeService($leaveTypeRepository);
        $result = $leaveTypeService->createLeaveType($newLeaveType);

        if ($result === ActionResult::SUCCESS) {
            echo "
            <script> 
                showSuccessCreate(); 
            </script>";
        } else if ($result === ActionResult::DUPLICATE_ENTRY_ERROR) {
            echo "
            <script> 
                showDuplicateError(); 
            </script>";
        } else {
            echo "
            <script> 
                showError(); 
            </script>";
        }
        return;
    }
    
    if($action == 'delete'){
        $hashed_id = isset($_POST['md5_id']) ? (int) validateNumericIdentifier($_POST['md5_id'], 1, 30) : null;
        $leaveTypeRepository = new LeaveTypeRepository($leaveTypeDao);
        $leaveTypeService = new LeaveTypeService($leaveTypeRepository);
        $deleteresult = $leaveTypeService->deleteLeaveType($hashed_id);

        if ($deleteresult === ActionResult::SUCCESS) {
            echo "
            <script> 
                showSuccessDelete(); 
            </script>";
        } else {
            echo "
            <script> 
                showError(); 
            </script>";
        }
        return;
    }


    if($action == 'update'){
        $leaveTypeData = $_POST['leave_type'] ?? null;

        if(!$leaveTypeData){
            return;
        }

        //print_r($leaveTypeData);


        $hashed_id = isset($_POST['md5_id']) ? (int) validateNumericIdentifier($_POST['md5_id'], 1, 30) : null;
        echo $hashed_id;
        $name = $leaveTypeData['name'] ?? '';
        $maxNumberOfDays = $leaveTypeData['maxNumberOfDays'] ?? null;
        $isPaid = $leaveTypeData['isPaid'] ?? null;
        $description = $leaveTypeData['description'] ?? null;
        $status = $leaveTypeData['status'] ?? null;

        $updatedLeaveType = new LeaveType(
            id: $hashed_id,
            name: $name,
            maximumNumberOfDays: $maxNumberOfDays,
            isPaid: $isPaid,
            description: $description,
            status: $status
        );

        $leaveTypeRepository = new LeaveTypeRepository($leaveTypeDao);
        $leaveTypeService = new LeaveTypeService($leaveTypeRepository);
        $updateResult = $leaveTypeService->updateLeaveType($updatedLeaveType);

        if ($updateResult === ActionResult::SUCCESS) {
            echo "
            <script> 
                showSuccessUpdate(); 
            </script>";
        } else if ($updateResult === ActionResult::DUPLICATE_ENTRY_ERROR) {
            echo "
            <script> 
                showDuplicateError(); 
            </script>";
        }else {
            echo "
            <script> 
                showError(); 
            </script>";
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