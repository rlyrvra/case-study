<table id="leavesTable" class="table table-bordered table-hover table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Type</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    <?php $i = 0; if (!empty($employeeLeaveRequests)): ?>
        <?php foreach ($employeeLeaveRequests as $row): ?>
        <tr 
        data-token="<?php echo htmlspecialchars($row['leave_type_id']); ?>"
        data-leave-type-name="<?php echo htmlspecialchars($row['leave_type_name']); ?>"
        data-start-date="<?php echo htmlspecialchars($row['start_date']); ?>"
        data-end-date="<?php echo htmlspecialchars($row['end_date']); ?>"
        data-reason="<?php echo htmlspecialchars($row['reason']); ?>"
        >
            <td><?php $i++; echo $i;?></td>
            <td><?php echo htmlspecialchars($row['leave_type_name']); ?></td>
            <td><?php echo htmlspecialchars($row['start_date']); ?></td>
            <td><?php echo htmlspecialchars($row['end_date']); ?></td>
            <td><?php echo htmlspecialchars($row['reason']); ?></td>
            <td><span class="badge 
            <?php 
            switch($row['status']){
              case 'Approved': echo htmlspecialchars("bg-success"); break;
              case 'Pending': echo htmlspecialchars("bg-label-warning"); break;
              case 'Rejected': echo htmlspecialchars("bg-label-danger"); break;
              case 'Canceled': echo htmlspecialchars("bg-label-secondary"); break;
              case 'Expired': echo htmlspecialchars("bg-label-dark"); break;
              default: echo htmlspecialchars("bg-label-warning"); break;
            }
            ?>"><?php echo htmlspecialchars($row['status']); ?></span></td>
            <td><?php 
            $button = '';
            if($row['status'] === "Pending"){
                $button .= '
                <button 
                class="btn btn-primary dropdown-toggle" 
                type="button" 
                data-bs-toggle="dropdown" 
                aria-expanded="false">
                    Actions
                </button>
                <ul class="dropdown-menu">
                    <!--<li><a class="dropdown-item" href="#" onclick="updateLeaveRequestClick(this)"><i class="bx bx-edit-alt"></i> Edit</a></li>-->
                    <li><a class="dropdown-item" href="#" data-token="'. $row['id'] .'" onclick="deleteLeaveRequest(this)"><i class="bx bx-trash"></i> Delete</a></li>
                    <li><a class="dropdown-item" href="#" data-token="'. $row['id'] .'" onclick="cancelLeaveRequest(this)"><i class="bx bx-x"></i> Cancel</a></li>
                </ul>';
            }
            echo $button;
            ?></td>
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
        <a class="page-link" onclick="fetchLeaveRequests('prev')" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>

      <!-- First Page -->
      <li class="page-item <?= $page === 1 ? 'active' : '' ?>">
        <a class="page-link" onclick="fetchLeaveRequests(1)">1</a>
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
          <a class="page-link" onclick="fetchLeaveRequests(<?php echo $i ?>)"><?= $i ?></a>
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
          <a class="page-link" onclick="fetchLeaveRequests(<?= $totalPages ?>)"><?= $totalPages ?></a>
        </li>
      <?php endif; ?>

      <!-- Next Button -->
      <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
        <a class="page-link" onclick="fetchLeaveRequests('next')" aria-label="Next">
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