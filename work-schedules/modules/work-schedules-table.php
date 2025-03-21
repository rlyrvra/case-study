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
      <th>Employee Name</th>
      <th>Start Time</th>
      <th>End Time</th>
      <th>Work Hours</th>
      <!-- <th>Created By</th> -->
      <!-- <th>Updated By</th> -->
      <?php if (isset($status) && $status === 'Archived') echo "<th>Deleted At</th>"; ?>
      <?php //if (isset($status) && $status === 'Archived') echo "<th>Deleted By</th>"; ?>
      <?php if (!isset($status) || $status !== 'Archived') echo "<th style='width: 13%;'>Action</th>"; ?> 
    </tr>
  </thead>
  <tbody>
    <?php $i = $offset;if (!empty($workSchedules)): ?>
      <?php foreach ($workSchedules as $row): ?>
        <tr data-id="<?php echo htmlspecialchars($row['id']); ?>"
        >  
          <td><?php $i++; echo htmlspecialchars($i); ?></td>
          <td><?= highlightText($row['employee_full_name'], $searchFilter); ?></td>
          <td>
            <?php 
            $startTime = $row['start_time']; // Assuming $row['start_time'] contains '1970-01-01 08:00:00'
            echo $row['is_flextime'] ? "<span class='badge bg-primary'>FLEXITIME</span>" : htmlspecialchars(date('g:iA', strtotime($startTime))); // Outputs: 8:00AM 
            ?>
          </td>
          <td>
            <?php 
            $endTime = $row['end_time']; // Assuming $row['start_time'] contains '1970-01-01 08:00:00'
            echo $row['is_flextime'] ? "<span class='badge bg-primary'>FLEXITIME</span>" : htmlspecialchars(date('g:iA', strtotime($endTime))); // Outputs: 8:00AM 
            ?>
          </td>
          <td><?php echo htmlspecialchars($row['total_work_hours']); ?></td>
          <?php if (!isset($status) || $status !== 'Archived'){
            echo
            '<td>
              <button class="btn btn-info" title="Click to Edit" onclick="fetchBreakTypes(); fetchWorkScheduleAndBreak(this);" data-bs-toggle="modal" data-bs-target="#update_work_schedules"> 
                <i class="bx bx-edit-alt"></i>
              </button> 
              <button class="btn btn-danger" title="Click to Delete" onclick="confirmDeleteWorkSchedule(this)">
                <i class="bx bx-trash"></i>
              </button> 
            </td>';
          } else {
            echo "<td>" . htmlspecialchars($row['deleted_at']) . "</td>";
          }
          ?>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr>
        <td colspan="6" style="text-align: center; padding: 20px; color: #888;">No data available</td> 
      </tr>
    <?php endif; ?>
  </tbody>
  <tfoot class="table-border-bottom-0">
      <th style='width: 1%;'>#</th>
      <th>Employee Name</th>
      <th>Start Time</th>
      <th>End Time</th>
      <th>Work Hours</th>
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
        <a class="page-link" onclick="fetchAllWorkSchedules('prev')" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>

      <!-- First Page -->
      <li class="page-item <?= $page === 1 ? 'active' : '' ?>">
        <a class="page-link" onclick="fetchAllWorkSchedules(1)">1</a>
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
          <a class="page-link" onclick="fetchAllWorkSchedules(<?php echo $i ?>)"><?= $i ?></a>
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
          <a class="page-link" onclick="fetchAllWorkSchedules(<?= $totalPages ?>)"><?= $totalPages ?></a>
        </li>
      <?php endif; ?>

      <!-- Next Button -->
      <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
        <a class="page-link" onclick="fetchAllWorkSchedules('next')" aria-label="Next">
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