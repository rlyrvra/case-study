<?php
function highlightText($text, $searchText) {
    if (!empty($searchText)) {
        return preg_replace('/(' . preg_quote($searchText, '/') . ')/i', '<span style="background-color: yellow;">$1</span>', htmlspecialchars($text));
    }
    return htmlspecialchars($text);
}
?>
<div class="container mt-5">
    <div class="row">
        <?php if (!empty($leaveRequests)): ?>
            <?php $i = ($offset + 1); foreach ($leaveRequests as $row): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card border-1 shadow-sm rounded-4">
                        <div class="card-body p-4" onclick="clickCardEvent(this, event);">
                            <div class="d-flex align-items-center">
                                <img src="<?php echo isset($row['employee_profile_picture']) ? 'data:image/jpg;base64,' . $row['employee_profile_picture'] : 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&s=200'; ?>" 
                                     alt="Profile Picture" class="rounded-circle border me-3" width="55" height="55">
                                <div>
                                    <div class="d-flex align-items-center">
                                        <h5 class="mb-1 fw-semibold text-dark me-5"><?= highlightText($row['employee_full_name'], $searchFilter); ?></h5>
                                        <span class="text-muted fw-light">#<?= htmlspecialchars($i); $i++; ?></span>
                                    </div>
                                    <small class="text-muted"><?php echo htmlspecialchars($row['employee_department_name']); ?></small>
                                </div>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span><strong>Leave Type:</strong></span>
                                    <span><?php echo htmlspecialchars($row['leave_type_name']); ?> </span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span><strong>Start Date:</strong></span>
                                    <span><?php echo htmlspecialchars($row['start_date']); ?> </span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span><strong>End Date:</strong></span>
                                    <span><?php echo htmlspecialchars($row['end_date']); ?> </span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span><strong>Half Day:</strong></span>
                                    <span class="badge rounded-pill <?php echo $row['is_half_day'] ? 'bg-success' : 'bg-danger'; ?>">
                                        <?php echo $row['is_half_day'] ? 'Yes' : 'No'; ?>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span><strong>Status:</strong></span>
                                    <span class="badge rounded-pill px-3 py-2 fw-semibold <?php 
                                        switch ($row['status']) {
                                            case 'Approved': echo 'bg-success'; break;
                                            case 'Pending': echo 'bg-warning text-dark'; break;
                                            case 'Rejected': echo 'bg-danger'; break;
                                            case 'Canceled': echo 'bg-secondary'; break;
                                            case 'Expired': echo 'bg-dark'; break;
                                        } 
                                    ?>"><?php echo htmlspecialchars($row['status']); ?>
                                    </span>
                                </div>
                            </div>
                            <?php if (!in_array($row['status'], ['Approved', 'Expired', 'Completed', 'In Progress', 'Canceled'])): ?>
                                <button class="btn btn-outline-primary btn-sm mt-2 w-100" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#R<?php echo htmlspecialchars($row['id']); ?>">
                                    View Reason <i class="bx bx-info-circle"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php if (!in_array($row['status'], ['Approved', 'Expired', 'Completed', 'In Progress', 'Canceled']))  include __DIR__ . '/leave-requests-modal-reason.php';?>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p class="text-muted fs-5">No leave requests available.</p>
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
        <a class="page-link" onclick="fetchAllDepartments('prev')" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <!-- Page Numbers -->
        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
          <a class="page-link" onclick="fetchAllDepartments(<?php echo $i ?>)" ><?= $i ?></a>
        </li>
      <?php endfor; ?>
      <!-- Next Button -->
      <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
        <a class="page-link" onclick="fetchAllDepartments('next')" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>
</div>

<style>
    #leave_requests_table .card {
        transition: all 0.3s ease-in-out;
        border-radius: 12px;
    }
    #leave_requests_table .card:hover {
        cursor: pointer;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        border-color: #0d6efd;
    }
    #leave_requests_table .badge {
        font-size: 0.85rem;
    }
</style>