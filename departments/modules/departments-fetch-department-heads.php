<?php 
require_once __DIR__ . '/../../database/database.php'; 
require_once __DIR__ . '/../../employees/EmployeeDao.php'; 
require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../includes/enums/ErrorCode.php';
?>

<?php
function getDepartmentHeads(){
    global $pdo;
    $employeeDao = new EmployeeDao($pdo);

    $selectedColumns = ["id", "full_name"];
    $filterCriteria = [
        [
            "column" => "employee.access_role",
            "operator" => "=",
            "value" => "Manager"
        ],
    ];

    $data = $employeeDao->fetchAll($selectedColumns, $filterCriteria);
    $departmentHeads = $data['result_set'];
    return $departmentHeads;
}

?>


<script>
var departmentHeads = getDepartmentHeads();

function clearDepartmentHeads(select){
    select.innerHTML = '';
}

function getDepartmentHeads(){
    const values = <?php 
        $departmentHeads = getDepartmentHeads();
        echo json_encode($departmentHeads); 
        ?>;
    return values;
}

function populateDepartmentHeadsSelect(select){
    clearDepartmentHeads(select);
    const optionNone = document.createElement("option");
    optionNone.value = "";
    optionNone.text = "Select a department head";
    optionNone.disabled = true;
    optionNone.selected = true;
    select.add(optionNone);
    departmentHeads.forEach(departmentHead => {
        const option = document.createElement("option");
        option.value = departmentHead.id;
        option.text = departmentHead.full_name;
        select.add(option);
    });
}

function selectDepartmentHeads(id, select){
    for (let i = 0; i < select.options.length; i++) {
        if (select.options[i].value === id) {
            select.selectedIndex = i;
            break;
        }
    }
}
</script>