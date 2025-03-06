<?php
require_once __DIR__ . '/../../../employees/Employee.php';
require_once __DIR__ . '/../../../employees/EmployeeDao.php';
require_once __DIR__ . '/../../../employees/EmployeeRepository.php';
require_once __DIR__ . '/../../../employees/EmployeeService.php';

require_once __DIR__ . '/../../../departments/DepartmentService.php';

require_once __DIR__ . '/../../../includes/Helper.php';
require_once __DIR__ . '/../../../database/database.php';
require_once __DIR__ . '/../../../includes/session.php';

function getEmployees(){
    global $pdo;
    $employeeDao = new EmployeeDao($pdo);
    $employeeRepo = new EmployeeRepository($employeeDao);
    $employeeService = new EmployeeService($employeeRepo);
    $departmentDao = new DepartmentDao($pdo);
    $departmentRepo = new DepartmentRepository($departmentDao);
    $departmentService = new DepartmentService($departmentRepo);
    $selectedColumns = ["id", "full_name", "email_address"];
    $filterCriteria = [];

    if($_SESSION['access_role'] === 'Admin'){
        //do nothing
    }

    if($_SESSION['access_role'] === 'Manager'){
        if(!$departmentService->isEmployeeDepartmentHead($_SESSION['id'])){
            return;
        }
        $departmentId = $employeeService->fetchAllEmployees(
            ['department_id'],
            [
                [
                    "column" => "employee.id",
                    "operator" => "=",
                    "value" => $_SESSION['id']
                ]
            ],
            [],
            1
        )['result_set'][0]['department_id'];
        $filterCriteria[] = [
            "column" => "employee.department_id",
            "operator" => "=",
            "value" => $departmentId
        ];
    }

    if($_SESSION['access_role'] === 'Supervisor'){
        $filterCriteria[] = [
            "column" => "employee.supervisor_id",
            "operator" => "=",
            "value" => $_SESSION['id']
        ];
    }


    $filterCriteria[] = 
    [
        "column" => "employee.deleted_at",
        "operator" => "IS NULL"
    ];
    $data = $employeeService->fetchAllEmployees($selectedColumns, $filterCriteria, []);
    $employees = $data['result_set'];
    return $employees;
}
?>

<script>
function clearEmployees(select){
    select.innerHTML = '';
}

var employees = getEmployees();
function getEmployees(){
    const values = <?php 
        $employees = getEmployees();
        echo json_encode($employees); 
        ?>;
    return values;
}

function populateSelectEmployee(select){
    clearEmployees(select);
    employees.forEach(employee => {
        const option = document.createElement("option");
        option.value = employee.id;
        option.text = employee.full_name;
        select.add(option);
    });
    select.value = "";
}

</script>