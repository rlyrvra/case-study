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



<!-- Scripts -->
<script src="ajax-requests.js?v1.2"></script>
<script src="fetchAllSort.js?v1.2"></script>
<body>
    <div id="responseTest"></div>
    <?php include_once __DIR__ . '/departmentUpdateFormModal.php'; ?> 
    <h1>Department Management</h1>
    <div class="container mt-5">
    <form onsubmit="event.preventDefault();">
        <!-- Row for Entries, Sort By, Order By -->
        <fieldset class="row mb-3">
            <!-- Number of Entries -->
            <div class="col-md-4">
                <label for="entries" class="form-label">Number of Entries</label>
                <select id="entries" class="form-select">
                    <option value="2" selected>2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>

            <!-- Sort By -->
            <div class="col-md-4">
                <label for="sortBy" class="form-label">Sort By</label>
                <select id="sortBy" class="form-select">
                    <option value="name">Name</option>
                    <option value="created_at" selected>Created At</option>
                    <option value="updated_at">Updated At</option>
                </select>
            </div>

            <!-- Order By -->
            <div class="col-md-4">
                <label for="orderBy" class="form-label">Order By</label>
                <select id="orderBy" class="form-select">
                    <option value="ASC" selected>Ascending</option>
                    <option value="DESC">Descending</option>
                </select>
            </div>
        </fieldset>

        <!-- Filter By Section -->
        <fieldset class="row mb-3">
            <legend>Filter By:</legend>

            <!-- Status -->
            <div class="col-md-4">
                <label for="status" class="form-label">Status</label>
                <select id="status" class="form-select" onchange="toggleDeletedAtOption()">
                    <option value="" selected>All</option>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Archived">Archived</option>
                </select>
            </div>

            <!-- Search At: -->
            <div class="col-md-4">
                <label class="form-label">Search At:</label>
                <div class="row">
                    <div class="col">
                    <select id="searchColumn" class="form-select">
                        <option value="name" selected>Name</option>
                        <option value="description">Description</option>
                    </select>
                    </div>
                    <div class="col">
                        <input type="text" id="searchText" class="form-control" placeholder="Enter text">
                    </div>
                </div>
            </div>

            <!-- Date Modified -->
            <div class="col-md-4">
                <label class="form-label">At Date:</label>
                <div class="row g-1">
                    <div class="col-4">
                        <select id="dateColumn" class="form-select">
                            <option value="none">None</option>
                            <option value="created_at">Date Created</option>
                            <option value="updated_at">Date Modified</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <input type="date" id="dateStart" class="form-control" placeholder="Start Date">
                    </div>
                    <div class="col-4">
                        <input type="date" id="dateEnd" class="form-control" placeholder="End Date">
                    </div>
                </div>
            </div>
        </fieldset>

        <!-- Submit Button -->
        <button onclick="fetchAllSort()" class="btn btn-primary">Apply Filters</button>
    </form>
    </div>

    <button onclick="fetchAllDepartments()">Fetch All Departments</button>
    <div id="departments"></div>
    <div style="font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4;">
        <h2 style="color: #333;">Create New Department</h2>
        <form id="createDepartmentForm" onsubmit="event.preventDefault(); createDepartment();">
            <div>
                <label for="departmentName" style="display: block; margin-bottom: 5px;">Department Name:</label>
                <input type="text" id="createDepartmentName" name="createDepartmentName" required style="padding: 10px; width: 100%; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <div>
                <label for="departmentHeadId" style="display: block; margin-bottom: 5px;">Department Head ID:</label>
                <input type="number" id="createDepartmentHeadId" name="createDepartmentHeadId" style="padding: 10px; width: 100%; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;">
            </div>
            <button type="submit" style="padding: 10px 15px; cursor: pointer; background-color: #007bff; color: white; border: none; border-radius: 4px;">Create Department</button>
        </form>

        <div id="createMessage" style="font-weight: bold;"></div>
    </div>
    
</body>
</html>
