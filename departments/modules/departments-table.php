<?php
// table.php
// Expecting $data to be passed from api.php
?>
<style>
</style>
<!-- Table Rendering -->
<table class="table table-bordered table-hover table-striped">
  <thead>
    <tr>
      <!-- <th>id</th> -->
      <!-- <th style="width: 2%">NO.</th> -->
      <th style='width: 1%;'>#</th>
      <th>NAME</th>
      <th>DEPARTMENT HEAD</th>
      <th>DESCRIPTION</th>
      <th>STATUS</th>
      <th>DATE CREATED</th>
      <!-- <th>Created By</th> -->
      <th>DATE MODIFIED</th>
      <!-- <th>Updated By</th> -->
      <?php if (isset($status) && $status === 'Archived') echo "<th>Deleted At</th>"; ?>
      <?php //if (isset($status) && $status === 'Archived') echo "<th>Deleted By</th>"; ?>
      <?php if (!isset($status) || $status !== 'Archived') echo "<th style='width: 14%'>Action</th>"; ?> 
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($departments)): ?>
      <?php $i = ($offset + 1); foreach ($departments as $row): ?>
        <tr data-id="<?php echo htmlspecialchars($row['id']); ?>" 
            data-name="<?php echo htmlspecialchars($row['name']); ?>" 
            data-dept-head-id="<?php echo htmlspecialchars($row['department_head_id']); ?>" 
            data-department-head-id="<?php echo htmlspecialchars($row['department_head_full_name']); ?>" 
            data-description="<?php echo htmlspecialchars($row['description']); ?>" 
            data-status="<?php echo htmlspecialchars($row['status']); ?>">
          <!-- <td><?php //echo htmlspecialchars($row['id']); ?></td> -->
          <td><?php echo htmlspecialchars($i); $i++;?></td>
          <td><?php echo htmlspecialchars($row['name']); ?></td>
          <td>
            <?php if (!empty($row['department_head_full_name'])): ?>
              <?php echo htmlspecialchars($row['department_head_full_name']); ?>
            <?php else: ?>
              <span class="badge bg-label-danger">Unassigned</span>
            <?php endif; ?>
          </td>
          <td><?php echo htmlspecialchars($row['description']); ?></td>
          <td><span class="badge 
          <?php 
          if($row['status'] === "Active"){
            echo "bg-label-primary";
          }else if($row['status'] === "Inactive"){
            echo "bg-label-warning";
          }else{
            echo "bg-label-danger";
          }
          
          ?> me-1"><?php echo htmlspecialchars($row['status']); ?></span>
          </td>
          <td><?php echo htmlspecialchars(date("l, F j, Y, g:i A", strtotime($row['created_at']))); ?></td>
          <!-- <td><?php //echo htmlspecialchars($row['created_by']); ?></td> -->
          <td><?php echo htmlspecialchars(date("l, F j, Y, g:i A", strtotime($row['updated_at']))); ?></td>
          <!-- <td><?php //echo htmlspecialchars($row['updated_by']); ?></td> -->
          <?php if (isset($status) && $status === 'Archived') echo "<td>" . htmlspecialchars(date("l, F j, Y, g:i A", strtotime($row['deleted_at']))) . "</td>"; ?>
          <?php //if (isset($status) && $status === 'Archived') echo "<td>" . htmlspecialchars($row['deleted_by']) . "</td>"; ?>
          <?php if (!isset($status) || $status !== 'Archived') echo
            '<td>
              <button class="btn btn-info" title="Click to Edit" onclick="updateDepartmentClick(this)" data-bs-toggle="modal" data-bs-target="#update_departments_modal"> 
                <i class="bx bx-edit-alt"></i>
              </button> 
              <button class="btn btn-danger" title="Click to Delete" onclick="confirmDeleteDepartment(this)">
                <i class="bx bx-trash"></i>
              </button> 
            </td>';
          ?>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="8" style="text-align: center; padding: 20px; font-style: italic; color: #888;">No data available</td>
      </tr>
    <?php endif; ?>
  </tbody>
  <tfoot class="table-border-bottom-0">
      <th style='width: 1%;'>#</th>
      <th>NAME</th>
      <th>DEPARTMENT HEAD</th>
      <th>DESCRIPTION</th>
      <th>STATUS</th>
      <th>Created At</th>
      <!-- <th>Created By</th> -->
      <th>Updated At</th>
      <!-- <th>Updated By</th> -->
      <?php if (isset($status) && $status === 'Archived') echo "<th>Deleted At</th>"; ?>
      <?php //if (isset($status) && $status === 'Archived') echo "<th>Deleted By</th>"; ?>
      <?php if (!isset($status) || $status !== 'Archived') echo "<th style='width: 14%'>Action</th>"; ?> 
  </tfoot>
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