
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
      <th>Pay Frequency</th>
      <th>Cut Off</th>
      <th>Payday Offset</th>
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
  <?php
    function findNamedDay($dayNumber){
      switch($dayNumber){
        case 1:
          return "Monday";
        case 2:
          return "Tuesday";
        case 3:
          return "Wednesday";
        case 4:
          return "Thursday";
        case 5:
          return "Friday";
        case 6:
          return "Saturday";
        case 7:
          return "Sunday";
        default:
          //do nothing
      }
    }
  ?>
  <tbody>
    <?php if (!empty($payrollGroups)): ?>
      <?php $i = 1; foreach ($payrollGroups as $row): ?>
        <tr data-id="<?php echo htmlspecialchars($row['id']); ?>" 
            data-name="<?php echo htmlspecialchars($row['name']); ?>" 
            data-payfreq="<?php echo htmlspecialchars($row['payroll_frequency']); ?>" 
            data-weekly-cutoff="<?php echo htmlspecialchars($row['day_of_weekly_cutoff']); ?>" 
            data-biweekly-cutoff="<?php echo htmlspecialchars($row['day_of_biweekly_cutoff']); ?>"
            data-semimonthly-first-cutoff="<?php echo htmlspecialchars($row['semi_monthly_first_cutoff']); ?>"
            data-semimonthly-second-cutoff="<?php echo htmlspecialchars($row['semi_monthly_second_cutoff']); ?>"
            data-payday-offset="<?php echo htmlspecialchars($row['payday_offset']); ?>" 
            data-status="<?php echo htmlspecialchars($row['status']); ?>">
          <!-- <td><?php //echo htmlspecialchars($row['id']); ?></td> -->
          <!-- <td><?php //echo htmlspecialchars($i); ?></td> -->
          <td><?php echo htmlspecialchars($row['name']); ?></td>
          <td><?php echo htmlspecialchars($row['payroll_frequency']); ?></td>
          <td>
            <?php
            
            if($row['payroll_frequency'] === 'Weekly' || $row['payroll_frequency'] === 'Bi-weekly'){
              echo htmlspecialchars(findNamedDay($row['day_of_weekly_cutoff']));
            }else if($row['payroll_frequency'] === 'Semi-monthly'){
              echo htmlspecialchars("Every " . $row['semi_monthly_first_cutoff'] . " and " . $row['semi_monthly_second_cutoff'] . " of the month");
            }else{
              //do nothing
            }

            
            ?>
          </td>
          <td><?php echo htmlspecialchars($row['payday_offset']); ?></td>
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
              <button class="btn btn-info" title="Click to Edit" onclick="updateHolidayClick(this)" data-bs-toggle="modal" data-bs-target="#update-holidays-modal"> 
                <i class="bx bx-edit-alt"></i>
              </button> 
              <button class="btn btn-danger" title="Click to Delete" onclick="confirmDeleteHoliday(this)">
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
        <a class="page-link" onclick="fetchAllPayrollGroups('prev')" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <!-- Page Numbers -->
        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
          <a class="page-link" onclick="fetchAllPayrollGroups(<?php echo $i ?>)" ><?= $i ?></a>
        </li>
      <?php endfor; ?>
      <!-- Next Button -->
      <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
        <a class="page-link" onclick="fetchAllPayrollGroups('next')" aria-label="Next">
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