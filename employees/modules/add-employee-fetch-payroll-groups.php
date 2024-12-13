<?php
require_once __DIR__ . '/../../payroll/PayrollGroupDao.php';
require_once __DIR__ . '/../../payroll/PayrollGroup.php';
require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../includes/enums/ErrorCode.php';
require_once __DIR__ . '/../../database/database.php';

function getPayrollGroups(){
    global $pdo;
    $payrollGroupDao = new PayrollGroupDao($pdo);
    $selectedColumns = ["id", "name"];
    $filterCriteria = [
        [
            "column"   => "payroll_group.status", 
            "operator" => "=", 
            "value"    => "Active"
        ]
    ];
    $data = $payrollGroupDao->fetchAll($selectedColumns, $filterCriteria, []);
    $payrollGroups = $data['result_set'];
    return $payrollGroups;
}

?>

<script>
var payroll_groups = getPayrollGroupsValues();

function clearPayrollGroupSelect(select){
    select.innerHTML = '';
}

function getPayrollGroupsValues(){
    const values = <?php 
        $payroll_groups = getPayrollGroups();
        echo json_encode($payroll_groups); 
        ?>;
    return values;
}

function populatePayrollGroupsSelect(select){
    clearPayrollGroupSelect(select);
    payroll_groups.forEach(payroll_group => {
        const option = document.createElement("option");
        option.value = payroll_group.id;
        option.text = payroll_group.name;
        select.add(option);
    });
}

function selectPayrollGroups(id, select){
    for (let i = 0; i < select.options.length; i++) {
        if (select.options[i].value === id) {
            select.selectedIndex = i;
            break;
        }
    }
}
</script>