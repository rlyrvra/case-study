<!-- Job Title Add Modal -->
<style>
    .label-danger {
        color: red;
    }
</style>
<div class="modal fade" id="add_job_titles_modal" tabindex="-1" aria-labelledby="add_job_titles_modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-sm border-0">
            <div class="modal-header bg-light border-bottom">
                <h2 class="modal-title fs-5 fw-semibold text-success" id="add_job_titles_modalTitle">
                    <i class="bx bx-briefcase"></i> Create Job Title
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form onsubmit="event.preventDefault();" id="create_job_title_form">
                    <div class="row g-3">
                        <!-- Job Title -->
                        <div class="col-md-6">
                            <label for="create_jobtitle_title" class="form-label fw-semibold">
                                Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control shadow-sm" id="create_jobtitle_title" name="create_jobtitle_title"
                                placeholder="Enter Job Title" required minlength="3" maxlength="50"
                                pattern="^[A-Za-z0-9 ]{3,50}$"
                                title="Only letters, numbers, and spaces allowed (3-50 characters)"
                                oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g, '')">
                        </div>

                        <!-- Department Name -->
                        <div class="col-md-6">
                            <label for="create_jobtitle_department_name" class="form-label fw-semibold">
                                Department Name <span class="text-danger">*</span>
                            </label>
                            <select class="form-select shadow-sm add_department" id="create_jobtitle_department_name"
                                name="create_jobtitle_department_name" required>
                                <option value="" disabled selected>Select Department</option>
                                <!-- Dynamic options will be added here -->
                            </select>
                        </div>
                    </div>

                    <!-- Job Description -->
                    <div class="mt-3">
                        <label for="create_jobtitle_description" class="form-label fw-semibold">Description</label>
                        <textarea class="form-control shadow-sm" id="create_jobtitle_description" name="create_jobtitle_description"
                            rows="3" placeholder="Enter Job Description" maxlength="250"></textarea>
                    </div>

                    <!-- Job Status -->
                    <div class="mt-3">
                        <label for="create_jobtitle_status" class="form-label fw-semibold">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-select shadow-sm" id="create_jobtitle_status" name="create_jobtitle_status" required>
                            <option value="Active" selected>Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                
            </div>

            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-arrow-back"></i> Close
                </button>
                <button type="submit" class="btn btn-success" onclick="createJobTitle();">
                    <i class="bx bx-plus"></i> Create
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Job Title Add Modal -->