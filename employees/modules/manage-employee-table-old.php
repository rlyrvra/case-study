<?php $i = 0; if (!empty($employees)): ?>
    <?php foreach ($employees as $row): ?>
      <div class="card p-3 col-auto mx-3 my-3">
          <span class="display-6">#<?php $i++; echo $i;  ?></span>
          <hr/>
          <div class="d-flex justify-content-between align-items-center"
          >
              <div class="d-flex align-items-center">
                  <div class="placeholder-img">
                      <?php
                      if(!isset($row['profile_picture']) && empty($row['profile_picture'])){
                          echo "<img src='https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&s=200' alt='Profile Picture' class='w-px-100 h-auto rounded-circle' />";
                      }else{
                          // Render the image
                          $imageData = $row['profile_picture'];

                          echo "<img src='data:image/jpg;base64,$imageData' alt='Profile Picture' class='w-px-100 h-auto rounded-circle' />";
                      }
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
                  <li><a class="dropdown-item" href="add-employee?m=v&token=<?php echo htmlspecialchars(hash('sha256', $row['id']));?>"><i class="bx bx-user"></i> View</a></li>
                  <li><a class="dropdown-item" href="add-employee?m=u&token=<?php echo htmlspecialchars(hash('sha256', $row['id']));?>"><i class="bx bx-edit-alt"></i> Edit</a></li>
                  <li><a class="dropdown-item" href="#" onclick="confirmDeleteEmployee(this)" data-id="<?php echo htmlspecialchars($row['id']); ?>"><i class="bx bx-trash"></i> Delete</a></li>
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

  <div class="alert alert-danger text-center">No employee records available.</div>

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