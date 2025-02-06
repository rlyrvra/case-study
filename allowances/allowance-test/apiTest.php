<?php

if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || $_SERVER['HTTP_X_REQUESTED_WITH'] != 'XMLHttpRequest') {
    exit('This resource is only accessible via AJAX requests.');
}

require_once __DIR__ . '/../AllowanceDao.php';
require_once __DIR__ . '/../Allowance.php';
require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../includes/enums/ErrorCode.php';
require_once __DIR__ . '/../../database/database.php';


try {
    $userId = 1;
    $allowanceDao = new AllowanceDao($pdo);
    $action = $_POST['action'] ?? '';
    $limit = 5;
    //$offset = ($page - 1) * $limit;

    if ($action === 'fetchAll') {
        $data = $allowanceDao->fetchAll([], [["column" => "status", "operator" => "=", "value" => "Active"]], [["column" => "allowance.created_at", "direction" => "DESC"]], $limit);
        $allowances = $data["result_set"];
        $totalAllowances = $data["total_row_count"];
        $totalPages = ceil($totalAllowances / $limit);
        include __DIR__ . '/allowanceTable.php';
        return;
    } 


    if ($action === 'create') {
        $allowanceData = $_POST['allowance'] ?? null;

        if ($allowanceData) {
            print_r($allowanceData);


            $name = $allowanceData['name'] ?? '';
            $amount = $allowanceData['amount'] ?? null;
            $isTaxable = $allowanceData['isTaxable'] ?? null;
            $frequency = $allowanceData['frequency'] ?? '';
            $description = $allowanceData['description'] ?? '';
            $status = $allowanceData['status'] ?? '';
            $effectiveDate = $allowanceData['effectiveDate'] ?? '';
            $endDate = $allowanceData['endDate'] ?? '';

            $newAllowance = new Allowance(
                id: null,
                name: $name,
                amount: $amount,
                isTaxable: $isTaxable,
                frequency: $frequency,
                description: $description,
                status: $status,
                effectiveDate: $effectiveDate,
                endDate: $endDate
            );

            $result = $allowanceDao->create($newAllowance, 1);

            

            if ($result) {
                echo "allowance created successfully!";
            } else {
                echo "Failed to create allowance. Please try again.";
            }
        } else {
            echo "Invalid allowance data.";
        }
        return;
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}