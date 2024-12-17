<?php
// table.php
// Expecting $data to be passed from api.php
?>
<style>
#pagination .page-item:hover{
  cursor: pointer;
}
</style>
<!-- Table Rendering -->
<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Job Title</th>
      <th>Department</th>
      <th>Description</th>
      <th>Status</th>
      <th>Created At</th>
      <!-- <th>Created By</th> -->
      <th>Updated At</th>
      <!-- <th>Updated By</th> -->
      <?php if (isset($status) && $status === 'Archived') echo "<th>Deleted At</th>"; ?>
      <?php if (!isset($status) || $status !== 'Archived') echo "<th style='width: 14%'>Action</th>"; ?> 
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($jobTitles)): ?>
      <?php foreach ($jobTitles as $row): ?>
        <tr data-id="<?php echo htmlspecialchars($row['id']); ?>" 
            data-title="<?php echo htmlspecialchars($row['title']); ?>" 
            data-department-id="<?php echo htmlspecialchars($row['department_id']); ?>" 
            data-department-name="<?php echo htmlspecialchars($row['department_name']); ?>" 
            data-description="<?php echo htmlspecialchars($row['description']); ?>" 
            data-status="<?php echo htmlspecialchars($row['status']); ?>">
          <td><?php echo htmlspecialchars($row['title']); ?></td>
          <td><?php echo htmlspecialchars($row['department_name']); ?></td>
          <td><?php echo htmlspecialchars($row['description']); ?></td>
          <td><span class="badge 
          <?php 
          if($row['status'] === "Active"){
            echo "bg-label-primary";
          }else if($row['status'] === "Inctive"){
            echo "bg-label-warning";
          }else{
            echo "bg-label-danger";
          }
          
          ?> me-1"><?php echo htmlspecialchars($row['status']); ?></td>
          <td><?php echo htmlspecialchars($row['created_at']); ?></td>
          <!-- <td><?php //echo htmlspecialchars($row['created_by']); ?></td> -->
          <td><?php echo htmlspecialchars($row['updated_at']); ?></td>
          <!-- <td><?php //echo htmlspecialchars($row['updated_by']); ?></td> -->
          <?php if (isset($status) && $status === 'Archived') echo "<td>" . htmlspecialchars($row['deleted_at']) . "</td>"; ?>
          <!-- <?php //if (isset($status) && $status === 'Archived') echo "<td>" . htmlspecialchars($row['deleted_by']) . "</td>"; ?> -->
          <?php if (!isset($status) || $status !== 'Archived') echo
            '<td>
              <button class="btn btn-info" title="Click to Edit" onclick="updateJobTitleClick(this)" data-bs-toggle="modal" data-bs-target="#update_job_titles_modal"> 
                <i class="bx bx-edit-alt"></i>
              </button> 
              <button class="btn btn-danger" title="Click to Delete" onclick="confirmDeleteJobTitle(this)">
                <i class="bx bx-trash"></i>
              </button> 
            </td>';
          ?>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="10">No data available</td>
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
        <a class="page-link" onclick="fetchAllJobTitles('prev')" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <!-- Page Numbers -->
        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
          <a class="page-link" onclick="fetchAllJobTitles(<?php echo $i ?>)" ><?= $i ?></a>
        </li>
      <?php endfor; ?>
      <!-- Next Button -->
      <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
        <a class="page-link" onclick="fetchAllJobTitles('next')" aria-label="Next">
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