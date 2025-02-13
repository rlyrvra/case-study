<?php 
require_once __DIR__ . '/employees/EmployeeDao.php';
require_once __DIR__ . '/employees/EmployeeRepository.php';
require_once __DIR__ . '/employees/EmployeeService.php';

require_once __DIR__ . '/database/database.php';
require_once __DIR__ . '/includes/file-locations.php';
require_once __DIR__ . '/includes/session.php';

?>


<?php
// Check if the remember me cookie exists
if (isset($_COOKIE['remember_me'])) {
    
    list($selector, $token) = explode(':', $_COOKIE['remember_me']);
    
    // Retrieve the corresponding hashed token from the database
    $sql = "SELECT user_id, hashed_token, expires_at FROM remember_me_tokens WHERE selector = ? AND expires_at > NOW()";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$selector]);

    $token_data = $stmt->fetch();

    if ($token_data) {
        // Validate the token
        if (hash('sha256', $token) === $token_data['hashed_token']) {
            // Token is valid, log the user in
            $_SESSION['id'] = $token_data['user_id'];
            // Fetch user data if needed (e.g., role) and set in session
            $selectedColumns = ['id', "full_name", "access_role", "profile_picture"];
            $filterCriteria = [
                [
                    "column" => "employee.id",
                    "operator" => "=",
                    "value" => $token_data['user_id']
                ]
            ];
            $employeeDao = new EmployeeDao($pdo);
            $employeeRepo = new EmployeeRepository($employeeDao);
            $employeeService = new EmployeeService($employeeRepo);
            $result = $employeeService->fetchAllEmployees($selectedColumns, $filterCriteria, [], 1);
            $employeeData = $result['result_set'];
            $_SESSION['access_role'] = $employeeData[0]['access_role'];
            $_SESSION['full_name'] = $employeeData[0]['full_name'];
            $_SESSION['profile_picture'] = $employeeData[0]['profile_picture'];

        } else {
            // Invalid token, remove the cookie
            setcookie('remember_me', '', time() - 3600, '/', '', false, true);
        }
    } else {
        // Token expired or doesn't exist, remove the cookie
        setcookie('remember_me', '', time() - 3600, '/', '', false, true);
    }
}
?>

<?php
if (isset($_SESSION['id']) && isset($_SESSION['access_role'])){
    header("Location: ". $SMARTWAGE_LOCATION . "/smartWage-index.php?r=true");
    exit;
}

?>