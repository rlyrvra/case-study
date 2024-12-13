<?php

date_default_timezone_set('Asia/Manila');

$dataSourceName = 'mysql:host=localhost;port=3306;dbname=smart_wage;charset=utf8mb4';
$dataSourceNameHosted = 'mysql:host=localhost;port=3306;dbname=u227551606_db_smartWage;charset=utf8mb4';

$username = 'root';
$password = ''    ;
$usernameHosted = 'u227551606_db_smartWage';
$passwordHosted = 'smartWageaA@1'    ;

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $pdo = new PDO(
        $dataSourceName,
        $username,
        $password,
        $options
    );

    // $pdo = new PDO(
    //     $dataSourceNameHosted,
    //     $usernameHosted,
    //     $passwordHosted,
    //     $options
    // );

} catch (PDOException $exception) {
    error_log('Database Connection Error: Unable to connect to the database. ' .
              'Exception Message: ' . $exception->getMessage());
}
