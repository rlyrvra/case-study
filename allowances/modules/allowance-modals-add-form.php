<style>
    .label-danger {
        color: red;
    }
</style>

<div class="modal fade" id="add-allowances-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-sm border-0">
            <div class="modal-header bg-light border-bottom">
                <h2 class="modal-title fs-5 fw-semibold text-success" id="add-allowances-modalTitle">
                    <i class="bx bx-money"></i> Allowance Form
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form id="add_allowance_form" onsubmit="event.preventDefault(); createAllowance();">
                    <div class="row g-3">
                        <!-- Name -->
                        <div class="col-md-6">
                            <label for="create_name" class="form-label fw-semibold">
                                Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control shadow-sm" id="create_name" name="create_name"
                                required placeholder="Sample Allowance" minlength="3" maxlength="50"
                                pattern="^[A-Za-z0-9 ]{3,50}$"
                                title="Only letters, numbers, and spaces allowed (3-50 characters)"
                                oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g, '')">
                        </div>

                        <!-- Amount -->
                        <div class="col-md-6">
                            <label for="create_amount" class="form-label fw-semibold">
                                Amount <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control shadow-sm" id="create_amount" name="create_amount"
                                required placeholder="100" min="1">
                        </div>
                    </div>

                    <!-- Frequency -->
                    <div class="mt-3">
                        <label for="create_frequency" class="form-label fw-semibold">
                            Frequency <span class="text-danger">*</span>
                        </label>
                        <select class="form-select shadow-sm" id="create_frequency" name="create_frequency" required>
                            <option value="" disabled selected>Select Frequency</option>
                            <option value="Weekly">Weekly</option>
                            <option value="Semi-monthly">Semi-monthly</option>
                            <option value="Monthly">Monthly</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="mt-3">
                        <label for="create_description" class="form-label fw-semibold">Description</label>
                        <textarea class="form-control shadow-sm" id="create_description" name="create_description"
                            placeholder="Sample description" maxlength="255" rows="3"></textarea>
                    </div>

                    <!-- Status -->
                    <div class="mt-3">
                        <label for="create_status" class="form-label fw-semibold">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-select shadow-sm" id="create_status" name="create_status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Archived">Archived</option>
                        </select>
                    </div>
            </div>
            
            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-arrow-back"></i> Close
                </button>
                <button type="submit" class="btn btn-success" onclick="createAllowance();">
                    <i class="bx bx-plus"></i> Create
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
