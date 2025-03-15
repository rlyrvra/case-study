<!-- Department Update Modals Form -->
<style>
    .label-danger {
        color: red;
    }
</style>
<div class="modal fade" id="update_departments_modal" tabindex="-1" aria-labelledby="update_departments_modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="update_departments_modalTitle">Department Form</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <hr>
                <form id="update_departments_form" onsubmit="event.preventDefault(); updateDepartment(this);">
                    <!-- Department Name -->
                    <div class="mb-3">
                        <label for="update_department_name" class="form-label">
                            Name <span class="label-danger">(*)</span>:
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="update_department_name"
                            name="update_department_name"
                            required
                            minlength="3"
                            maxlength="50"
                            pattern="^[A-Za-z0-9 ]{3,50}$"
                            title="Only letters, numbers, and spaces allowed (3-50 characters)"
                            oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g, '')">
                    </div>

                    <!-- Department Head -->
                    <div class="mb-3">
                        <label for="update_department_head" class="form-label">Department Head:</label>
                        <select class="form-select" id="update_department_head" name="update_department_head">
                            <option value="" disabled selected>Select Department Head</option>
                            <!-- Dynamic options will be added here -->
                        </select>
                    </div>

                    <!-- Department Description -->
                    <div class="mb-3">
                        <label for="update_department_description" class="form-label">Description:</label>
                        <textarea
                            class="form-control"
                            id="update_department_description"
                            name="update_department_description"
                            placeholder="Enter department description"
                            maxlength="250"></textarea>
                    </div>

                    <!-- Department Status -->
                    <div class="mb-3">
                        <label for="update_department_status" class="form-label">
                            Status <span class="label-danger">(*)</span>:
                        </label>
                        <select class="form-select" id="update_department_status" name="update_department_status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                    <hr>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-arrow-back bx-xs"></i> Close
                        </button>
                        <button type="submit" id="update_department_btn" class="btn btn-info" onclick="updateDepartment(this);">
                            <i class="bx bx-edit bx-xs"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End of Department Update Modals Form -->