<?php require_once __DIR__ . '/../../../includes/header.php'; ?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- font-awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Bootstrap JS (optional for dropdowns, etc.) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<body>
<!-- Bootstrap Modal Structure -->
<div class="modal fade" id="leaveTypeUpdateModal" tabindex="-1" aria-labelledby="leaveTypeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="leaveTypeModalLabel">Leave Type Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="leave_type_form" onsubmit="event.preventDefault()">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="updateName" placeholder="Enter name">
            </div>
            
            <div class="mb-3">
                <label for="maximum_number_of_days" class="form-label">Maximum Number of Days</label>
                <input type="number" class="form-control" id="updateMaximum_number_of_days" placeholder="Enter number of days">
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="updateIs_paid">
                <label class="form-check-label" for="Is_paid">Is Paid</label>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="updateDescription" rows="3" placeholder="Enter description"></textarea>
            </div>
            
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="updateStatus">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
                <option value="Archived">Archived</option>
                </select>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button id="updateLeaveTypeBtn" type="button" class="btn btn-primary" onclick="updateLeaveType(this)" data-bs-dismiss="modal">Update</button>
      </div>
    </div>
  </div>
</div>