<!-- Card Rendering -->
<div class="container">
  <div class="row">
    <?php $i = ($offset + 1); if (!empty($departments)): ?>
      <?php foreach ($departments as $row): ?>
        <?php $i++; ?>
        <div class="col-md-6 col-lg-4">
          <div class="card shadow-sm mb-4 transition-card">
            <div class="card-body">
              <h5 class="card-title fw-bold"> <?php echo htmlspecialchars($row['name']); ?> </h5>
              <p class="text-muted mb-2"><strong>Department Head:</strong> 
                <?php if (!empty($row['department_head_full_name'])): ?>
                  <?php echo htmlspecialchars($row['department_head_full_name']); ?>
                <?php else: ?>
                  <span class="badge bg-danger">Unassigned</span>
                <?php endif; ?>
              </p>
              <p class="card-text"> <strong>Description:</strong> <?php echo htmlspecialchars($row['description']); ?> </p>
              <p class="mb-2">
                <strong>Status:</strong> 
                <span class="badge 
                  <?php echo $row['status'] === "Active" ? "bg-primary" : ($row['status'] === "Inactive" ? "bg-warning" : "bg-danger"); ?>">
                  <?php echo htmlspecialchars($row['status']); ?>
                </span>
              </p>
              <p class="text-muted small mb-2"> <strong>Created:</strong> <?php echo htmlspecialchars(date("F j, Y, g:i A", strtotime($row['created_at']))); ?> </p>
              <p class="text-muted small mb-3"> <strong>Modified:</strong> <?php echo htmlspecialchars(date("F j, Y, g:i A", strtotime($row['updated_at']))); ?> </p>
              <?php if ($row['status'] !== "Archived"): ?>
              <div class="d-flex gap-2 w-100">
                <table>
                  <tbody>
                  <tr data-id="<?php echo htmlspecialchars($row['id']); ?>"
                    data-name="<?php echo htmlspecialchars($row['name']); ?>"
                    data-dept-head-id="<?php echo htmlspecialchars($row['department_head_id']); ?>"
                    data-department-head-id="<?php echo htmlspecialchars($row['department_head_full_name']); ?>"
                    data-description="<?php echo htmlspecialchars($row['description']); ?>"
                    data-status="<?php echo htmlspecialchars($row['status']); ?>">
                    <td>
                      <button class="btn btn-sm btn-info" title="Edit" onclick="updateDepartmentClick(this)" data-bs-toggle="modal" data-bs-target="#update_departments_modal"> 
                        <i class="bx bx-edit-alt"></i> Edit
                      </button>
                      <button class="btn btn-sm btn-danger" title="Delete" onclick="confirmDeleteDepartment(this)"> 
                        <i class="bx bx-trash"></i> Delete
                      </button>
                      <!-- <span class="text-muted fw-bold" style="float: right;">#<?php echo htmlspecialchars($i); ?></span> -->
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
              <?php endif ?>
            </div>
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

<style>
.transition-card {
  transition: all 0.3s ease-in-out;
}
.transition-card:hover {
  transform: translateY(-5px);
  box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
}
</style>


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

      <!-- First Page -->
      <li class="page-item <?= $page === 1 ? 'active' : '' ?>">
        <a class="page-link" onclick="fetchAllDepartments(1)">1</a>
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
          <a class="page-link" onclick="fetchAllDepartments(<?php echo $i ?>)"><?= $i ?></a>
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
          <a class="page-link" onclick="fetchAllDepartments(<?= $totalPages ?>)"><?= $totalPages ?></a>
        </li>
      <?php endif; ?>

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
  .page-item:hover:not(.disabled) {
    cursor: pointer !important;
  }
</style>