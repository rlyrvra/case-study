<?php 
require_once __DIR__ . '/../../database/database.php'; 
require_once __DIR__ . '/../../employees/EmployeeDao.php'; 
require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../includes/enums/ErrorCode.php';
?>

<?php
function getSupervisors(){
    global $pdo;
    $employeeDao = new EmployeeDao($pdo);

    $selectedColumns = ["id", "full_name", "email_address"];
    $filterCriteria = [
        [
            "column" => "employee.access_role",
            "operator" => "=",
            "value" => "Supervisor"
        ],
    ];

    $data = $employeeDao->fetchAll($selectedColumns, $filterCriteria);
    $supervisors = $data['result_set'];
    return $supervisors;
}

?>


<script>
var supervisors = getSupervisors();

function clearSupervisors(select){
    select.innerHTML = '';
}

function getSupervisors(){
    const values = <?php 
        $supervisors = getSupervisors();
        echo json_encode($supervisors); 
        ?>;
    return values;
}

function populateSupervisorsSelect(select){
    clearSupervisors(select);
    const optionNone = document.createElement("option");
    optionNone.value = "None";
    optionNone.text = "None";
    select.add(optionNone);
    supervisors.forEach(supervisor => {
        const option = document.createElement("option");
        option.value = supervisor.id;
        option.text = supervisor.full_name;
        select.add(option);
    });
}

function selectSupervisor(id, select){
    for (let i = 0; i < select.options.length; i++) {
        if (select.options[i].value === id) {
            select.selectedIndex = i;
            break;
        }
    }
}
</script>