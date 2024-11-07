<?php
// table.php
// Expecting $data to be passed from api.php
?>
<style>

</style>
<!-- Table Rendering -->
<table border="1" class="table" id="myTable">
  <thead>
    <tr>
      <th>id</th>
      <th>name</th>
      <th>amount</th>
      <th>is_taxable</th>
      <th>frequency</th>
      <th>description</th>
      <th>status</th>
      <th>created_at</th>
      <th>pdated_at</th>
      <?php //if ($status === "Archived") echo "<th>Deleted At</th>"; ?>
      <?php //if ($status === "Archived") echo "<th>Deleted By</th>"; ?>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($allowances)): ?>
      <?php foreach ($allowances as $row): ?>
        <tr>
          <td><?php echo htmlspecialchars($row['id']); ?></td>
          <td><?php echo htmlspecialchars($row['name']); ?></td>
          <td><?php echo htmlspecialchars($row['amount']); ?></td>
          <td><?php echo htmlspecialchars($row['is_taxable']); ?></td>
          <td><?php echo htmlspecialchars($row['frequency']); ?></td>
          <td><?php echo htmlspecialchars($row['description']); ?></td>
          <td><?php echo htmlspecialchars($row['status']); ?></td>
          <td><?php echo htmlspecialchars($row['created_at']); ?></td>
          <td><?php echo htmlspecialchars($row['updated_at']); ?></td>
          <!--
          onclick="updateDepartment(<?php //echo md5(htmlspecialchars($row['id'])) ?>)">
          onclick="deleteDepartment(<?php //echo md5(htmlspecialchars($row['id'])) ?>)"
          <?php //if ($status === "Archived") echo "<td>" . htmlspecialchars($row['deleted_at']) . "</td>"; ?>
          <?php //if ($status === "Archived") echo "<td>" . htmlspecialchars($row['deleted_by']) . "</td>"; ?>
          -->
          <td>
            <a class="btn btn-warning" title="Click to Edit"><i class="fa-solid fa-user-pen"></i></a> 
            <a class="btn btn-danger" title="Click to Delete"><i class="fa-solid fa-user-times"></i></a> 
          </td>
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
<div class="container mt-5">
  <nav aria-label="Page navigation example">
    <ul class="pagination">
      <!-- Previous Button -->
      <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
        <a class="page-link" href="?page=<?= max(1, $page - 1) ?>" aria-label="Previous">
          <span aria-hidden="true">&laquo;</span>
        </a>
      </li>
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <!-- Page Numbers -->
        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
          <a class="page-link" onclick="fetchAllSort(<?php echo $page ?>)" ><?= $i ?></a>
        </li>
      <?php endfor; ?>
      <!-- Next Button -->
      <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
        <a class="page-link" href="?page=<?= min($totalPages, $page + 1) ?>" aria-label="Next">
          <span aria-hidden="true">&raquo;</span>
        </a>
      </li>
    </ul>
  </nav>
</div>