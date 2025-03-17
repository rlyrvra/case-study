<?php
// modern-cards.php
?>
<style>
  .holiday-card {
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease-in-out;
    padding: 20px;
    background: white;
  }

  .holiday-card:hover {
    transform: scale(1.02);
  }

  .holiday-card h5 {
    font-weight: bold;
    margin-bottom: 5px;
  }

  .holiday-card .card-info {
    font-size: 14px;
    color: #555;
  }

  .holiday-card .status-badge {
    font-size: 14px;
    padding: 6px 12px;
    border-radius: 20px;
  }

  .holiday-card .card-actions {
    display: flex;
    gap: 10px;
  }

  .grid-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
  }
</style>

<div class="grid-container">
  <?php if (!empty($holidays)): ?>
    <?php foreach ($holidays as $row): ?>
      <div class="holiday-card">
        <h5><?= htmlspecialchars($row['name']); ?></h5>
        <p class="card-info"><strong>Start:</strong> <?= htmlspecialchars($row['start_date']); ?></p>
        <p class="card-info"><strong>End:</strong> <?= htmlspecialchars($row['end_date']); ?></p>
        
        <p class="card-info">
          <strong>Paid:</strong> 
          <span class="badge <?= $row['is_paid'] ? 'bg-success' : 'bg-danger'; ?> status-badge">
            <?= $row['is_paid'] ? 'Yes' : 'No'; ?>
          </span>
        </p>

        <p class="card-info">
          <strong>Recurring:</strong> 
          <span class="badge <?= $row['is_recurring_annually'] ? 'bg-success' : 'bg-danger'; ?> status-badge">
            <?= $row['is_recurring_annually'] ? 'Yes' : 'No'; ?>
          </span>
        </p>

        <p class="card-info"><strong>Description:</strong> <?= htmlspecialchars($row['description']); ?></p>

        <p class="card-info">
          <strong>Status:</strong> 
          <span class="badge 
            <?= ($row['status'] === "Active") ? 'bg-primary' : (($row['status'] === "Inactive") ? 'bg-warning' : 'bg-danger'); ?> status-badge">
            <?= htmlspecialchars($row['status']); ?>
          </span>
        </p>

        <p class="card-info"><strong>Created:</strong> <?= htmlspecialchars(date("F j, Y, g:i A", strtotime($row['created_at']))); ?></p>

        <div class="card-actions">
          <button class="btn btn-info btn-sm" title="Edit" onclick="updateHolidayClick(this)" data-bs-toggle="modal" data-bs-target="#update-holidays-modal">
            <i class="bx bx-edit-alt"></i> Edit
          </button>
          <button class="btn btn-danger btn-sm" title="Delete" onclick="confirmDeleteHoliday(this)">
            <i class="bx bx-trash"></i> Delete
          </button>
        </div>
      </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p class="text-center text-muted">No holidays available</p>
  <?php endif; ?>
</div>


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