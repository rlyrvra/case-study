<?php

require_once __DIR__ . '/../EmployeeDao.php';
require_once __DIR__ . '/../EmployeeService.php';
require_once __DIR__ . '/../EmployeeRepository.php';
require_once __DIR__ . '/../Employee.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../database/database.php';

function getEmployeesForHeader($pdo, $token){
    try {
        $employeeDao = new EmployeeDao($pdo);
        $selectedColumns = ["full_name", "profile_picture", "job_title_title", "department_name"];
        $filterCriteria = [
            [
            "column" => "SHA2(employee.id, 256)", 
            "operator" => "=",
            "value" => $token
            ],
        ];
    
    
    
        $employeeRepository = new EmployeeRepository($employeeDao);
        $employeeService = new EmployeeService($employeeRepository);
        $result = $employeeService->fetchAllEmployees($selectedColumns, $filterCriteria, [], 1);
        if ($result !== ActionResult::FAILURE) {
            $employees = $result['result_set'];
        }
        return $result;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        return 0;
    }
}

$resultSet = getEmployeesForHeader($pdo, $token);
$employees;
if($resultSet["total_row_count"] <= 0){
    header("Location: ". $SMARTWAGE_LOCATION . "/manage-employee.php?e=404");
    exit;
}else{
    $employees = $resultSet['result_set'];
}

?>

<div class="profile-header col-auto">
    <?php 
    if(!isset($employees[0]['profile_picture'])){
        echo "<img src='https://via.placeholder.com/50' alt='Profile Picture' class='w-px-75 h-auto rounded-circle' />";
        return;
    }
    // Render the image
    $imageData = $employees[0]['profile_picture'];

    echo "<img src='data:image/jpg;base64,$imageData' alt='Profile Picture' class='w-px-75 h-auto rounded-circle' />";
    ?>
    <div>
        <h5 class="display-5"><?php echo $employees[0]['full_name']; ?></h5>
        <p class="mb-0"><?php echo $employees[0]['department_name']; ?></p>
        <p class="mb-0"><?php echo $employees[0]['job_title_title']; ?></p>
    </div>
</div>