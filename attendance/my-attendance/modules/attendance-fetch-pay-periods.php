<?php
require_once __DIR__ . '/../../../includes/Helper.php';
require_once __DIR__ . '/../../../database/database.php';
require_once __DIR__ . '/../../../includes/session.php';

function getPayPeriods() {
    global $pdo;

    try {
        $sql = "SELECT 
                    ROW_NUMBER() OVER (ORDER BY payslip.pay_date DESC) AS id,
                    payslip.pay_date AS pay_date,
                    payslip.pay_period_start_date AS pay_period_start_date,
                    payslip.pay_period_end_date AS pay_period_end_date
                    FROM payslips AS payslip
                    WHERE payslip.employee_id = " . $_SESSION['id'] .
                    " ORDER BY payslip.pay_date DESC";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        
        $attendanceRecords = $stmt->fetchAll(PDO::FETCH_ASSOC); // Fetch as an array of month_year values
        
        return $attendanceRecords;
    } catch (PDOException $e) {
        return ['error' => $e->getMessage()]; // Return an error if something goes wrong
    }
}
?>

<script>
function clearPayPeriods(select){
    select.innerHTML = '';
}

var payPeriodsRecords = getPayPeriods();
function getPayPeriods(){
    const values = <?php 
        $payPeriods = getPayPeriods();
        echo json_encode($payPeriods); 
        ?>;
    console.log(values);
    return values;
}

function populatePayPeriods(select){
    clearPayPeriods(select);
    payPeriodsRecords.forEach(payPeriodsRecord => {
        const option = document.createElement("option");
        option.value = payPeriodsRecord.pay_period_start_date + " - " + payPeriodsRecord.pay_period_end_date;
        option.text = payPeriodsRecord.pay_date;
        select.add(option);
    });
}

</script>