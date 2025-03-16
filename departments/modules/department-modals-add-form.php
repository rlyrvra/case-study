<!-- Department Add Modals Form -->
<style>
    .label-danger {
        color: red;
    }
</style>
<div class="modal fade" id="add-departments-modal" tabindex="-1" aria-labelledby="add-departments-modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-sm border-0">
            <div class="modal-header bg-light border-bottom">
                <h2 class="modal-title fs-5 fw-semibold text-success" id="add-departments-modalTitle">
                    <i class="bx bx-building-house"></i> Create Department
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="add-departments-form" onsubmit="event.preventDefault(); createDepartment();">
                    <div class="row g-3">
                        <!-- Department Name -->
                        <div class="col-md-6">
                            <label for="create_department_name" class="form-label fw-semibold">
                                Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control shadow-sm" id="create_department_name" name="create_department_name"
                                required placeholder="Warehouse and Management" minlength="3" maxlength="50"
                                pattern="^[A-Za-z0-9 ]{3,50}$"
                                title="Only letters, numbers, and spaces allowed (3-50 characters)"
                                oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g, '')">
                        </div>

                        <!-- Department Head -->
                        <div class="col-md-6">
                            <label for="create_department_head" class="form-label fw-semibold">Department Head</label>
                            <select class="form-select shadow-sm" id="create_department_head" name="create_department_head">
                                <option value="" disabled selected>Select Department Head</option>
                                <!-- Dynamic options will be added here -->
                            </select>
                        </div>
                    </div>

                    <!-- Department Description -->
                    <div class="mt-3">
                        <label for="create_department_description" class="form-label fw-semibold">Description</label>
                        <textarea class="form-control shadow-sm" id="create_department_description" name="create_department_description"
                            placeholder="Enter department description" maxlength="250" rows="3"></textarea>
                    </div>

                    <!-- Department Status -->
                    <div class="mt-3">
                        <label for="create_department_status" class="form-label fw-semibold">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-select shadow-sm" id="create_department_status" name="create_department_status" required>
                            <option value="Active" selected>Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                
            </div>

            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-arrow-back"></i> Close
                </button>
                <button type="submit" class="btn btn-success" onclick="createDepartment();">
                    <i class="bx bx-plus"></i> Create
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Department Add Modals Form -->