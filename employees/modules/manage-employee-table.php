<?php if (!empty($employees)): ?>
    <?php foreach ($employees as $row): ?>
<div class="card p-3 col-auto mx-3 my-3">
    <div class="d-flex justify-content-between align-items-center"
    >
        <div class="d-flex align-items-center">
            <div class="placeholder-img">
                <?php
                if(!isset($row['profile_picture']) && !empty($row['profile_picture'])){
                    echo "<img src='https://via.placeholder.com/100' alt='Profile Picture' class='w-px-100 h-auto rounded-circle' />";
                    return;
                }
                // Render the image
                $imageData = $row['profile_picture'];

                echo "<img src='data:image/jpg;base64,$imageData' alt='Profile Picture' class='w-px-100 h-auto rounded-circle' />";
                ?>
            </div>
            <div class="ms-3">
            <p class="mb-1"><strong>Name:</strong> <?php echo htmlspecialchars($row['full_name']); ?></p>
            <p class="mb-1"><strong>Job Title: </strong> <?php echo htmlspecialchars($row['job_title_title']); ?></p>
            <p class="mb-1"><strong>Role: </strong><?php echo htmlspecialchars($row['access_role']); ?></p>
            <p class="mb-0"><strong>Department: </strong><?php echo htmlspecialchars($row['department_name']); ?></p>
            </div>
        </div>
        <button 
        class="btn btn-primary dropdown-toggle" 
        type="button" 
        data-bs-toggle="dropdown" 
        aria-expanded="false">
            Actions
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="add-employee?m=v&token=<?php echo htmlspecialchars(md5($row['id']));?>"><i class="bx bx-user"></i>View</a></li>
            <li><a class="dropdown-item" href="add-employee?m=u&token=<?php echo htmlspecialchars(md5($row['id']));?>"><i class="bx bx-edit-alt"></i>Edit</a></li>
            <li><a class="dropdown-item" href="#" onclick="confirmDeleteEmployee(this)" data-id="<?php echo htmlspecialchars($row['id']); ?>"><i class="bx bx-trash"></i>Delete</a></li>
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

<h1 class="display-1 text-center">NO RECORDS AVAILABLE</h1>

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
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <!-- Page Numbers -->
        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
          <a class="page-link" onclick="fetchAllEmployees(<?php echo $i ?>)" ><?= $i ?></a>
        </li>
      <?php endfor; ?>
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