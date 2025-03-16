<?php
// table.php
// Expecting $data to be passed from api.php
?>
<style>

</style>
<div class="container">
  <?php if (!empty($workSchedules)): ?>
    <div class="row">
      <?php $i = $offset; foreach ($workSchedules as $row): ?>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card shadow-sm border-0">
            <div class="card-body">
              <h6 class="text-muted">#<?php echo ++$i; ?></h6>
              <h5 class="card-title mb-2">
                <?php echo htmlspecialchars($row['employee_full_name']); ?>
              </h5>
              <div class="mb-2">
                <span class="badge bg-primary">
                  Start: <?php echo $row['is_flextime'] ? "FLEXITIME" : htmlspecialchars(date('g:i A', strtotime($row['start_time']))); ?>
                </span>
                <span class="badge bg-danger">
                  End: <?php echo $row['is_flextime'] ? "FLEXITIME" : htmlspecialchars(date('g:i A', strtotime($row['end_time']))); ?>
                </span>
              </div>
              <p class="text-muted small mb-2">
                Work Hours: <strong><?php echo htmlspecialchars($row['total_work_hours']); ?> hrs</strong>
              </p>
            </div>
            <div class="card-footer bg-white d-flex justify-content-between">
              <?php if (!isset($status) || $status !== 'Archived'): ?>
                <button class="btn btn-sm btn-outline-primary" 
                  onclick="fetchBreakTypes(); fetchWorkScheduleAndBreak(this);" 
                  data-bs-toggle="modal" data-bs-target="#update_work_schedules">
                  <i class="bx bx-edit-alt"></i> Edit
                </button>
                <button class="btn btn-sm btn-outline-danger" onclick="confirmDeleteWorkSchedule(this)">
                  <i class="bx bx-trash"></i> Delete
                </button>
              <?php else: ?>
                <small class="text-muted">Deleted At: <?php echo htmlspecialchars($row['deleted_at']); ?></small>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="alert alert-warning text-center">No work schedules available.</div>
  <?php endif; ?>
</div>


<!-- Pagination Block (Placed after the table) -->
<div class="container mt-5" id="pagination">
  <nav aria-label="Page navigation" class="d-flex justify-content-center">
    <ul class="pagination pagination-lg">
      <!-- Previous Button -->
      <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
        <a class="page-link" onclick="fetchAllWorkSchedules('prev')" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>

      <!-- First Page -->
      <li class="page-item <?= $page === 1 ? 'active' : '' ?>">
        <a class="page-link" onclick="fetchAllWorkSchedules(1)">1</a>
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
          <a class="page-link" onclick="fetchAllWorkSchedules(<?php echo $i ?>)"><?= $i ?></a>
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
          <a class="page-link" onclick="fetchAllWorkSchedules(<?= $totalPages ?>)"><?= $totalPages ?></a>
        </li>
      <?php endif; ?>

      <!-- Next Button -->
      <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
        <a class="page-link" onclick="fetchAllWorkSchedules('next')" aria-label="Next">
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