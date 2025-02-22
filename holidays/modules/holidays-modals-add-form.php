<!-- Modal -->
<div class="modal fade" id="add-holidays-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="add-holidays-modalTitle">Holiday Form</h2>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            
            <div class="modal-body">


            <form onsubmit='event.preventDefault()' id="add_holidays_form">
                <!-- Name -->
                <div class="form-group mb-3">
                    <label for="create_name">Name*:</label>
                    <input type="text" class="form-control" id="create_name" name="create_name" maxlength="50" placeholder="Ex. Sample Holiday" required>
                </div>

                <!-- Start Date - End Date -->
                <div class="form-group mb-3 row">
                    <div class="col-6">
                        <label for="create_start_date">Start Date*:</label>
                        <input type="date" class="form-control" id="create_start_date" name="create_start_date" required>
                    </div>
                    <div class="col-6">
                        <label for="create_end_date">End Date*:</label>
                        <input type="date" class="form-control" id="create_end_date" name="create_end_date" required>
                    </div>
                </div>

                <!-- Is Paid -->
                <div class="form-group mb-3 row">
                    <div class="col-6">
                        <label class="form-check-label" for="create_isPaid">Is Paid*:</label>
                        <input class="form-check-input border-2" type="checkbox" id="create_isPaid" name="create_isPaid">
                    </div>
                    <div class="col-6">
                        <label class="form-check-label" for="create_isRecurring">Is Recurring Annually:</label>
                        <input class="form-check-input border-2" type="checkbox" id="create_isRecurring" name="create_isRecurring">
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group mb-3">
                    <label for="create_description">Description:</label>
                    <textarea class="form-control" id="create_description" name="create_description" rows="3" maxlength="255" placeholder="Ex. Any description"></textarea>
                </div>

                <!-- Status -->
                <div class="form-group mb-3">
                    <label for="create_status">Status*:</label>
                    <select class="form-control" id="create_status" name="create_status" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                </div>

            

                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-arrow-back bx-xs"></i>Close
                </button>
                <button type="submit" class="btn btn-success" onclick="createHolidays();"><i class="bx bx-plus bx-xs"></i>Create</button>
            </div>
            
            </form>
                    
                
            
        </div>
    </div>
</div>