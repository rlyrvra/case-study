<?php
require_once __DIR__ . '/../../employees/Employee.php';
require_once __DIR__ . '/../../employees/EmployeeDao.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../database/database.php';

function getEmployees(){
    global $pdo;
    $employeeDao = new EmployeeDao($pdo);
    $selectedColumns = ["id", "full_name", "email_address"];
    $filterCriteria = [];
    $data = $employeeDao->fetchAll($selectedColumns, $filterCriteria, []);
    $employees = $data['result_set'];
    return $employees;
}
?>

<script>
var employees = getEmployees();
function getEmployees(){
    const values = <?php 
        $employees = getEmployees();
        echo json_encode($employees); 
        ?>;
    return values;
}

function populateSelectEmployee(select){
    employees.forEach(employee => {
        const option = document.createElement("option");
        option.value = employee.id;
        option.text = employee.full_name;
        select.add(option);
    });
}

</script>