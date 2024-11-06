<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<body>
    <div class="container mt-5">
    <h2>Add Job Title</h2>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.43/moment-timezone-with-data.min.js"></script>
    <script src="ajax-requests.js"></script>
    <div class="container mt-5">
        <h4 class="mb-4">Job Title Form</h4>
        <form>
            <div class="mb-3">
                <label for="id" class="form-label">Current UserID</label>
                <input type="number" class="form-control" id="userId" name="userId" placeholder="Enter ID">
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" require>
            </div>
            <div class="mb-3">
                <label for="departmentId" class="form-label">Department Id</label>
                <input type="number" class="form-control" id="departmentId" name="department_id" placeholder="Enter Department ID" require>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter Job Description"></textarea>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <input type="hidden" name="action" value="getValues">
            <button type="submit" class="btn btn-primary" id="seePreview">Data Preview</button>
        </form>
        <form>
            <button type="submit" class="btn btn-primary" id="addValues">Add To Table</button>
        </form>
        <form onsubmit="event.preventDefault()">
            <button type="submit" class="btn btn-primary" id="loadTable" onclick="fetchAllJobTitles()">Load Table</button>
        </form>

        <div class="mb-3" id="job_title_preview">

        </div>
        <div class="container">
            <h2>Job Title Table</h2>
        </div>
        <div class="mb-3" id="job_title_table">

        </div>
    </div>
</body>
