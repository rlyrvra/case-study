<?php require_once __DIR__ . '/../../includes/header.php'; ?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- font-awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="ajax-requests.js?v=1.1"></script>


<body>
    <div class="container mt-5">
    <h2>Assign Allowance</h2>
    </div>
    


    <div class="container mt-5">
        <?php  include __DIR__ . '/allowanceDynamic.php'; ?>
        <div class="container mb-5">
            <label class="form-label">Employee Id</label>
            <input type="number" id="employee_id" class="form-control" placeholder="Enter text">
        </div>
        <div class="container mb-5">
            <!-- Button to add new allowance row -->
            <button type="button" class="btn btn-primary" onclick="addAllowanceRow()">Add Allowance</button>
            <button type="button" class="btn btn-primary" onclick="getAllowanceValues()">Get Allowance Values</button>
            <button type="button" class="btn btn-primary" onclick="createEmployeeAllowance()">Assign Allowance</button>
            <button type="button" class="btn btn-primary" onclick="fetchAllEmployeeAllowances()">Fetch Employee Allowances</button>
        </div>
        <div id="allowanceOutput">

        </div>
        <!-- Table for allowances -->
        <table id="allowanceTable" class="table">
        <thead>
        <tr>
            <th>Allowance</th>
            <th>Amount</th>
            <th>Action</th>
        </tr>
        </thead>
            <tbody id="allowanceTableBody">
            <!-- Rows will be added dynamically here -->
            </tbody>
        </table>

        <div class="mb-3" id="job_title_preview">

        </div>
        <div class="container">
            <h2>Employee Allowance Table</h2>
        </div>
        <div class="mb-3" id="">
            <table id="employee_allowance_table" class="table">
            <thead>
            <tr>
                <th>Allowance</th>
                <th>Amount</th>
                <th>Action</th>
            </tr>
            </thead>
                <tbody id="employeeAllowanceTableBody">
                <!-- Rows will be added dynamically here -->
                </tbody>
            </table>
        </div>
    </div>
</body>
