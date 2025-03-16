<?php $i = 0; if (!empty($employees)): ?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($employees as $row): ?>
            <?php
            // Assign colors based on role
            $roleColors = [
                'Admin' => 'bg-danger', // Red
                'Manager' => 'bg-warning', // Yellow
                'Employee' => 'bg-success', // Green
                'Intern' => 'bg-info' // Blue
            ];
            $role = htmlspecialchars($row['access_role']);
            $roleBadge = isset($roleColors[$role]) ? $roleColors[$role] : 'bg-secondary'; // Default gray
            ?>
            <div class="col">
                <div class="card border-0 p-3 shadow-sm transition-shadow hover-shadow-lg">
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            <?php
                            if (!isset($row['profile_picture']) || empty($row['profile_picture'])) {
                                echo "<img src='https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&s=200' alt='Profile Picture' class='rounded-circle border' width='80' height='80'>";
                            } else {
                                echo "<img src='data:image/jpg;base64," . htmlspecialchars($row['profile_picture']) . "' alt='Profile Picture' class='rounded-circle border' width='80' height='80'>";
                            }
                            ?>
                        </div>
                        <div>
                            <h5 class="mb-1"><?php echo htmlspecialchars($row['full_name']); ?></h5>
                            <p class="text-muted mb-1"><?php echo htmlspecialchars($row['job_title_title']); ?></p>
                            <span class="badge <?php echo $roleBadge; ?>"><?php echo $role; ?></span>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <small class="text-muted">Email</small>
                            <div class="text-black"><?php echo htmlspecialchars($row['email_address']); ?></div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted">Employee Code</small>
                            <div class="text-black"><?php echo htmlspecialchars($row['employee_code']); ?></div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <small class="text-muted">Phone</small>
                            <div class="text-black"><?php echo htmlspecialchars($row['phone_number']); ?></div>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Hire Date</small>
                            <div class="text-black"><?php echo htmlspecialchars($row['date_of_hire']); ?></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="text-muted">#<?php echo ++$i; ?></span>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="add-employee?m=v&token=<?php echo htmlspecialchars(hash('sha256', $row['id'])); ?>"><i class="bx bx-user"></i> View</a></li>
                                <li><a class="dropdown-item" href="add-employee?m=u&token=<?php echo htmlspecialchars(hash('sha256', $row['id'])); ?>"><i class="bx bx-edit-alt"></i> Edit</a></li>
                                <li><a class="dropdown-item text-danger" href="#" onclick="confirmDeleteEmployee(this)" data-id="<?php echo htmlspecialchars($row['id']); ?>"><i class="bx bx-trash"></i> Delete</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="my-5 alert alert-danger text-center">No employee records available.</div>
<?php endif; ?>




<!-- Pagination Block (Placed after the table) -->
<div class="container mt-5" id="pagination">
  <nav aria-label="Page navigation" class="d-flex justify-content-center">
    <ul class="pagination pagination-lg">
      <!-- Previous Button -->
      <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
        <a class="page-link" onclick="fetchAllEmployees('prev')" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>

      <!-- First Page -->
      <li class="page-item <?= $page === 1 ? 'active' : '' ?>">
        <a class="page-link" onclick="fetchAllEmployees(1)">1</a>
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
          <a class="page-link" onclick="fetchAllEmployees(<?php echo $i ?>)"><?= $i ?></a>
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
          <a class="page-link" onclick="fetchAllEmployees(<?= $totalPages ?>)"><?= $totalPages ?></a>
        </li>
      <?php endif; ?>

      <!-- Next Button -->
      <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
        <a class="page-link" onclick="fetchAllEmployees('next')" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>
</div>
<style>
    .page-item:hover{
        cursor: pointer !important;
    }
</style>