<?php
function highlightText($text, $searchText) {
    if (!empty($searchText)) {
        return preg_replace('/(' . preg_quote($searchText, '/') . ')/i', '<span style="background-color: yellow;">$1</span>', htmlspecialchars($text));
    }
    return htmlspecialchars($text);
}
?>
<style>

</style>
<div class="container">
  <?php if (!empty($workSchedules)): ?>
    <div class="row">
      <?php $i = ($offset + 1); foreach ($workSchedules as $row): ?>
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="card shadow-sm border-1 transition-card" onclick="clickCardEvent(this, event);">
            <div class="card-header d-flex justify-content-between py-3 border-bottom mb-2">
              <div>
                <h5 class="mb-0"> <?= highlightText($row['employee_full_name'], $searchFilter); ?> </h5>
                <?= highlightText($row['employee_department_name'], $searchFilter); ?><br>
                <small><?= highlightText($row['employee_job_title'], $searchFilter); ?></small>
              </div>
              <span class="text-muted fw-light">#<?= htmlspecialchars($i); $i++; ?></span>
            </div>
            <div class="card-body">
              <!-- <h5 class="card-title mb-2 fw-bold">
                <?php echo htmlspecialchars($row['employee_full_name']); ?>
              </h5> -->
              <div class="d-flex justify-content-between mb-2">
                <span class="badge bg-primary">
                  Start: <?php echo $row['is_flextime'] ? "FLEXITIME" : htmlspecialchars(date('g:i A', strtotime($row['start_time']))); ?>
                </span>
                <span class="badge bg-danger">
                  End: <?php echo $row['is_flextime'] ? "FLEXITIME" : htmlspecialchars(date('g:i A', strtotime($row['end_time']))); ?>
                </span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Work Hours:</strong></span>
                <span><?php echo htmlspecialchars($row['total_work_hours']); ?> hrs</span>
              </div>
              <?php if (isset($row['deleted_at']) && !empty($row['deleted_at'])): ?>
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Deleted At:</strong></span>
                <span><?php echo htmlspecialchars(date("F j, Y, g:i A", strtotime($row['deleted_at']))); ?></span>
              </div>
              <?php endif; ?>
            </div>
            <?php if (!isset($row['deleted_at']) || empty($row['deleted_at'])): ?>
            <div class="card-footer bg-light py-3 border-top">
              <table class="w-100">
                <tbody>
                  <tr data-id="<?php echo htmlspecialchars($row['id']);?>"
                  >
                    <td colspan="2">
                      <div class="d-flex justify-content-between">
                        <button class="btn btn-sm btn-info" 
                          onclick="fetchBreakTypes(); fetchWorkScheduleAndBreak(this);" 
                          data-bs-toggle="modal" data-bs-target="#update_work_schedules">
                          <i class="bx bx-edit-alt"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="confirmDeleteWorkSchedule(this)">
                          <i class="bx bx-trash"></i> Delete
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <?php endif; ?>
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

  .transition-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 12px;
    overflow: hidden;
    background: #fff;
  }

  .transition-card:hover {
    cursor: pointer;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
    border-color: #0d6efd;
  }

  .transition-card:hover .card-header h5, .transition-card:hover .card-header span {
    color: white !important;
  }

  .transition-card .card-header {
    background: #f8f9fa;
    transition: background 0.3s ease, color 0.3s ease;
  }

  .transition-card:hover .card-header {
    background: #0d6efd;
    color: #fff;
  }

  .transition-card .card-body {
    transition: background 0.3s ease;
  }

  .transition-card:hover .card-body {
    background: #f9f9f9;
  }
</style>