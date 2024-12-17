<?php
require_once __DIR__ . '/../../departments/DepartmentDao.php';
require_once __DIR__ . '/../../departments/Department.php';
require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../includes/enums/ErrorCode.php';
require_once __DIR__ . '/../../database/database.php';

function getDepartments(){
    global $pdo;
    $departmentDao = new DepartmentDao($pdo);
    $selectedColumns = ["id", "name", "description"];
    $filterCriteria = [
        [
            "column"   => "department.status", 
            "operator" => "=", 
            "value"    => "Active"
        ]
    ];
    $data = $departmentDao->fetchAll($selectedColumns, $filterCriteria, []);
    $departments = $data['result_set'];
    return $departments;
}

?>

<script>
var departments = getDepartmentValues();

function clearDepartmentSelect(select){
    select.innerHTML = '';
}

function getDepartmentValues(){
    const values = <?php 
        $departments = getDepartments();
        echo json_encode($departments); 
        ?>;
    return values;
}

function populateDepartmentSelect(select){
    clearDepartmentSelect(select);
    const optionNone = document.createElement("option");
    optionNone.value = "";
    optionNone.text = "Select a department";
    optionNone.disabled = true;
    optionNone.selected = true;
    select.add(optionNone);
    departments.forEach(department => {
        const option = document.createElement("option");
        option.value = department.id;
        option.text = department.name;
        select.add(option);
    });
}

function selectDepartmentJobTitle(id, select){
    for (let i = 0; i < select.options.length; i++) {
        if (select.options[i].value === id) {
            select.selectedIndex = i;
            break;
        }
    }
}
</script>