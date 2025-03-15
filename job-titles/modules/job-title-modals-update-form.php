<!-- Job Title Update Modal -->
<div class="modal fade" id="update_job_titles_modal" tabindex="-1" aria-labelledby="update_job_titles_modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="update_job_titles_modalTitle">Job Title Form</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <hr>
                <form onsubmit="event.preventDefault();" id="update_job_title_form">
                    <!-- Job Title -->
                    <div class="mb-3">
                        <label for="update_jobtitle_title" class="form-label">
                            Title <span class="label-danger">(*)</span>
                        </label>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="update_jobtitle_title" 
                            name="update_jobtitle_title" 
                            placeholder="Enter Job Title" 
                            required
                            minlength="3" 
                            maxlength="50"
                            pattern="^[A-Za-z0-9 ]{3,50}$"
                            title="Only letters, numbers, and spaces allowed (3-50 characters)"
                            oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g, '')">
                    </div>

                    <!-- Department Name -->
                    <div class="mb-3">
                        <label for="update_jobtitle_department_name" class="form-label">
                            Department Name <span class="label-danger">(*)</span>
                        </label>
                        <select class="form-select update_department" id="update_jobtitle_department_name" name="update_jobtitle_department_name" required>
                            <option value="" disabled selected>Select Department</option>
                            <!-- Dynamic options will be added here -->
                        </select>
                    </div>

                    <!-- Job Description -->
                    <div class="mb-3">
                        <label for="update_jobtitle_description" class="form-label">Description:</label>
                        <textarea 
                            class="form-control" 
                            id="update_jobtitle_description" 
                            name="update_jobtitle_description" 
                            rows="3" 
                            placeholder="Enter Job Description"
                            maxlength="250"></textarea>
                    </div>

                    <!-- Job Status -->
                    <div class="mb-3">
                        <label for="update_jobtitle_status" class="form-label">
                            Status <span class="label-danger">(*)</span>
                        </label>
                        <select class="form-select" id="update_jobtitle_status" name="update_jobtitle_status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                    <hr>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-arrow-back bx-xs"></i> Close
                        </button>
                        <button type="submit" id="update_department_btn" class="btn btn-info" onclick="updateJobTitle(this);">
                            <i class="bx bx-plus bx-xs"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Job Title Update Modal -->