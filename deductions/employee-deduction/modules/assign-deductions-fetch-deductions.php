<?php
require_once __DIR__ . '/../../Deduction.php';
require_once __DIR__ . '/../../DeductionDao.php';
require_once __DIR__ . '/../../DeductionRepository.php';
require_once __DIR__ . '/../../DeductionService.php';

require_once __DIR__ . '/../../../includes/Helper.php';
require_once __DIR__ . '/../../../includes/enums/ErrorCode.php';
require_once __DIR__ . '/../../../database/database.php';

function getDeductions(){
    global $pdo;
    $deductionDao = new DeductionDao($pdo);
    $selectedColumns = ["id", "name", "amount", "frequency"];
    $filterCriteria = [
        [
            "column"   => "deduction.status", 
            "operator" => "=", 
            "value"    => "Active"
        ]
    ];
    $deductionRepository = new DeductionRepository($deductionDao);
    $deductionService = new DeductionService($deductionRepository);
    $data = $deductionService->fetchAllDeductions($selectedColumns, $filterCriteria, []);
    $deductions = $data['result_set'];
    return $deductions;
}
?>

<script>
var deductions = getDeductions();
function getDeductions(){
    const values = <?php 
        $deductions = getDeductions();
        echo json_encode($deductions); 
        ?>;
    return values;
}
</script>