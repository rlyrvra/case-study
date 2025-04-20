<?php
function highlightText($text, $searchText) {
    if (!empty($searchText)) {
        return preg_replace('/(' . preg_quote($searchText, '/') . ')/i', '<span style="background-color: yellow;">$1</span>', htmlspecialchars($text));
    }
    return htmlspecialchars($text);
}
?>

<div class="container">
  <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php if (!empty($holidays)): ?>
      <?php $i = ($offset + 1); foreach ($holidays as $row): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card shadow-sm mb-4 transition-card border-1 h-100 w-100" onclick="clickCardEvent(this, event);">
            <div class="card-header d-flex justify-content-between py-3 border-bottom mb-2">
              <h5><?= highlightText($row['name'], $searchFilter); ?></h5>
              <span class="text-muted fw-light">#<?= htmlspecialchars($i); $i++; ?></span>
            </div>
            <div class="card-body">
              <div class="d-flex justify-content-between mb-2">
                <span class="badge bg-primary">
                  Start: <?= htmlspecialchars($row['start_date']); ?>
                </span>
                <span class="badge bg-danger">
                  End: <?= htmlspecialchars($row['end_date']); ?>
                </span>
              </div>
              <p class="card-text" style="text-align: justify;"> <strong>Description:</strong> <?= highlightText($row['description'], $searchFilter); ?> </p>
              
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Paid:</strong></span>
                <span class="badge <?= $row['is_paid'] ? 'bg-success' : 'bg-danger'; ?>">
                  <?= $row['is_paid'] ? 'Yes' : 'No'; ?>
                </span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Annually:</strong></span>
                <span class="badge <?= $row['is_recurring_annually'] ? 'bg-success' : 'bg-danger'; ?>">
                  <?= $row['is_recurring_annually'] ? 'Yes' : 'No'; ?>
                </span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Status:</strong></span>
                <span class="badge 
                  <?= ($row['status'] === "Active") ? 'bg-primary' : (($row['status'] === "Inactive") ? 'bg-warning' : 'bg-danger'); ?>">
                  <?= htmlspecialchars($row['status']); ?>
                </span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Created:</strong></span>
                <span><?= htmlspecialchars(date("F j, Y, g:i A", strtotime($row['created_at']))); ?></span>
              </div>
              <div class="d-flex justify-content-between mb-2">
                <span><strong>Updated:</strong></span>
                <span><?= htmlspecialchars(date("F j, Y, g:i A", strtotime($row['updated_at']))); ?></span>
              </div>
            </div>
            <?php if ($row['status'] !== "Archived"): ?>
              <div class="card-footer bg-light py-3 border-top">
                <table class="w-100">
                  <tbody>
                    <tr data-id="<?php echo htmlspecialchars($row['id']); ?>" 
                        data-name="<?php echo htmlspecialchars($row['name']); ?>" 
                        data-start="<?php echo htmlspecialchars($row['start_date']); ?>" 
                        data-end="<?php echo htmlspecialchars($row['end_date']); ?>" 
                        data-paid="<?php echo htmlspecialchars($row['is_paid']); ?>"
                        data-recurring="<?php echo htmlspecialchars($row['is_recurring_annually']); ?>"
                        data-description="<?php echo htmlspecialchars($row['description']); ?>"  
                        data-status="<?php echo htmlspecialchars($row['status']); ?>"
                      >
                      <td colspan="2">
                        <div class="d-flex justify-content-between">
                          <button class="btn btn-sm btn-info" title="Edit" onclick="updateHolidayClick(this)" data-bs-toggle="modal" data-bs-target="#update-holidays-modal"> 
                            <i class="bx bx-edit-alt"></i> Edit
                          </button>
                          <button class="btn btn-sm btn-danger" title="Delete" onclick="confirmDeleteHoliday(this)"> 
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
        <p class="text-muted">No holidays available</p>
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
        <a class="page-link" onclick="fetchAllHolidays('prev')" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <!-- Page Numbers -->
        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
          <a class="page-link" onclick="fetchAllHolidays(<?php echo $i ?>)" ><?= $i ?></a>
        </li>
      <?php endfor; ?>
      <!-- Next Button -->
      <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
        <a class="page-link" onclick="fetchAllHolidays('next')" aria-label="Next">
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