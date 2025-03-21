<?php
function highlightText($text, $searchText) {
    if (!empty($searchText)) {
        return preg_replace('/(' . preg_quote($searchText, '/') . ')/i', '<span style="background-color: yellow;">$1</span>', htmlspecialchars($text));
    }
    return htmlspecialchars($text);
}
?>
<style>

</style>
<!-- Table Rendering -->
<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th style='width: 1%;'>#</th>
      <th>Name</th>
      <th>Maximum Number of Days</th>
      <th>Paid</th>
      <th>description</th>
      <th>status</th>
      <th>Date Created</th>
      <!-- <th>Created By</th> -->
      <th>Date Modified</th>
      <!-- <th>Updated By</th> -->
      <?php if (isset($status) && $status === 'Archived') echo "<th>Deleted At</th>"; ?>
      <?php //if (isset($status) && $status === 'Archived') echo "<th>Deleted By</th>"; ?>
      <?php if (!isset($status) || $status !== 'Archived') echo "<th style='width: 13%;'>Action</th>"; ?> 
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($leaveTypes)): ?>
      <?php  $i = ($offset + 1); foreach ($leaveTypes as $row): ?>
        <tr data-id="<?php echo htmlspecialchars($row['id']); ?>" 
            data-name="<?php echo htmlspecialchars($row['name']); ?>" 
            data-maximum-number-of-days="<?php echo htmlspecialchars($row['maximum_number_of_days']); ?>"
            data-is-paid="<?php echo htmlspecialchars($row['is_paid']); ?>" 
            data-is-encashable="<?php echo htmlspecialchars($row['is_encashable']); ?>" 
            data-description="<?php echo htmlspecialchars($row['description']); ?>" 
            data-status="<?php echo htmlspecialchars($row['status']); ?>">
          <td><?php echo htmlspecialchars($i); $i++;?></td>
          <td><?= highlightText($row['name'], $searchFilter); ?></td>
          <td><?php echo htmlspecialchars($row['maximum_number_of_days']); ?></td>
          <td><span class="badge badge center 
          <?php 
          if($row['is_paid'] == 0) echo "bg-danger";
          if($row['is_paid'] == 1) echo "bg-success";
          ?>"><?php 
          if($row['is_paid'] == 0) echo "No";
          if($row['is_paid'] == 1) echo "Yes";
          ?></span></td>
          <td><?= highlightText($row['description'], $searchFilter); ?></td>
          <td><span class="badge 
          <?php 
          if($row['status'] === "Active"){
            echo "bg-label-primary";
          }else if($row['status'] === "Inactive"){
            echo "bg-label-warning";
          }else{
            echo "bg-label-danger";
          }
          
          ?> me-1"><?php echo htmlspecialchars($row['status']); ?></span></td>
          <td><?php echo htmlspecialchars(date("l, F j, Y, g:i A", strtotime($row['created_at']))); ?></td>
          <!-- <td><?php //echo htmlspecialchars($row['created_by']); ?></td> -->
          <td><?php echo htmlspecialchars(date("l, F j, Y, g:i A", strtotime($row['updated_at']))); ?></td>
          <!-- <td><?php //echo htmlspecialchars($row['updated_by']); ?></td> -->
          <?php if (isset($status) && $status === 'Archived') echo "<td>" . htmlspecialchars($row['deleted_at']) . "</td>"; ?>
          <?php //if (isset($status) && $status === 'Archived') echo "<td>" . htmlspecialchars($row['deleted_by']) . "</td>"; ?>
          <?php if (!isset($status) || $status !== 'Archived') echo
            '<td>
              <button class="btn btn-info" title="Click to Edit" onclick="updateLeaveTypeClick(this)" data-bs-toggle="modal" data-bs-target="#update_leave_types_modal"> 
                <i class="bx bx-edit-alt"></i>
              </button> 
              <button class="btn btn-danger" title="Click to Delete" onclick="confirmDeleteLeaveTypes(this)">
                <i class="bx bx-trash"></i>
              </button> 
            </td>';
          ?>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="10" style="text-align: center; padding: 20px; color: #888;">No data available</td> 
      </tr>
    <?php endif; ?>
  </tbody>
  <tfoot class="table-border-bottom-0">
      <th style='width: 1%;'>#</th>
      <th>Name</th>
      <th>Maximum Number of Days</th>
      <th>Paid</th>
      <th>description</th>
      <th>status</th>
      <th>Date Created</th>
      <!-- <th>Created By</th> -->
      <th>Date Modified</th>
      <!-- <th>Updated By</th> -->
      <?php if (isset($status) && $status === 'Archived') echo "<th>Deleted At</th>"; ?>
      <?php //if (isset($status) && $status === 'Archived') echo "<th>Deleted By</th>"; ?>
      <?php if (!isset($status) || $status !== 'Archived') echo "<th style='width: 13%;'>Action</th>"; ?>
  </tfoot>
</table>


<!-- Pagination Block (Placed after the table) -->
<div class="container mt-5" id="pagination">
  <nav aria-label="Page navigation" class="d-flex justify-content-center">
    <ul class="pagination pagination-lg">
      <!-- Previous Button -->
      <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
        <a class="page-link" onclick="fetchAllLeaveTypes('prev')" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>

      <!-- First Page -->
      <li class="page-item <?= $page === 1 ? 'active' : '' ?>">
        <a class="page-link" onclick="fetchAllLeaveTypes(1)">1</a>
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
          <a class="page-link" onclick="fetchAllLeaveTypes(<?php echo $i ?>)"><?= $i ?></a>
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
          <a class="page-link" onclick="fetchAllLeaveTypes(<?= $totalPages ?>)"><?= $totalPages ?></a>
        </li>
      <?php endif; ?>

      <!-- Next Button -->
      <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
        <a class="page-link" onclick="fetchAllLeaveTypes('next')" aria-label="Next">
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