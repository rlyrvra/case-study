
<?php
function highlightText($text, $searchText) {
    if (!empty($searchText)) {
        return preg_replace('/(' . preg_quote($searchText, '/') . ')/i', '<span style="background-color: yellow;">$1</span>', htmlspecialchars($text));
    }
    return htmlspecialchars($text);
}

function findNamedDay($dayNumber) {
  $days = [
      1 => "Monday",
      2 => "Tuesday",
      3 => "Wednesday",
      4 => "Thursday",
      5 => "Friday",
      6 => "Saturday",
      7 => "Sunday"
  ];
  return $days[$dayNumber] ?? "Invalid Day";
}

?>
<div class="container">
  <div class="row">
    <?php $i = ($offset + 1); if (!empty($payrollGroups)): ?>
      <?php foreach ($payrollGroups as $row): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card shadow-sm mb-4 transition-card border-1" onclick="clickCardEvent(this, event);">
            <div class="card-header d-flex justify-content-between py-3 border-bottom mb-2">
              <div>
                <h5 class="card-title fw-bold"> <?= highlightText($row['name'], $searchFilter); ?>  </h5>
                <span>
                    <?= highlightText($row['payroll_frequency'], $searchFilter); ?>
                </span>
              </div>
              <span class="text-muted fw-light">#<?= htmlspecialchars($i); $i++; ?></span>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Cut Off:</strong></span>
                <span>
                  <?php
                  if($row['payroll_frequency'] === 'Weekly' || $row['payroll_frequency'] === 'Bi-weekly'){
                    echo htmlspecialchars(findNamedDay($row['day_of_weekly_cutoff']));
                  } else if($row['payroll_frequency'] === 'Semi-monthly'){
                    echo htmlspecialchars("Every " . $row['semi_monthly_first_cutoff'] . " and " . $row['semi_monthly_second_cutoff'] . " of the month");
                  }
                  ?>
                </span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Payday Offset:</strong></span>
                <span><?= htmlspecialchars($row['payday_offset']); ?></span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Status:</strong></span>
                <span class="badge 
                  <?php echo $row['status'] === "Active" ? "bg-primary" : ($row['status'] === "Inactive" ? "bg-warning" : "bg-danger"); ?>">
                  <?= htmlspecialchars($row['status']); ?>
                </span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Created:</strong></span>
                <span><?= htmlspecialchars(date("F j, Y, g:i A", strtotime($row['created_at']))); ?></span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Modified:</strong></span>
                <span><?= htmlspecialchars(date("F j, Y, g:i A", strtotime($row['updated_at']))); ?></span>
              </div>
              <?php if (isset($status) && $status === "Archived"): ?>
                <div class="d-flex justify-content-between mb-2">
                  <span><strong>Deleted:</strong></span>
                  <span><?= htmlspecialchars(date("F j, Y, g:i A", strtotime($row['deleted_at']))); ?></span>
                </div>
              <?php endif ?>
            </div>
            <?php if (!isset($status) || $status !== "Archived"): ?>
            <div class="card-footer bg-light py-3 border-top">
              <table class="w-100">
                <tbody>
                <tr data-id="<?php echo htmlspecialchars($row['id']); ?>" 
                    data-name="<?php echo htmlspecialchars($row['name']); ?>" 
                    data-payfreq="<?php echo htmlspecialchars($row['payroll_frequency']); ?>" 
                    data-weekly-cutoff="<?php echo htmlspecialchars($row['day_of_weekly_cutoff']); ?>" 
                    data-biweekly-cutoff="<?php echo htmlspecialchars($row['day_of_biweekly_cutoff']); ?>"
                    data-semimonthly-first-cutoff="<?php echo htmlspecialchars($row['semi_monthly_first_cutoff']); ?>"
                    data-semimonthly-second-cutoff="<?php echo htmlspecialchars($row['semi_monthly_second_cutoff']); ?>"
                    data-payday-offset="<?php echo htmlspecialchars($row['payday_offset']); ?>"
                    data-payday-adjustment="<?php echo htmlspecialchars($row['payday_adjustment']); ?>"  
                    data-status="<?php echo htmlspecialchars($row['status']); ?>"
                    >
                    <td colspan="2">
                      <div class="d-flex justify-content-between">
                        <button class="btn btn-sm btn-info" title="Edit" onclick="updatePayrollGroupClick(this)" data-bs-toggle="modal" data-bs-target="#update-payrollGroups-modal"> 
                          <i class="bx bx-edit-alt"></i> Edit
                        </button>
                        <button class="btn btn-sm btn-danger" title="Delete" onclick="confirmDeletePayrollGroup(this)"> 
                          <i class="bx bx-trash"></i> Delete
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table> 
            </div>
            <?php endif ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <div class="col-12 text-center py-5">
        <p class="text-muted">No data available</p>
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
        <a class="page-link" onclick="fetchAllPayrollGroups('prev')" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>

      <!-- First Page -->
      <li class="page-item <?= $page === 1 ? 'active' : '' ?>">
        <a class="page-link" onclick="fetchAllPayrollGroups(1)">1</a>
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
          <a class="page-link" onclick="fetchAllPayrollGroups(<?php echo $i ?>)"><?= $i ?></a>
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
          <a class="page-link" onclick="fetchAllPayrollGroups(<?= $totalPages ?>)"><?= $totalPages ?></a>
        </li>
      <?php endif; ?>

      <!-- Next Button -->
      <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
        <a class="page-link" onclick="fetchAllPayrollGroups('next')" aria-label="Next">
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