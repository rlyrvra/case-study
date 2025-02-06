<?php
require_once __DIR__ . '/../../../employees/Employee.php';
require_once __DIR__ . '/../../../employees/EmployeeDao.php';
require_once __DIR__ . '/../../../includes/Helper.php';
require_once __DIR__ . '/../../../includes/enums/ErrorCode.php';
require_once __DIR__ . '/../../../database/database.php';

function getEmployees(){
    global $pdo;
    $employeeDao = new EmployeeDao($pdo);
    $selectedColumns = ["id", "first_name", "middle_name", "last_name"];
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
    console.log(values);
    return values;
}

function populateSelectEmployee(select){
    employees.forEach(employee => {
        const option = document.createElement("option");
        option.value = employee.id;
        option.text = `${employee.first_name} ${employee.middle_name} ${employee.last_name}`;
        select.add(option);
    });
    console.log("Data added to" + select);
}

</script>