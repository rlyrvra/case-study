<?php
require_once __DIR__ . '/../leave-types/LeaveTypeDao.php';
require_once __DIR__ . '/../leave-types/LeaveType.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../database/database.php';

function getLeaveTypes(){
    global $pdo;
    $leaveTypesDao = new LeaveTypeDao($pdo);
    $selectedColumns = ["id", "name", "maximum_number_of_days"];
    $filterCriteria = [
        [
            "column"   => "leave_type.status", 
            "operator" => "=", 
            "value"    => "Active"
        ]
    ];
    $data = $leaveTypesDao->fetchAll($selectedColumns, $filterCriteria, []);
    $leaveTypes = $data['result_set'];
    return $leaveTypes;
}
?>

<script>
var leaveTypes = getLeaveTypes();
function getLeaveTypes(){
    const values = <?php 
        $leaveTypes = getLeaveTypes();
        echo json_encode($leaveTypes); 
        ?>;
    return values;
}
</script>