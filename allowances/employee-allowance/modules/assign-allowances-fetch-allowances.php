<?php
require_once __DIR__ . '/../../Allowance.php';
require_once __DIR__ . '/../../AllowanceDao.php';
require_once __DIR__ . '/../../AllowanceRepository.php';
require_once __DIR__ . '/../../AllowanceService.php';

require_once __DIR__ . '/../../../includes/Helper.php';
require_once __DIR__ . '/../../../database/database.php';

function getAllowances(){
    global $pdo;
    $allowanceDao = new AllowanceDao($pdo);
    $selectedColumns = ["id", "name", "amount", "frequency"];
    $filterCriteria = [
        [
            "column"   => "allowance.status", 
            "operator" => "=", 
            "value"    => "Active"
        ]
    ];
    $allowanceRepository = new AllowanceRepository($allowanceDao);
    $allowanceService = new AllowanceService($allowanceRepository);
    $data = $allowanceService->fetchAllAllowances($selectedColumns, $filterCriteria, []);
    $allowances = $data['result_set'];
    return $allowances;
}
?>

<script>
var allowances = getAllowances();
function getAllowances(){
    const values = <?php 
        $allowances = getAllowances();
        echo json_encode($allowances); 
        ?>;
    return values;
}
</script>