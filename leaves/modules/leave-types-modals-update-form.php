<!-- Modal -->
<div class="modal fade" id="update_leave_types_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="update_leave_types_modalTitle">Leave Types Form</h2>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            
            <div class="modal-body">
                <hr/>
                <form id="leave_type_form" onsubmit="event.preventDefault()">
                    <div class="mb-3">
                        <label for="update_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="update_name" placeholder="Enter name" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="update_maximum_number_of_days" class="form-label">Maximum Number of Days</label>
                        <input type="number" class="form-control" id="update_maximum_number_of_days" placeholder="Enter number of days" required>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <div class="row">
                            <div class="col-6">
                                <input type="checkbox" class="add_form-check-input" id="update_is_paid">
                                <label class="form-check-label" for="update_is_paid">Is Paid</label>
                            </div>
                            <div class="col-6">
                                <input type="checkbox" class="add_form-check-input" id="update_is_encashable">
                                <label class="form-check-label" for="update_is_encashable">Is Encashable</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="update_description" class="form-label">Description</label>
                        <textarea class="form-control" id="update_description" rows="3" placeholder="Enter description"></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="update_status" class="form-label">Status</label>
                        <select class="form-select" id="update_status">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                
                    </hr>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-arrow-back bx-xs"></i>Close
                        </button>
                        <button type="submit" class="btn btn-info" onclick="updateLeaveType(this);" data-bs-dismiss="modal" id="updateLeaveTypeBtn"><i class="bx bx-edit bx-xs"></i>Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>