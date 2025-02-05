
<?php
// table.php
// Expecting $data to be passed from api.php
?>
<style>

</style>
<!-- Table Rendering -->
<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <!-- <th>id</th> -->
      <!-- <th style="width: 2%">NO.</th> -->
      <th>Name</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Paid</th>
      <th>Recurring Annually</th>
      <th>Description</th>
      <th>Status</th>
      <th>Created At</th>
      <!-- <th>Created By</th> -->
      <th>Updated At</th>
      <!-- <th>Updated By</th> -->
      <?php if (isset($status) && $status === 'Archived') echo "<th>Deleted At</th>"; ?>
      <?php //if (isset($status) && $status === 'Archived') echo "<th>Deleted By</th>"; ?>
      <?php if (!isset($status) || $status !== 'Archived') echo "<th style='width: 14%'>Action</th>"; ?> 
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($holidays)): ?>
      <?php $i = 1; foreach ($holidays as $row): ?>
        <tr data-id="<?php echo htmlspecialchars($row['id']); ?>" 
            data-name="<?php echo htmlspecialchars($row['name']); ?>" 
            data-start="<?php echo htmlspecialchars($row['start_date']); ?>" 
            data-end="<?php echo htmlspecialchars($row['end_date']); ?>" 
            data-paid="<?php echo htmlspecialchars($row['is_paid']); ?>"
            data-recurring="<?php echo htmlspecialchars($row['is_recurring_annually']); ?>"
            data-description="<?php echo htmlspecialchars($row['description']); ?>"  
            data-status="<?php echo htmlspecialchars($row['status']); ?>">
          <!-- <td><?php //echo htmlspecialchars($row['id']); ?></td> -->
          <!-- <td><?php //echo htmlspecialchars($i); ?></td> -->
          <td><?php echo htmlspecialchars($row['name']); ?></td>
          <td><?php echo htmlspecialchars($row['start_date']); ?></td>
          <td><?php echo htmlspecialchars($row['end_date']); ?></td>
          <td>
            <span class="badge badge center
            <?php 
                if($row['is_paid'] == 0) echo "bg-danger";
                if($row['is_paid'] == 1) echo "bg-success";
                ?>"><?php 
                if($row['is_paid'] == 0) echo "No";
                if($row['is_paid'] == 1) echo "Yes";
            ?></span>
          </td>
          <td>
            <span class="badge badge center
            <?php 
                if($row['is_recurring_annually'] == 0) echo "bg-danger";
                if($row['is_recurring_annually'] == 1) echo "bg-success";
                ?>"><?php 
                if($row['is_recurring_annually'] == 0) echo "No";
                if($row['is_recurring_annually'] == 1) echo "Yes";
            ?></span>
          </td>
          


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
          
          ?> me-1"><?php echo htmlspecialchars($row['status']); ?></span>
          </td>
          <td><?php echo htmlspecialchars($row['created_at']); ?></td>
          <td><?php echo htmlspecialchars($row['updated_at']); ?></td>
          <?php if (isset($status) && $status === 'Archived') echo "<td>" . htmlspecialchars($row['deleted_at']) . "</td>"; ?>
          <?php if (!isset($status) || $status !== 'Archived') echo
            '<td>
              <button class="btn btn-info" title="Click to Edit" onclick="updateAllowanceClick(this)" data-bs-toggle="modal" data-bs-target="#update-allowances-modal"> 
                <i class="bx bx-edit-alt"></i>
              </button> 
              <button class="btn btn-danger" title="Click to Delete" onclick="confirmDeleteAllowance(this)">
                <i class="bx bx-trash"></i>
              </button> 
            </td>';
          ?>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="9" class="text-center">No data available</td>
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
        <a class="page-link" onclick="fetchAllHolidays('prev')" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <!-- Page Numbers -->
        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
          <a class="page-link" onclick="fetchAllHolidays(<?php echo $i ?>)" ><?= $i ?></a>
        </li>
      <?php endfor; ?>
      <!-- Next Button -->
      <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
        <a class="page-link" onclick="fetchAllHolidays('next')" aria-label="Next">
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