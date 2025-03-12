<?php
// table.php
// Expecting $data to be passed from api.php
?>
<style>
</style>
<!-- Table Rendering -->



<table class="table table-striped table-hover table-bordered align-middle">
    <thead class="table-dark text-center align-middle">
      <tr>
        <th style="width: 3%;">#</th>
        <th>Full Name</th>
        <th>Employee Code</th>
        <th>Department</th>
        <th>Job Title</th>
        <th>Employment Type</th>
        <th>Basic Salary</th>
        <th>Bank</th>
        <th>Account No.</th>
        <th>Account Type</th>
        <th>Payroll Frequency</th>
        <th>Pay Date</th>
        <th>Period End</th>
        <th>SSS</th>
        <th>Philhealth</th>
        <th>Tax</th>
        <th>Gross Pay</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($payslips)): ?>
        <?php $i = ($offset + 1); foreach ($payslips as $row): ?>
          <tr>
            <td class="text-center"><?php echo $i++; ?></td>
            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
            <td class="text-center"><?php echo htmlspecialchars($row['employee_code']); ?></td>
            <td><?php echo htmlspecialchars($row['department_name']); ?></td>
            <td><?php echo htmlspecialchars($row['job_title_title']); ?></td>
            <td><?php echo htmlspecialchars($row['employment_type']); ?></td>
            <td class="text-end"><?php echo number_format($row['basic_salary'], 2); ?></td>
            <td><?php echo htmlspecialchars($row['bank_name']); ?></td>
            <td class="text-center"><?php echo substr($row['bank_account_number'], 0, 2) . str_repeat('*', strlen($row['bank_account_number']) - 4) . substr($row['bank_account_number'], -2); ?></td>
            <td class="text-center"><?php echo htmlspecialchars($row['bank_account_type']); ?></td>
            <td class="text-center"><?php echo htmlspecialchars($row['pay_frequency']); ?></td>
            <td class="text-center"><?php echo date("M j, Y", strtotime($row['pay_date'])); ?></td>
            <td class="text-center"><?php echo date("M j, Y", strtotime($row['pay_period_end_date'])); ?></td>
            <td class="text-end"><?php echo number_format($row['sss_deduction'], 2); ?></td>
            <td class="text-end"><?php echo number_format($row['philhealth_deduction'], 2); ?></td>
            <td class="text-end"><?php echo number_format($row['withholding_tax'], 2); ?></td>
            <td class="text-end fw-bold"><?php echo number_format($row['gross_pay'], 2); ?></td>
          </tr>
        <?php endforeach; ?>

    <?php else: ?>
      <tr>
        <td colspan="7">No data available</td>
      </tr>
    <?php endif; ?>
  </tbody>
  <!-- <tfoot class="table-border-bottom-0">
      <th style='width: 1%;'>#</th>
      <th>Date</th>
      <th>Day of Week</th>
      <th>Check In Time</th>
      <th>Check Out Time</th>
      <th>Break Records</th>
      <th>Total Break Duration</th>
      <th>Total Hours Worked</th>
      <th>Late Check In</th>
      <th>Early Check Out</th>
      <th>Overtime Hours</th>
      <th>Overtime Approval</th>
      <th>Status</th>
      <th>Remarks</th>
  </tfoot> -->
</table>

<!-- Pagination Block (Placed after the table) -->
<div class="container mt-5" id="pagination">
  <nav aria-label="Page navigation" class="d-flex justify-content-center">
    <ul class="pagination pagination-lg">
      <!-- Previous Button -->
      <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
        <a class="page-link" onclick="fetchAllMyAttendance('prev')" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <!-- Page Numbers -->
        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
          <a class="page-link" onclick="fetchAllMyAttendance(<?php echo $i ?>)" ><?= $i ?></a>
        </li>
      <?php endfor; ?>
      <!-- Next Button -->
      <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
        <a class="page-link" onclick="fetchAllMyAttendance('next')" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>
</div>

<style>
    .page-item:hover:not(.disabled){
        cursor: pointer !important;
    }
</style>