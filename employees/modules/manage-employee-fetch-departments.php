<?php
require_once __DIR__ . '/../../departments/DepartmentService.php';
require_once __DIR__ . '/../../employees/EmployeeService.php';


require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../database/database.php';

function getDepartments(){
    global $pdo;
    $departmentDao = new DepartmentDao($pdo);
    $departmentRepo = new DepartmentRepository($departmentDao);
    $departmentService = new DepartmentService($departmentRepo);
    $employeeDao = new EmployeeDao($pdo);
    $employeeRepo = new EmployeeRepository($employeeDao);
    $employeeService = new EmployeeService($employeeRepo);
    $selectedColumns = ["id", "name", "description"];
    $filterCriteria = [
        [
            "column"   => "department.status", 
            "operator" => "=", 
            "value"    => "Active"
        ]
    ];

    // if($_SESSION['access_role'] === 'Admin'){
    //     //do nothing
    // }

    // if($_SESSION['access_role'] === 'Manager'){
    //     if(!$departmentService->isEmployeeDepartmentHead($_SESSION['id'])){
    //         return;
    //     }
    //     $departmentId = $employeeService->fetchAllEmployees(
    //         ['department_id'],
    //         [
    //             [
    //                 "column" => "employee.id",
    //                 "operator" => "=",
    //                 "value" => $_SESSION['id']
    //             ]
    //         ],
    //         [],
    //         1
    //     )['result_set'][0]['department_id'];
    //     $filterCriteria[] = [
    //         "column" => "department.id",
    //         "operator" => "=",
    //         "value" => $departmentId
    //     ];
    // }

    // if($_SESSION['access_role'] === 'Supervisor'){
    //     $filterCriteria[] = [
    //         "column" => "employee.supervisor_id",
    //         "operator" => "=",
    //         "value" => $_SESSION['id']
    //     ];
    // }
    
    $data = $departmentService->fetchAllDepartments($selectedColumns, $filterCriteria, []);
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