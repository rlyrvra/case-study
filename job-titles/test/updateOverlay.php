<style>
    /* Full-screen overlay background with opacity */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Black background with opacity */
        z-index: 999; /* Make sure it is above other content */
    }

    /* Centering the form container */
    .form-container {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        z-index: 1000; /* Ensure form is above the overlay */
        max-width: 600px;
        width: 100%;
    }
</style>

<!-- Full-Screen Overlay (Initially Hidden) -->
<div class="overlay" id="overlay" style="display: none;" onclick="hideUpdateOverlay()"></div>

<!-- Form Container (Initially Hidden) -->
<div class="form-container" id="formContainer" style="display: none;">
    <form action="#" onsubmit="event.preventDefault();">
        <div class="mb-3">
            <label for="jobTitleName" class="form-label">Job Title</label>
            <input type="text" class="form-control" id="jobTitleName" name="name" required value="">
        </div>
        <div class="mb-3">
            <label for="departmentName" class="form-label">Department Name</label>
            <select class="form-select" id="jobTitleDepartmentName" name="jobTitleDepartmentName" placeholder="Enter Department" require></select>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Job Description</label>
            <textarea class="form-control" id="jobTitledescription" name="jobTitleDescription"></textarea>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Job Title Status</label>
            <select class="form-select" id="jobTitlestatus" name="status" value="">
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
                <option value="Archived">Archived</option>
            </select>
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-success" onclick="updatejobTitle('<?php echo $hashed_id; ?>')">Update</button>
            <button type="button" class="btn btn-secondary" id="cancelBtn" onclick="hideUpdateOverlay()">Cancel</button>
        </div>
    </form>
    
</div>