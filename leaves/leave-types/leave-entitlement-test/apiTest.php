<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../../LeaveEntitlement.php';
require_once __DIR__ . '/../../LeaveEntitlementDao.php';
require_once __DIR__ . '/../../../includes/Helper.php';
require_once __DIR__ . '/../../../includes/enums/ErrorCode.php';
require_once __DIR__ . '/../../../database/database.php';

try{
    $userId = 1;
    $leaveEntitlementDao = new LeaveEntitlementDao($pdo);
    $action = $_POST['action'] ?? '';

    if($action === 'fetchEmployeeLeave'){
        $employeeId = $_POST['employee_id'];
        $selectedColumns = ["leave_type_name", "number_of_entitled_days", "number_of_days_taken", "remaining_days"];
        $filterCriteria = [
            [
            "column" => "employee_id",
            "operator" => "=", 
            "value" => $employeeId
            ]
        ];
        $data = $leaveEntitlementDao->fetchAll($selectedColumns, $filterCriteria);
        $employeeLeaves = $data['result_set'];
        include __DIR__ . '/employeeLeaveTable.php';
        return;
    }

    if($action === 'assignLeaves'){
        $employeeLeavesData = $_POST['selected_leaves'] ?? null;
        if(!$employeeLeavesData){
            return;
        }
        $employeeId = $_POST['employee_id'];

        forEach($employeeLeavesData as $employeeLeaves){
            $newLeaveEntitlement = new LeaveEntitlement(
                id: null,
                employeeId: $employeeId,
                leaveTypeId: $employeeLeaves['id'],
                numberOfEntitledDays: $employeeLeaves['credits'],
                numberOfDaysTaken: 0,
                remainingDays: $employeeLeaves['credits']
            );
            $result = $leaveEntitlementDao->create($newLeaveEntitlement);

            if ($result) {
                echo "Leaves entitled successfully!";
            } else {
                echo "Failed to create LT. Please try again.";
            }
        }
        
        return;
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

