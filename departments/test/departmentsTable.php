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
      <th>department_id</th>
      <th>description</th>
      <th>status</th>
      <th>Created At</th>
      <th>Created By</th>
      <th>Updated At</th>
      <th>Updated By</th>
      <?php if ($status === "Archived") echo "<th>Deleted At</th>"; ?>
      <?php if ($status === "Archived") echo "<th>Deleted By</th>"; ?>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($departments)): ?>
      <?php foreach ($departments as $row): ?>
        <tr>
          <td><?php echo htmlspecialchars($row['id']); ?></td>
          <td><?php echo htmlspecialchars($row['name']); ?></td>
          <td><?php echo htmlspecialchars($row['department_head_id']); ?></td>
          <td><?php echo htmlspecialchars($row['description']); ?></td>
          <td><?php echo htmlspecialchars($row['status']); ?></td>
          <td><?php echo htmlspecialchars($row['created_at']); ?></td>
          <td><?php echo htmlspecialchars($row['created_by']); ?></td>
          <td><?php echo htmlspecialchars($row['updated_at']); ?></td>
          <td><?php echo htmlspecialchars($row['updated_by']); ?></td>
          <?php if ($status === "Archived") echo "<td>" . htmlspecialchars($row['deleted_at']) . "</td>"; ?>
          <?php if ($status === "Archived") echo "<td>" . htmlspecialchars($row['deleted_by']) . "</td>"; ?>
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