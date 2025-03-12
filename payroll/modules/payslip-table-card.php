<?php
// table.php
// Expecting $data to be passed from api.php
?>
<style>
</style>
<!-- Table Rendering -->



<div class="container">
  <?php if (!empty($payslips)): ?>
    <div class="row g-3">
      <?php foreach ($payslips as $row): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white mb-2">
              <h5 class="mb-0 text-white"><?php echo htmlspecialchars($row['full_name']); ?></h5>
              <small><?php echo htmlspecialchars($row['job_title_title']); ?> - <?php echo htmlspecialchars($row['department_name']); ?></small>
            </div>
            <div class="card-body">
              <div class="row mb-2">
                <div class="col-6 text-muted">Employee Code:</div>
                <div class="col-6 fw-bold"><?php echo htmlspecialchars($row['employee_code']); ?></div>
              </div>
              <div class="row mb-2">
                <div class="col-6 text-muted">Employment Type:</div>
                <div class="col-6 fw-bold"><?php echo htmlspecialchars($row['employment_type']); ?></div>
              </div>
              <div class="row mb-2">
                <div class="col-6 text-muted">Basic Salary:</div>
                <div class="col-6 fw-bold text-success">₱<?php echo number_format($row['basic_salary'], 2); ?></div>
              </div>
              <hr>
              <div class="row mb-2">
                <div class="col-6 text-muted">Bank:</div>
                <div class="col-6"><?php echo htmlspecialchars($row['bank_name']); ?></div>
              </div>
              <div class="row mb-2">
                <div class="col-6 text-muted">Account No.:</div>
                <div class="col-6 fw-bold"><?php echo substr($row['bank_account_number'], 0, 2) . str_repeat('*', strlen($row['bank_account_number']) - 4) . substr($row['bank_account_number'], -2); ?></div>
              </div>
              <hr>
              <div class="row mb-2">
                <div class="col-6 text-muted">Pay Date:</div>
                <div class="col-6"><?php echo date("M j, Y", strtotime($row['pay_date'])); ?></div>
              </div>
              <div class="row mb-2">
                <div class="col-6 text-muted">Pay Period Start:</div>
                <div class="col-6"><?php echo date("M j, Y", strtotime($row['pay_period_start_date'])); ?></div>
              </div>
              <div class="row mb-2">
                <div class="col-6 text-muted">Pay Period End:</div>
                <div class="col-6"><?php echo date("M j, Y", strtotime($row['pay_period_end_date'])); ?></div>
              </div>
              <hr>
              <div class="row mb-2">
                <div class="col-6 text-muted">SSS:</div>
                <div class="col-6 text-danger">₱<?php echo number_format($row['sss_deduction'], 2); ?></div>
              </div>
              <div class="row mb-2">
                <div class="col-6 text-muted">PhilHealth:</div>
                <div class="col-6 text-danger">₱<?php echo number_format($row['philhealth_deduction'], 2); ?></div>
              </div>
              <div class="row mb-2">
                <div class="col-6 text-muted">Tax:</div>
                <div class="col-6 text-danger">₱<?php echo number_format($row['withholding_tax'], 2); ?></div>
              </div>
              <hr>
              <div class="row">
                <div class="col-6 text-muted">Gross Pay:</div>
                <div class="col-6 fw-bold text-success h5">₱<?php echo number_format($row['gross_pay'], 2); ?></div>
              </div>
            </div>
            <div class="card-footer bg-light text-center">
              <small class="text-muted">Payroll Frequency: <?php echo htmlspecialchars($row['pay_frequency']); ?></small>
              <!-- Actions Button -->
              <div class="dropdown mt-2">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Actions
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="#" onclick="downloadPDF('<?php echo hash('sha256', $row['id']); ?>')"><i class="bx bx-file"></i>Download PDF</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-danger text-center">No payroll records available.</div>
  <?php endif; ?>
</div>

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