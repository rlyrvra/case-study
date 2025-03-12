<style>
    body { font-family: Arial, sans-serif; }
    .container { width: 100%; padding: 10px; }
    .header { background-color: #007bff; color: white; padding: 10px; text-align: center; }
    .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    .table td { padding: 8px; border-bottom: 1px solid #ddd; }
    .text-muted { color: #6c757d; }
    .text-success { color: #28a745; font-weight: bold; }
    .text-danger { color: #dc3545; font-weight: bold; }
    .fw-bold { font-weight: bold; }
    .footer { text-align: center; font-size: 12px; color: #6c757d; margin-top: 10px; }

    /* Custom Header/Footer */
    .pdf-header {
        position: fixed;
        top: -30px;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 12px;
        color: #6c757d;
    }
    
    .pdf-footer {
        position: fixed;
        bottom: -30px;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 12px;
        color: #6c757d;
    }
    .payslip-page {
        page-break-after: always;
    }

</style>

<!-- Header -->
<div class='pdf-header'>
    <strong>Company Name</strong><br>
    Payslip Report | <?php echo date("F Y", strtotime($row['pay_date'])); ?>
</div>

<!-- Main Content -->
<div class='container'>
    <div class='header'>
        <h3><?php echo htmlspecialchars($row['full_name']); ?></h3>
        <small><?php echo htmlspecialchars($row['job_title_title']) . " - " . htmlspecialchars($row['department_name']); ?></small>
    </div>

    <table class='table'>
        <tr><td class='text-muted'>Employee Code:</td><td class='fw-bold'><?php echo htmlspecialchars($row['employee_code']); ?></td></tr>
        <tr><td class='text-muted'>Pay Frequency:</td><td class='fw-bold'><?php echo htmlspecialchars($row['payroll_frequency']); ?></td></tr>
        <tr><td class='text-muted'>Employment Type:</td><td class='fw-bold'><?php echo htmlspecialchars($row['employment_type']); ?></td></tr>
        <tr><td class='text-muted'>Basic Salary:</td><td class='text-success'>P<?php echo number_format($row['basic_salary'], 2); ?></td></tr>
    </table>

    <hr>

    <table class='table'>
        <tr><td class='text-muted'>Bank:</td><td><?php echo htmlspecialchars($row['bank_name']); ?></td></tr>
        <tr><td class='text-muted'>Account No.:</td><td class='fw-bold'>
            <?php echo htmlspecialchars($row['bank_account_number']); ?>
        </td></tr>
    </table>

    <hr>

    <table class='table'>
        <tr><td class='text-muted'>Pay Date:</td><td><?php echo date("M j, Y", strtotime($row['pay_date'])); ?></td></tr>
        <tr><td class='text-muted'>Pay Period Start:</td><td><?php echo date("M j, Y", strtotime($row['pay_period_start_date'])); ?></td></tr>
        <tr><td class='text-muted'>Pay Period End:</td><td><?php echo date("M j, Y", strtotime($row['pay_period_end_date'])); ?></td></tr>
    </table>

    <hr>

    <table class='table'>
        <tr><td class='text-muted'>SSS:</td><td class='text-danger'>P<?php echo number_format($row['sss_deduction'], 2); ?></td></tr>
        <tr><td class='text-muted'>PhilHealth:</td><td class='text-danger'>P<?php echo number_format($row['philhealth_deduction'], 2); ?></td></tr>
        <tr><td class='text-muted'>Tax:</td><td class='text-danger'>P<?php echo number_format($row['withholding_tax'], 2); ?></td></tr>
    </table>

    <hr>

    <table class='table'>
        <tr><td class='text-muted'>Gross Pay:</td><td class='text-success fw-bold h5'>P<?php echo number_format($row['gross_pay'], 2); ?></td></tr>
    </table>

    <!-- Footer -->
    <div class='pdf-footer'>
        <small>Page <?php echo $i; ?> of <?php echo $totalPayslips; ?></small> <br>
        <small>Payslip generated at <?php echo date('l, F j, Y, g:i A'); ?> using smartWage</small>
    </div>
</div>
