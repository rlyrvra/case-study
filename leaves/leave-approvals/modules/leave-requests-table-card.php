<div class="container mt-5">
    <div class="row">
        <?php if (!empty($leaveRequests)): ?>
            <?php foreach ($leaveRequests as $row): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <img src="<?php echo isset($row['employee_profile_picture']) ? 'data:image/jpg;base64,' . $row['employee_profile_picture'] : 'https://via.placeholder.com/50'; ?>" 
                                     alt="Profile Picture" class="rounded-circle border me-3" width="55" height="55">
                                <div>
                                    <h5 class="mb-1 fw-semibold text-dark"><?php echo htmlspecialchars($row['employee_full_name']); ?></h5>
                                    <small class="text-muted">Department: <?php echo htmlspecialchars($row['employee_department_name']); ?></small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1 text-secondary"><strong>Leave Type:</strong> <?php echo htmlspecialchars($row['leave_type_name']); ?></p>
                                <p class="mb-1 text-secondary"><strong>Duration:</strong> <?php echo htmlspecialchars($row['start_date']); ?> - <?php echo htmlspecialchars($row['end_date']); ?></p>
                                <p class="mb-1 text-secondary"><strong>Half Day:</strong> 
                                    <span class="badge rounded-pill <?php echo $row['is_half_day'] ? 'bg-success' : 'bg-danger'; ?>">
                                        <?php echo $row['is_half_day'] ? 'Yes' : 'No'; ?>
                                    </span>
                                </p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-1 text-secondary"><strong>Status:</strong> 
                                    <span class="badge rounded-pill px-3 py-2 fw-semibold <?php 
                                        switch ($row['status']) {
                                            case 'Approved': echo 'bg-success'; break;
                                            case 'Pending': echo 'bg-warning text-dark'; break;
                                            case 'Rejected': echo 'bg-danger'; break;
                                            case 'Canceled': echo 'bg-secondary'; break;
                                            case 'Expired': echo 'bg-dark'; break;
                                        } 
                                    ?>">
                                        <?php echo htmlspecialchars($row['status']); ?>
                                    </span>
                                </p>
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
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    }
    #leave_requests_table .badge {
        font-size: 0.85rem;
    }
</style>