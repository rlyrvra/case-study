<!-- Allowance Update Form Modal -->
<style>
    .label-danger {
        color: red;
    }
</style>

<div class="modal fade" id="update-allowances-modal" tabindex="-1" aria-labelledby="update-allowances-modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-sm border-0">
            <div class="modal-header bg-light border-bottom">
                <h2 class="modal-title fs-5 fw-semibold text-primary" id="update-allowances-modalTitle">
                    <i class="bx bx-wallet"></i> Update Allowance
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="update_allowance_form" onsubmit="event.preventDefault();">
                    <div class="row g-3">
                        <!-- Name -->
                        <div class="col-md-6">
                            <label for="update_name" class="form-label fw-semibold">
                                Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control shadow-sm" id="update_name" name="update_name"
                                required minlength="3" maxlength="50" pattern="^[A-Za-z0-9 ]{3,50}$"
                                title="Only letters, numbers, and spaces allowed (3-50 characters)"
                                placeholder="Ex. Sample Allowance"
                                oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g, '')">
                        </div>

                        <!-- Amount -->
                        <div class="col-md-6">
                            <label for="update_amount" class="form-label fw-semibold">
                                Amount <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control shadow-sm" id="update_amount" name="update_amount"
                                placeholder="Ex. 100" required min="1" step="1">
                        </div>
                    </div>

                    <!-- Frequency -->
                    <div class="mt-3">
                        
                        <label for="update_frequency" class="form-label fw-semibold">
                            Frequency <span class="text-danger">*</span>
                        </label>
                        <select class="form-select shadow-sm" id="update_frequency" name="update_frequency" required>
                            <option value="" disabled selected>Select Frequency</option>
                            <option value="Weekly">Weekly</option>
                            <option value="Semi-monthly">Semi-monthly</option>
                            <option value="Monthly">Monthly</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="mt-3">
                        <label for="update_status" class="form-label fw-semibold">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select class="form-select shadow-sm" id="update_status" name="update_status" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Archived">Archived</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="mt-3">
                        <label for="update_description" class="form-label fw-semibold">Description</label>
                        <textarea class="form-control shadow-sm" id="update_description" name="update_description"
                            placeholder="Ex. Any description" maxlength="255" rows="3"></textarea>
                    </div>
            </div>

            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-arrow-back"></i> Close
                </button>
                <button type="submit" id="update_allowance_btn" class="btn btn-info" onclick="updateAllowance(this);">
                    <i class="bx bx-edit"></i> Update
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
