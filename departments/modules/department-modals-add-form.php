<!-- Department Add Modals Form -->
<style>
    .label-danger {
        color: red;
    }
</style>
<div class="modal fade" id="add-departments-modal" tabindex="-1" aria-labelledby="add-departments-modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="add-departments-modalTitle">Department Form</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <hr>
                <form id="add-departments-form" onsubmit="event.preventDefault(); createDepartment();">
                    <!-- Department Name -->
                    <div class="mb-3">
                        <label for="create_department_name" class="form-label">
                            Name <span class="label-danger">(*)</span>:
                        </label>
                        <input
                            type="text"
                            class="form-control"
                            id="create_department_name"
                            name="create_department_name"
                            required
                            placeholder="Warehouse and Management"
                            minlength="3"
                            maxlength="50"
                            pattern="^[A-Za-z0-9 ]{3,50}$"
                            title="Only letters, numbers, and spaces allowed (3-50 characters)"
                            oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g, '')">
                    </div>

                    <!-- Department Head -->
                    <div class="mb-3">
                        <label for="create_department_head" class="form-label">Department Head:</label>
                        <select
                            class="form-select"
                            id="create_department_head"
                            name="create_department_head">
                            <option value="" disabled selected>Select Department Head</option>
                            <!-- Dynamic options will be added here -->
                        </select>
                    </div>

                    <!-- Department Description -->
                    <div class="mb-3">
                        <label for="create_department_description" class="form-label">Description:</label>
                        <textarea
                            class="form-control"
                            id="create_department_description"
                            name="create_department_description"
                            placeholder="Enter department description"
                            maxlength="250"></textarea>
                    </div>

                    <!-- Department Status -->
                    <div class="mb-3">
                        <label for="create_department_status" class="form-label">
                            Status <span class="label-danger">(*)</span>:
                        </label>
                        <select class="form-select" id="create_department_status" name="create_department_status" required>
                            <option value="Active" selected>Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>

                    <hr>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-arrow-back bx-xs"></i> Close
                        </button>
                        <button type="submit" class="btn btn-success" onclick="createDepartment();">
                            <i class="bx bx-plus bx-xs"></i> Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Department Add Modals Form -->