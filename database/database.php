<?php

date_default_timezone_set('Asia/Manila');

$hosted = ($_SERVER['HTTP_HOST'] !== 'localhost' && $_SERVER['HTTP_HOST'] !== '127.0.0.1');

$dataSourceName = 'mysql:host=localhost;port=3306;dbname=smart_wage;charset=utf8mb4';
$dataSourceNameHosted = 'mysql:host=localhost;port=3306;dbname=u227551606_smartwage_db;charset=utf8mb4';

$username = 'root';
$password = ''    ;
$usernameHosted = 'u227551606_smartwage_user';
$passwordHosted = 'smartWageaA@1'    ;

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];
$pdo;
try {
    if(!$hosted){
        $pdo = new PDO(
            $dataSourceName,
            $username,
            $password,
            $options
        );
    }
    

    if ($hosted){
        $pdo = new PDO(
            $dataSourceNameHosted,
            $usernameHosted,
            $passwordHosted,
            $options
        );
    }

} catch (PDOException $exception) {
    error_log('Database Connection Error: Unable to connect to the database. ' .
              'Exception Message: ' . $exception->getMessage());
}
