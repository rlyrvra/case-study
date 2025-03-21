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
      <th style='width: 1%;'>#</th>
      <th>Date</th>
      <th>Day of Week</th>
      <th>Check In Time</th>
      <th>Check Out Time</th>
      <th>Break Records</th>
      <th>Total Break Duration</th>
      <th>Total Hours Worked</th>
      <th>Late Check In</th>
      <th>Early Check Out</th>
      <th>Overtime Hours</th>
      <th>Overtime Approval</th>
      <th>Status</th>
      <th>Remarks</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($myAttendance)): ?>
      <?php $i = ($offset + 1); foreach ($myAttendance as $row): ?>
        <tr>
          <td><?php echo htmlspecialchars($i); $i++;?></td>
          <td>
            <span class="badge bg-label-primary"><?php echo htmlspecialchars(date("F j, Y", strtotime($row['date']))); ?></span>
          </td>
          <td>
            <?php echo htmlspecialchars(date("l", strtotime($row['date']))); ?>
          </td>
          <td>
            <?php echo !empty($row['check_in_time']) ? htmlspecialchars(date("h:i:s A", strtotime($row['check_in_time']))) : ''; ?>
          </td>
          <td>
            <?php echo !empty($row['check_out_time']) ? htmlspecialchars(date("h:i:s A", strtotime($row['check_out_time']))) : ''; ?>
          </td>
          <td>
            <button class="btn btn-info" 
              title="See Breaks..." 
              data-bs-toggle="modal" 
              data-bs-target="#A<?php echo htmlspecialchars($row['id']); ?>"> 
                  <i class="bx bx-time"></i></button>
              <?php include __DIR__ . '/attendance-modal-breaks-table.php'; ?>
          </td>
          <td><?php echo htmlspecialchars($row['total_break_duration_in_minutes']); ?></td>
          <td><?php echo htmlspecialchars($row['total_hours_worked']); ?></td>
          <td><?php echo htmlspecialchars($row['late_check_in']); ?></td>
          <td><?php echo htmlspecialchars($row['early_check_out']); ?></td>
          <td><?php echo htmlspecialchars($row['overtime_hours']); ?></td>
          <td>
            <span class="badge badge center
            <?php 
                if($row['is_overtime_approved'] == 0) echo "bg-danger";
                if($row['is_overtime_approved'] == 1) echo "bg-success";
                ?>"><?php 
                if($row['is_overtime_approved'] == 0) echo "No";
                if($row['is_overtime_approved'] == 1) echo "Yes";
            ?></span>
          </td>
          <td><span class="badge 
          <?php 
          if(isset($row['attendance_status'])){
            switch($row['attendance_status']){
                case 'Present':
                    echo "bg-label-success";
                    break;
                case 'Late':
                    echo "bg-label-warning";
                    break;
                case 'Absent':
                    echo "bg-label-danger";
                    break;
                case 'Overtime':
                    echo "bg-label-primary";
                    break;
                case 'Undertime':
                    echo "bg-label-dark";
                    break;
            }
          }
          ?> me-1"><?php echo htmlspecialchars($row['attendance_status']); ?></span>
          </td>
          <?php if (isset($actionsMode) && $actionsMode === 'Actions'): ?>
            <td><?php echo htmlspecialchars(date("l, F j, Y, g:i A", strtotime($row['created_at']))); ?></td>
            <td><?php echo htmlspecialchars(date("l, F j, Y, g:i A", strtotime($row['updated_at']))); ?></td>
            <?php if (isset($status) && $status === 'Archived') echo "<td>" . htmlspecialchars(date("l, F j, Y, g:i A", strtotime($row['deleted_at']))) . "</td>"; ?>
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
          <?php endif ?>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="7">No data available</td>
      </tr>
    <?php endif; ?>
  </tbody>
  <tfoot class="table-border-bottom-0">
      <th style='width: 1%;'>#</th>
      <th>Date</th>
      <th>Day of Week</th>
      <th>Check In Time</th>
      <th>Check Out Time</th>
      <th>Break Records</th>
      <th>Total Break Duration</th>
      <th>Total Hours Worked</th>
      <th>Late Check In</th>
      <th>Early Check Out</th>
      <th>Overtime Hours</th>
      <th>Overtime Approval</th>
      <th>Status</th>
      <th>Remarks</th>
  </tfoot>
</table>


<!-- Pagination Block (Placed after the table) -->
<div class="container mt-5" id="pagination">
  <nav aria-label="Page navigation" class="d-flex justify-content-center">
    <ul class="pagination pagination-lg">
      <!-- Previous Button -->
      <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
        <a class="page-link" onclick="fetchAllMyAttendance('prev')" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>

      <!-- First Page -->
      <li class="page-item <?= $page === 1 ? 'active' : '' ?>">
        <a class="page-link" onclick="fetchAllMyAttendance(1)">1</a>
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
          <a class="page-link" onclick="fetchAllMyAttendance(<?php echo $i ?>)"><?= $i ?></a>
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
          <a class="page-link" onclick="fetchAllMyAttendance(<?= $totalPages ?>)"><?= $totalPages ?></a>
        </li>
      <?php endif; ?>

      <!-- Next Button -->
      <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
        <a class="page-link" onclick="fetchAllMyAttendance('next')" aria-label="Next">
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