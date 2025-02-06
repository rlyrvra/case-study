<?php 
require_once __DIR__ . '/../../database/database.php'; 
require_once __DIR__ . '/../../employees/EmployeeDao.php'; 
require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../includes/enums/ErrorCode.php';
?>

<?php
function getEmployees(){
    global $pdo;
    $employeeDao = new EmployeeDao($pdo);

    $selectedColumns = ["id", "full_name", "email_address"];
    $filterCriteria = [
        [
            "column" => "employee.deleted_at",
            "operator" => "IS NULL",
        ],
    ];

    $data = $employeeDao->fetchAll($selectedColumns, $filterCriteria);
    $employees = $data['result_set'];
    return $employees;
}

?>


<script>
var employees = getEmployees();

function clearSupervisors(select){
    select.innerHTML = '';
}

function getEmployees(){
    const values = <?php 
        $employees = getEmployees();
        echo json_encode($employees); 
        ?>;
    return values;
}

function populateEmployeeSelect(select){
    clearSupervisors(select);
    const optionNone = document.createElement("option");
    optionNone.value = "";
    optionNone.text = "Select an employee...";
    optionNone.selected = true;
    select.add(optionNone);
    employees.forEach(employee => {
        const option = document.createElement("option");
        option.value = employee.id;
        option.text = employee.full_name;
        select.add(option);
    });
}

function selectEmployee(id, select){
    for (let i = 0; i < select.options.length; i++) {
        if (select.options[i].value === id) {
            select.selectedIndex = i;
            break;
        }
    }
}
</script>