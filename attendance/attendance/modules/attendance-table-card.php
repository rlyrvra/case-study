<?php
// table.php
// Expecting $data to be passed from api.php
?>
<style>
</style>
<div class="container mt-4">
  <div class="row">
    <?php if (!empty($myAttendance)): ?>
      <?php $i = ($offset + 1); foreach ($myAttendance as $row): ?>
        <div class="col-md-6 col-lg-4 mb-4">
          <div class="card shadow-sm border-1 rounded-4 overflow-hidden transition-card">
            <!-- <div class="card-header text-muted text-center py-3 border-bottom">
              
            </div> -->
            <div class="card-body p-4">
              <div class="d-flex justify-content-between">
                <div>
                  <h5 class="mb-0"> <?php echo htmlspecialchars($row['employee_full_name']); ?> </h5>
                  <small><?php echo htmlspecialchars($row['job_title']); ?></small>
                </div>
                <span class="text-muted fw-light">#<?= htmlspecialchars($i); $i++; ?></span>
              </div>
              <hr>
              <div class="text-center mt-3">
                <span class="badge 
                  <?php 
                    switch($row['attendance_status']){
                      case 'Present': echo 'bg-success'; break;
                      case 'Late': echo 'bg-warning'; break;
                      case 'Absent': echo 'bg-danger'; break;
                      case 'Overtime': echo 'bg-primary'; break;
                      case 'Undertime': echo 'bg-dark'; break;
                    }
                  ?>">
                  <?php echo htmlspecialchars($row['attendance_status']); ?>
                </span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Employee Code:</strong></span>
                <span><?php echo htmlspecialchars($row['employee_code']); ?></span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Department:</strong></span>
                <span><?php echo htmlspecialchars($row['department_name']); ?></span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Date:</strong></span>
                <span class="badge bg-primary"> <?php echo htmlspecialchars(date("F j, Y", strtotime($row['date']))); ?></span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Day:</strong></span>
                <span><?php echo htmlspecialchars(date("l", strtotime($row['date']))); ?></span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Check In:</strong></span>
                <span><?php echo !empty($row['check_in_time']) ? htmlspecialchars(date("h:i A", strtotime($row['check_in_time']))) : '-'; ?></span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Check Out:</strong></span>
                <span><?php echo !empty($row['check_out_time']) ? htmlspecialchars(date("h:i A", strtotime($row['check_out_time']))) : '-'; ?></span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Total Hours:</strong></span>
                <span><?php echo htmlspecialchars($row['total_hours_worked']); ?> hrs</span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Overtime:</strong></span>
                <span><?php echo htmlspecialchars($row['overtime_hours']); ?> hrs</span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Overtime Approved:</strong></span>
                <span class="badge badge center
                <?php 
                    if($row['is_overtime_approved'] == 0) echo "bg-danger";
                    if($row['is_overtime_approved'] == 1) echo "bg-success";
                    ?>"><?php 
                    if($row['is_overtime_approved'] == 0) echo "No";
                    if($row['is_overtime_approved'] == 1) echo "Yes";
                ?></span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Breaks:</strong></span>
                <span><?php echo htmlspecialchars($row['total_break_duration_in_minutes']); ?> mins</span>
              </div>
            </div>
            <div class="card-footer bg-light d-flex justify-content-between py-3 border-top">
              <button class="btn btn-info btn-sm" title="See Breaks..." data-bs-toggle="modal" data-bs-target="#A<?php echo htmlspecialchars($row['id']); ?>"> 
                <i class="bx bx-time"></i> Breaks
              </button>
              <?php include __DIR__ . '/attendance-modal-breaks-table.php'; ?>
              <table>
                <tbody>
                <tr data-id="<?php echo htmlspecialchars($row['id']); ?>">
                  <td>
                    <?php if ($row['is_overtime_approved'] == 0): ?>
                      <div>
                        <button class="btn btn-primary btn-sm" title="Approve overtime on this schedule" onclick="approveOvertimeClick(this)"> 
                          <i class="bx bx-calendar-check"></i>
                        </button> 
                      </div>
                    <?php endif; ?>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="col-12 text-center">
        <p>No attendance records found.</p>
      </div>
    <?php endif; ?>
  </div>
</div>


<!-- Pagination Block (Placed after the table) -->
<div class="container mt-5" id="pagination">
  <nav aria-label="Page navigation" class="d-flex justify-content-center">
    <ul class="pagination pagination-lg">
      <!-- Previous Button -->
      <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
        <a class="page-link" onclick="fetchAllAttendance('prev')" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>

      <!-- First Page -->
      <li class="page-item <?= $page === 1 ? 'active' : '' ?>">
        <a class="page-link" onclick="fetchAllAttendance(1)">1</a>
      </li>

      <!-- Ellipsis Before Current Page -->
      <?php if ($page > 3): ?>
        <li class="page-item">
          <a class="page-link" onclick="fetchPage()">...</a>
        </li>
      <?php endif; ?>

      <!-- Dynamic Middle Pages -->
      <?php
      $start = max(2, $page - 1);
      $end = min($totalPages - 1, $page + 1);
      for ($i = $start; $i <= $end; $i++):
      ?>
        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
          <a class="page-link" onclick="fetchAllAttendance(<?php echo $i ?>)"><?= $i ?></a>
        </li>
      <?php endfor; ?>

      <!-- Ellipsis After Current Page -->
      <?php if ($page < $totalPages - 2): ?>
        <li class="page-item">
          <a class="page-link" onclick="fetchPage()">...</a>
        </li>
      <?php endif; ?>

      <!-- Last Page -->
      <?php if ($totalPages > 1): ?>
        <li class="page-item <?= $page == $totalPages ? 'active' : '' ?>">
          <a class="page-link" onclick="fetchAllAttendance(<?= $totalPages ?>)"><?= $totalPages ?></a>
        </li>
      <?php endif; ?>

      <!-- Next Button -->
      <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
        <a class="page-link" onclick="fetchAllAttendance('next')" aria-label="Next">
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

    .transition-card:hover {
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
      border-color: #0d6efd;
    }
</style>