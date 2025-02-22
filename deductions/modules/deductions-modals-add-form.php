<!-- Modal -->
<div class="modal fade" id="add-deductions-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="add-deductions-modalTitle">Deductions Form</h2>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            
            <div class="modal-body">

            <form onsubmit='event.preventDefault()' id="add_deductions_form">
                <!-- Name -->
                <div class="form-group mb-3">
                    <label for="create_name">Name*:</label>
                    <input type="text" class="form-control" id="create_name" name="create_name" maxlength="50" placeholder="Ex. Sample Deduction" required>
                </div>

                <!-- Amount -->
                <div class="form-group mb-3">
                    <label for="create_amount">Amount*:</label>
                    <input type="number" class="form-control" id="create_amount" name="create_amount" placeholder="Ex. 100" step="1" required>
                </div>

                <!-- Frequency -->
                <div class="form-group mb-3">
                    <label for="create_frequency">Frequency*:</label>
                    <select class="form-control" id="create_frequency" name="create_frequency" required>
                        <option value="" disabled selected>Select Frequency</option>
                        <option value="Weekly">Weekly</option>
                        <option value="Semi-monthly">Semi-monthly</option>
                        <option value="Monthly">Monthly</option>
                    </select>
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
                        <option value="Archived">Archived</option>
                    </select>
                </div>

                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-arrow-back bx-xs"></i>Close
                </button>
                <button type="submit" class="btn btn-success" onclick="createDeductions();"><i class="bx bx-plus bx-xs"></i>Create</button>
            </div>
            
            </form>
                    
                
            
        </div>
    </div>
</div>