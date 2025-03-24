<!-- Leave Types Update Form Modal -->
<style>
    .label-danger {
        color: red;
    }
</style>
<div class="modal fade" id="update_leave_types_modal" tabindex="-1" aria-labelledby="update_leave_types_modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-sm border-0">
            <div class="modal-header bg-light border-bottom">
                <h2 class="modal-title fs-5 fw-semibold text-primary" id="update_leave_types_modalTitle">
                    <i class="bx bx-calendar"></i> Update Leave Type
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="update_leave_type_form" onsubmit="event.preventDefault();">
                    <div class="row g-3">
                        <!-- Leave Name -->
                        <div class="col-md-6">
                            <label for="update_name" class="form-label fw-semibold">
                                Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control shadow-sm" id="update_name" name="update_name"
                                required minlength="3" maxlength="50" pattern="^[A-Za-z0-9 ]{3,50}$"
                                title="Only letters, numbers, and spaces allowed (3-50 characters)"
                                oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g, '')">
                        </div>

                        <!-- Maximum Number of Days -->
                        <div class="col-md-6">
                            <label for="update_maximum_number_of_days" class="form-label fw-semibold">
                                Maximum Number of Days <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control shadow-sm" id="update_maximum_number_of_days" name="update_maximum_number_of_days"
                                placeholder="Enter number of days" required min="1">
                        </div>
                    </div>

                    <!-- Is Paid Checkbox -->
                    <div class="mt-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="update_is_paid" name="update_is_paid">
                            <label class="form-check-label fw-semibold" for="update_is_paid">Is Paid</label>
                        </div>
                    </div>

                    <!-- Leave Description -->
                    <div class="mt-3">
                        <label for="update_description" class="form-label fw-semibold">Description</label>
                        <textarea class="form-control shadow-sm" id="update_description" name="update_description"
                            placeholder="Enter leave type description" maxlength="250" rows="3"></textarea>
                    </div>

                    <!-- Leave Status -->
                    <div class="mt-3">
                        <label for="update_status" class="form-label fw-semibold">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-select shadow-sm" id="update_status" name="update_status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
            </div>

            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-arrow-back"></i> Close
                </button>
                <button type="submit" id="updateLeaveTypeBtn" class="btn btn-primary" onclick="updateLeaveType(this);">
                    <i class="bx bx-edit"></i> Update
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- End of Leave Types Update Form Modal -->
