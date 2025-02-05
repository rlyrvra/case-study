<!-- Modal -->
<div class="modal fade" id="update-holidays-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="update-holidays-modalTitle">Holiday Form</h2>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            
            <div class="modal-body">

            <hr/>

            <form onsubmit='event.preventDefault()' id="update_holidays_form">
                <!-- Name -->
                <div class="form-group mb-3">
                    <label for="update_name">Name*:</label>
                    <input type="text" class="form-control" id="update_name" name="update_name" maxlength="50" placeholder="Ex. Sample Holiday" required>
                </div>

                <!-- Start Date - End Date -->
                <div class="form-group mb-3 row">
                    <div class="col-6">
                        <label for="update_start_date">Start Date*:</label>
                        <input type="date" class="form-control" id="update_start_date" name="update_start_date" required>
                    </div>
                    <div class="col-6">
                        <label for="update_end_date">End Date*:</label>
                        <input type="date" class="form-control" id="update_end_date" name="update_end_date" required>
                    </div>
                </div>

                <!-- Is Paid -->
                <div class="form-group mb-3 row">
                    <div class="col-6">
                        <label class="form-check-label" for="update_isPaid">Is Paid*:</label>
                        <input class="form-check-input border-2" type="checkbox" id="update_isPaid" name="update_isPaid">
                    </div>
                    <div class="col-6">
                        <label class="form-check-label" for="update_isRecurring">Is Recurring Annually:</label>
                        <input class="form-check-input border-2" type="checkbox" id="update_isRecurring" name="update_isRecurring">
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group mb-3">
                    <label for="update_description">Description:</label>
                    <textarea class="form-control" id="update_description" name="update_description" rows="3" maxlength="255" placeholder="Ex. Any description"></textarea>
                </div>

                <!-- Status -->
                <div class="form-group mb-3">
                    <label for="update_status">Status*:</label>
                    <select class="form-control" id="update_status" name="update_status" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

            

            <hr/>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-arrow-back bx-xs"></i>Close
                </button>
                <button type="submit" class="btn btn-info" onclick="updateHolidays(this);" id="update_allowance_btn"><i class="bx bx-plus bx-xs"></i>Update</button>
            </div>
            
            </form>
                    
                
            
        </div>
    </div>
</div>