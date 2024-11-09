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
<!-- Scripts -->
<script src="ajax-requests.js?v1.2"></script>
<body>
    <div id="responseTest"></div>
    <?php include_once __DIR__ . '/leaveTypeUpdateFormModal.php'; ?> 
    <?php include_once __DIR__ . '/sortFilter.php'; ?> 
    <div class="container mt-3">
        <h2>Add Leave Types</h2>
        <form id="leave_type_form" onsubmit="event.preventDefault()">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter name">
            </div>
            
            <div class="mb-3">
                <label for="maximum_number_of_days" class="form-label">Maximum Number of Days</label>
                <input type="number" class="form-control" id="maximum_number_of_days" placeholder="Enter number of days">
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_paid">
                <label class="form-check-label" for="is_paid">Is Paid</label>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" rows="3" placeholder="Enter description"></textarea>
            </div>
            
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
                <option value="Archived">Archived</option>
                </select>
            </div>
            
            <button class="btn btn-primary" onclick="createLeaveType()">Submit</button>
        </form>
    </div>
    <div class="container mt-3">
        <!-- <button class="btn btn-primary" onclick="fetchAll()">Fetch Table</button> -->
    </div> 
    <div id="leave-types-table" class="container mt-3">
        
    </div> 
    <script>
        fetchAllSort();
    </script>
</body>
