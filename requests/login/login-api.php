<?php require_once __DIR__ . '/../../database/database.php'; ?>
<?php require_once __DIR__ . '/../../employees/EmployeeDao.php'; ?>
<?php require_once __DIR__ . '/../../includes/session.php'; ?>

<?php

$response = ['success' => false];

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) && $_POST['remember'] == 'true' ? true : false; // Check for Remember Me

    $employeeDao = new EmployeeDao($pdo);

    $selectedColumns = ["id", "access_role"];
    $filterCriteria = [
        [
            "column" => "employee.username",
            "operator" => "=",
            "value" => $username
        ],
        [
            "column" => "employee.password",
            "operator" => "=",
            "value" => $password
        ]
    ];

    $data = $employeeDao->fetchAll($selectedColumns, $filterCriteria);
    $result = $data['result_set'];

    if (count($result) <= 0) {
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }

    $response['success'] = true;
    $userId = $result[0]['id'];
    $accessRole = $result[0]['access_role'];

    // Store user info in the session
    $_SESSION['id'] = $userId;
    $_SESSION['access_role'] = $accessRole;

    // Handle the "Remember Me" functionality
    if ($remember) {
        // Generate a unique token for the "Remember Me" cookie
        $selector = bin2hex(random_bytes(8));  // 16 characters long
        $validator = bin2hex(random_bytes(32));  // 64 characters long
        $cookie = $selector . ':' . $validator;
        
        // Store the cookie in the browser, expires in 30 days
        setcookie('remember_me', $cookie, time() + (30 * 24 * 60 * 60), '/', '', false, true);

        // Hash the validator for secure storage
        $hashed_token = hash('sha256', $validator);

        // Store the token (selector and hashed token) in the database for later validation
        $sql = "INSERT INTO remember_me_tokens (user_id, selector, hashed_token, expires_at) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId, $selector, $hashed_token, date('Y-m-d H:i:s', strtotime('+30 days'))]);
    }
}

header('Content-Type: application/json');
echo json_encode($response);
exit;
?>