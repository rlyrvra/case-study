<style>
    .label-danger {
        color: red;
    }
</style>
<div class="modal fade" id="add_leave_types_modal" tabindex="-1" aria-labelledby="add_leave_types_modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-sm border-0">
            <div class="modal-header bg-light border-bottom">
                <h2 class="modal-title fs-5 fw-semibold text-success" id="add_leave_types_modalTitle">
                    <i class="bx bx-calendar"></i> Create Leave Type
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="add_leave_type_form" onsubmit="event.preventDefault(); createLeaveTypes();">
                    <div class="row g-3">
                        <!-- Leave Type Name -->
                        <div class="col-md-6">
                            <label for="add_name" class="form-label fw-semibold">
                                Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control shadow-sm" id="add_name" name="add_name"
                                required placeholder="Enter leave type name" minlength="3" maxlength="50"
                                pattern="^[A-Za-z0-9 ]{3,50}$"
                                title="Only letters, numbers, and spaces allowed (3-50 characters)"
                                oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g, '')">
                        </div>

                        <!-- Maximum Number of Days -->
                        <div class="col-md-6">
                            <label for="add_maximum_number_of_days" class="form-label fw-semibold">
                                Maximum Number of Days <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control shadow-sm" id="add_maximum_number_of_days" name="add_maximum_number_of_days"
                                required placeholder="Enter number of days" min="1">
                        </div>
                    </div>

                    <!-- Is Paid Checkbox -->
                    <div class="mt-3">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input shadow-sm" id="add_is_paid" name="add_is_paid">
                            <label class="form-check-label fw-semibold" for="add_is_paid">Is Paid</label>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-3">
                        <label for="add_description" class="form-label fw-semibold">Description</label>
                        <textarea class="form-control shadow-sm" id="add_description" name="add_description"
                            placeholder="Enter description" maxlength="250" rows="3"></textarea>
                    </div>

                    <!-- Status -->
                    <div class="mt-3">
                        <label for="add_status" class="form-label fw-semibold">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-select shadow-sm" id="add_status" name="add_status" required>
                            <option value="Active" selected>Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
            </div>

            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-arrow-back"></i> Close
                </button>
                <button type="submit" class="btn btn-success" onclick="createLeaveTypes();">
                    <i class="bx bx-plus"></i> Create
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
