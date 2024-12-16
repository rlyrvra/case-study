<?php
require_once __DIR__ . '/../../LeaveEntitlement.php';
require_once __DIR__ . '/../../LeaveEntitlementDao.php';
require_once __DIR__ . '/../../LeaveEntitlementRepository.php';
require_once __DIR__ . '/../../LeaveEntitlementService.php';
require_once __DIR__ . '/../../../includes/Helper.php';
require_once __DIR__ . '/../../../includes/enums/ErrorCode.php';
require_once __DIR__ . '/../../../includes/session.php';
require_once __DIR__ . '/../../../database/database.php';

function getEmployeeLeaveTypes(){
    global $pdo;
    $employeeId = $_SESSION['id'];
    $employeeLeavesDao = new LeaveEntitlementDao($pdo);
    $employeeLeavesRepo = new LeaveEntitlementRepository($employeeLeavesDao);
    $employeeLeavesService = new LeaveEntitlementService($employeeLeavesRepo);
    $selectedColumns = ["id", "leave_type_id", "leave_type_name", "remaining_days"];
    $filterCriteria = [
        [
            "column"   => "leave_entitlement.employee_id", 
            "operator" => "=", 
            "value"    => $employeeId
        ],
        [
            "column"   => "leave_entitlement.deleted_at", 
            "operator" => "IS NULL", 
        ]
    ];
    $data = $employeeLeavesService->getAllLeaveEntitlements($selectedColumns, $filterCriteria, []);
    $employeeLeaveTypes = $data['result_set'];
    return $employeeLeaveTypes;
}
?>

<script>
var employeeLeaves = getEmployeeLeaves();

function clearEmployeeLeaves(select){
    select.innerHTML = '';
}

function getEmployeeLeaves(){
    const values = <?php 
        $employeeLeaves = getEmployeeLeaveTypes();
        echo json_encode($employeeLeaves); 
        ?>;
    return values;
}

function populateEmployeeLeaveTypesSelect(select){
    clearEmployeeLeaves(select);
    const optionNone = document.createElement("option");
    optionNone.value = "";
    optionNone.text = "None";
    optionNone.selected = true;
    optionNone.disabled = true;
    select.add(optionNone);
    employeeLeaves.forEach(employeeLeave => {
        const option = document.createElement("option");
        option.value = employeeLeave.id;
        option.text = employeeLeave.leave_type_name;
        select.add(option);
    });
}

function selectEmployeeLeaves(){
    const selectedToken = parseInt(document.getElementById("leaveType").value, 10);
    const matchingLeave = employeeLeaves.find(employeeLeave => selectedToken === employeeLeave.id);
    if(!matchingLeave){
        console.log("WARNING! No Selected Leave");
        return;
    }
    document.getElementById("remainingBalance").value = matchingLeave.remaining_days;

}
</script>