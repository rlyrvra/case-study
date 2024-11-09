<?php require_once __DIR__ . '/../../includes/header.php'; ?>
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
<script>
//select2 js script
// $(document).ready(function() {
//     $('#departmentName').select2({
//         placeholder: 'Select an option',
//         allowClear: true
//     });
// });
</script>
<!-- Scripts -->
<script src="ajax-requests.js?v=1.4"></script>
<title>Job Title Management</title>

<body>
    <?php include_once __DIR__ . '/jobTitleUpdateFormModal.php'; ?>
    <div id="responseTest"></div>
    <div class="container mt-5">
    <h2>Add Job Title</h2>
    </div>

    <div id="updateOverlay">
        
    </div>

    <div class="container mt-5">
        <h4 class="mb-4">Sort Criteria:</h4>
        <form onsubmit="event.preventDefault();" class="mb-4">
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
                        <option value="title">Name</option>
                        <option value="created_at" selected>Created At</option>
                        <option value="updated_at">Updated At</option>
                    </select>
                </div>

                <!-- Order By -->
                <div class="col-md-4">
                    <label for="orderBy" class="form-label">Order By</label>
                    <select id="orderBy" class="form-select">
                        <option value="ASC">Ascending</option>
                        <option value="DESC" selected>Descending</option>
                    </select>
                </div>
            </fieldset>

            <!-- Filter By Section -->
            <fieldset class="row mb-3">
                <legend>Filter Criteria:</legend>

                <!-- Status -->
                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select id="status" class="form-select">
                        <option value="Active" selected>Active</option>
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
                            <option value="title" selected>Name</option>
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

            <!-- Apply Button -->
            <button onclick="fetchAllSort()" class="btn btn-primary">Apply Filters</button>
        </form>
        <h4 class="mb-4">Job Title Form</h4>
        <form id="create_job_title_form">
            <div class="mb-3">
                <label for="createJobTitle_title" class="form-label">Title</label>
                <input type="text" class="form-control" id="createJobTitle_title" name="createJobTitle_title" placeholder="Enter Name" require>
            </div>
            <div class="mb-3">
                <label for="createJobTitle_department_name" class="form-label">Department Name</label>
                <select class="form-select" id="createJobTitle_department_name" name="createJobTitle_department_name" placeholder="Enter Department" require>
                </select>
            </div>
            <div class="mb-3">
                <label for="createJobTitle_description" class="form-label">Description</label>
                <textarea class="form-select" id="createJobTitle_description" name="createJobTitle_description" rows="3" placeholder="Enter Job Description"></textarea>
            </div>
            <div class="mb-3">
                <label for="createJobTitle_status" class="form-label">Status</label>
                <select class="form-select" id="createJobTitle_status" name="createJobTitle_status">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
        </form>
        <div class="mb-5">
            <!-- <button type="submit" class="btn btn-primary" id="loadTable" onclick="fetchAllJobTitles()">Load Table</button> -->
            <!-- <button type="submit" class="btn btn-primary" id="seePreview">Data Preview</button> -->
            <button type="submit" class="btn btn-primary" id="btnSubmitJobTitle" onclick="createJobTitle()">Create</button>
        </div>

        <div class="mb-3" id="job_title_preview">

        </div>
        <div class="container">
            <h2>Job Title Table</h2>
        </div>
        <div class="mb-3" id="job_title_table">

        </div>
    </div>
    <?php include_once __DIR__ . '/fetchDepartmentsInJobTitle.php'; ?>
    <script>
        populateDepartmentSelect(document.getElementById("createJobTitle_department_name"));
    </script>
</body>
