<!-- Department Update Modals Form -->
<style>
    .label-danger {
        color: red;
    }
</style>
<div class="modal fade" id="update_departments_modal" tabindex="-1" aria-labelledby="update_departments_modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-sm border-0">
            <div class="modal-header bg-light border-bottom">
                <h2 class="modal-title fs-5 fw-semibold text-primary" id="update_departments_modalTitle">
                    <i class="bx bx-building-house"></i> Update Department
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="update_departments_form" onsubmit="event.preventDefault(); updateDepartment(this);">
                    <div class="row g-3">
                        <!-- Department Name -->
                        <div class="col-md-6">
                            <label for="update_department_name" class="form-label fw-semibold">
                                Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control shadow-sm" id="update_department_name" name="update_department_name"
                                required minlength="3" maxlength="50" pattern="^[A-Za-z0-9 ]{3,50}$"
                                title="Only letters, numbers, and spaces allowed (3-50 characters)"
                                oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g, '')">
                        </div>

                        <!-- Department Head -->
                        <div class="col-md-6">
                            <label for="update_department_head" class="form-label fw-semibold">Department Head</label>
                            <select class="form-select shadow-sm" id="update_department_head" name="update_department_head">
                                <option value="" disabled selected>Select Department Head</option>
                                <!-- Dynamic options will be added here -->
                            </select>
                        </div>
                    </div>

                    <!-- Department Description -->
                    <div class="mt-3">
                        <label for="update_department_description" class="form-label fw-semibold">Description</label>
                        <textarea class="form-control shadow-sm" id="update_department_description" name="update_department_description"
                            placeholder="Enter department description" maxlength="250" rows="3"></textarea>
                    </div>

                    <!-- Department Status -->
                    <div class="mt-3">
                        <label for="update_department_status" class="form-label fw-semibold">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-select shadow-sm" id="update_department_status" name="update_department_status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
            </div>

            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-arrow-back"></i> Close
                </button>
                <button type="submit" id="update_department_btn" class="btn btn-primary" onclick="updateDepartment(this);">
                    <i class="bx bx-edit"></i> Update
                </button>
            </div>
            </form>
        </div>
    </div>
</div>

<!-- End of Department Update Modals Form -->