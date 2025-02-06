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


<!-- Select2 JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<!-- Scripts -->
<script src="leave-entitlement-scripts.js?v1.2"></script>
<script src="ajax-requests.js?v1.1"></script>
<body>
    <div id="responseTest"></div> 
    <?php include __DIR__ . '/leaveEntitlementModal.php'; ?> 
    <div class="container mt-3">
        <div class="mb-3">
            <label for="select_Employee" class="form-label">Employee:</label>
            <select class="form-select" id="select_Employee" name="select_Employee" placeholder="Select Employee" require>
            </select>
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#leaveEntitlementModal">Assign Leave</button>
        <button type="button" class="btn btn-primary" onclick="fetchEmployeeLeaves()">Fetch Employee Credits</button>
        <div class="mt-3">
            <h3>Leave Credits of Employee</h3>
            <div id="employee-leave-credits-table">
            <?php include __DIR__ . '/employeeLeaveTable.php'; ?>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/fetchLeaveTypes.php'; ?>
    <?php include __DIR__ . '/fetchEmployees.php'; ?>
    <script>
        populateSelectEmployee(document.getElementById("select_Employee"));
    </script>
</body>