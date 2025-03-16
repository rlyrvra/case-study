<!-- Add & Update Holiday Modal -->
<div class="modal fade" id="update-holidays-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-sm border-0">
            <div class="modal-header bg-light border-bottom">
                <h2 class="modal-title fs-5 fw-semibold text-primary" id="update-holidays-modalTitle">
                    <i class="bx bx-calendar"></i> Update Holiday
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                <form id="update_holidays_form" onsubmit="event.preventDefault();">
                    <!-- Holiday Name -->
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="update_name" class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control shadow-sm" id="update_name" name="update_name" required 
                                placeholder="Sample Holiday" minlength="3" maxlength="50"
                                pattern="^[A-Za-z0-9 ]{3,50}$"
                                title="Only letters, numbers, and spaces allowed (3-50 characters)"
                                oninput="this.value = this.value.replace(/[^A-Za-z0-9 ]/g, '')">
                        </div>
                    </div>

                    <!-- Start Date & End Date -->
                    <div class="row g-3 mt-1">
                        <div class="col-md-6">
                            <label for="update_start_date" class="form-label fw-semibold">Start Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control shadow-sm" id="update_start_date" name="update_start_date" required min="2022-01-01">
                        </div>
                        <div class="col-md-6">
                            <label for="update_end_date" class="form-label fw-semibold">End Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control shadow-sm" id="update_end_date" name="update_end_date" required min="2022-01-01">
                        </div>
                    </div>
                    
                    <!-- Is Paid & Is Recurring -->
                    <div class="row g-3 mt-1">
                        <div class="col-md-6 d-flex align-items-center">
                            <div class="form-check me-3">
                                <input class="form-check-input" type="checkbox" id="update_isPaid" name="update_isPaid">
                                <label class="form-check-label fw-semibold" for="update_isPaid">Is Paid</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="update_isRecurring" name="update_isRecurring">
                                <label class="form-check-label fw-semibold" for="update_isRecurring">Is Recurring Annually</label>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mt-3">
                        <label for="update_description" class="form-label fw-semibold">Description</label>
                        <textarea class="form-control shadow-sm" id="update_description" name="update_description"
                            placeholder="Ex. Any description" maxlength="255" rows="3"
                            pattern="^[A-Za-z0-9 ,.!?-]{3,255}$"
                            title="Only letters, numbers, spaces, and basic punctuation allowed (3-255 characters)"></textarea>
                    </div>
                    
                    <!-- Status -->
                    <div class="mt-3">
                        <label for="update_status" class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select class="form-select shadow-sm" id="update_status" name="update_status" required>
                            <option value="Active" selected>Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </form>
            </div>
            
            <div class="modal-footer border-top bg-light">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-arrow-back"></i> Close
                </button>
                <button type="submit" class="btn btn-info" onclick="updateHolidays(this);" id="update_allowance_btn">
                    <i class="bx bx-edit"></i> Update
                </button>
            </div>
        </div>
    </div>
</div>
