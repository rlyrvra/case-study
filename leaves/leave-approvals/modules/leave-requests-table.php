<table id="leavesTable" class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
            <th>Profile</th>
            <th>Requester</th>
            <th>Department</th>
            <th>Type</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Half Day</th>
            <th>Half Day Part</th>
            <th>Status</th>
            <th>Review</th>
        </tr>
    </thead>
    <tbody>
    <?php if (!empty($leaveRequests)): ?>
        <?php foreach ($leaveRequests as $row): ?>
        <tr>
            <td>
            <?php 
                if(!isset($row['employee_profile_picture'])){
                    echo "<img src='https://via.placeholder.com/50' alt='Profile Picture' class='w-px-50 h-auto rounded-circle' />";
                    return;
                }
                // Render the image
                $imageData = $row['employee_profile_picture'];

                echo "<img src='data:image/jpg;base64,$imageData' alt='Profile Picture' class='w-px-50 h-auto rounded-circle' />";
            ?>
            </td>
            <td>
              <?php echo htmlspecialchars($row['employee_full_name']); ?>
            </td>
            <td>
              <?php echo htmlspecialchars($row['employee_department_name']); ?>
            </td>
            <td>
              <?php echo htmlspecialchars($row['leave_type_name']); ?>
            </td>
            <td>
              <?php echo htmlspecialchars($row['start_date']); ?>
            </td>
            <td>
              <?php echo htmlspecialchars($row['end_date']); ?>
            </td>
            <td>
              <span class="badge badge center 
              <?php 
              if($row['is_half_day'] == 0) echo "bg-danger";
              if($row['is_half_day'] == 1) echo "bg-success";
              ?>"><?php 
              if($row['is_half_day'] == 0) echo "No";
              if($row['is_half_day'] == 1) echo "Yes";
              ?></span>
            </td>
            <td>
              <?php echo htmlspecialchars($row['half_day_part']); ?>
            </td>
            <td><span class="badge
            <?php 
            if($row['status'] === "Approved"){
                echo "bg-success";
            }else if($row['status'] === "Pending"){
                echo "bg-label-warning";
            }else if($row['status'] === "Rejected"){
                echo "bg-label-danger";
            }else if($row['status'] === "Canceled"){
                echo "bg-label-secondary";
            }else if($row['status'] === "Expired"){
                echo "bg-label-dark";
            }else{

            }
            ?>"><?php echo htmlspecialchars($row['status']); ?></span>
            </td>
            <td>
            <?php if(!($row['status'] === "Approved" || 
            $row['status'] === "Expired" || 
            $row['status'] === "Completed" || 
            $row['status'] === "In Progress" ||
            $row['status'] === "Canceled")): ?>
            <button class="btn btn-info" 
              title="See Reason..." 
              data-bs-toggle="modal" 
              data-bs-target="#R<?php echo htmlspecialchars($row['id']); ?>"> 
                  <i class="bx bx-edit-alt"></i>
            </button> 
            <?php endif; ?>
            <?php if($row['status'] === "Approved" || 
            $row['status'] === "Expired" || 
            $row['status'] === "Completed" || 
            $row['status'] === "In Progress" ||
            $row['status'] === "Canceled") continue; ?>
            <?php include __DIR__ . '/leave-requests-modal-reason.php'; ?>
            </td>
        </tr>
        <!-- Additional rows can be added dynamically from the database -->
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="7" class="text-center">No data available</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

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
    .page-item:hover:not(.disabled){
        cursor: pointer !important;
    }
</style>