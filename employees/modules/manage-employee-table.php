<?php if (!empty($employees)): ?>
    <?php foreach ($employees as $row): ?>
<div class="card p-3 col-auto mx-3 my-3">
    <div class="d-flex justify-content-between align-items-center"
    data-id="<?php echo htmlspecialchars($row['id']); ?>"
    >
        <div class="d-flex align-items-center">
            <div class="placeholder-img"><img src="assets/img/avatars/1.png" alt="Profile Picture" class="w-px-100 h-auto rounded-circle"></div>
            <div class="ms-3">
            <p class="mb-1"><strong>Name: <?php echo htmlspecialchars($row['full_name']); ?></strong></p>
            <p class="mb-1"><strong>Job Title: <?php echo htmlspecialchars($row['job_title_title']); ?></strong></p>
            <p class="mb-1"><strong>Role: <?php echo htmlspecialchars($row['access_role']); ?></strong></p>
            <p class="mb-0"><strong>Department: <?php echo htmlspecialchars($row['department_name']); ?></strong></p>
            </div>
        </div>
        <button 
        class="btn btn-success dropdown-toggle" 
        type="button" 
        data-bs-toggle="dropdown" 
        aria-expanded="false">
            Actions
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#"><i class="bx bx-user"></i>View</a></li>
            <li><a class="dropdown-item" href="#"><i class="bx bx-edit-alt"></i>Edit</a></li>
            <li><a class="dropdown-item" href="#"><i class="bx bx-trash"></i>Delete</a></li>
        </ul>
        </div>
        <hr class="mt-4 mb-4">
        <div class="row">
        <div class="col-md-6 mb-3">
            <label><strong>Email Address:</strong></label>
            <div class="border p-2"><?php echo htmlspecialchars($row['email_address']); ?></div>
        </div>
        <div class="col-md-6 mb-3">
            <label><strong>Employee Code:</strong></label>
            <div class="border p-2"><?php echo htmlspecialchars($row['employee_code']); ?></div>
        </div>
        <div class="col-md-6">
            <label><strong>Phone Number:</strong></label>
            <div class="border p-2"><?php echo htmlspecialchars($row['phone_number']); ?></div>
        </div>
        <div class="col-md-6">
            <label><strong>Date of Hire:</strong></label>
            <div class="border p-2"><?php echo htmlspecialchars($row['date_of_hire']); ?></div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php else: ?>

<h1 class="display-1 align-text-center">NO RECORDS AVAILABLE</h1>

<?php endif; ?>

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
    .page-item:hover{
        cursor: pointer !important;
    }
</style>