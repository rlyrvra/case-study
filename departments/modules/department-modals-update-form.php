<!-- Modal -->
<div class="modal fade" id="update_departments_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="update_departments_modalTitle">Department Form</h2>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            
            <div class="modal-body">
                <div class="divider text-start">
                    <div class="divider-text">
                        
                    </div>
                </div>
                <form onsubmit="event.preventDefault();" id="update_departments_form">
                    <div class="mb-3">
                        <label for="update_department_name" class="form-label">Department Name</label>
                        <input type="text" class="form-control" id="update_department_name" name="update_department_name" required value="">
                    </div>
                    <div class="mb-3">
                        <label for="update_department_head" class="form-label">Department Head</label>
                        <select class="form-select" id="update_department_head" name="update_department_head" placeholder="Enter Department" require></select>
                    </div>
                    <div class="mb-3">
                        <label for="update_department_description" class="form-label">Department Description</label>
                        <textarea class="form-control" id="update_department_description" name="update_department_description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="update_department_status" class="form-label">Department Status</label>
                        <select class="form-select" id="update_department_status" name="update_department_status" value="">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                
                    <div class="divider text-start">
                        <div class="divider-text">
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-arrow-back bx-xs"></i>Close
                        </button>
                        <button type="submit" id="update_department_btn" class="btn btn-primary" onclick="updateDepartment(this);" data-bs-dismiss="modal"><i class="bx bx-plus bx-xs"></i>update</button>
                    </div>
                </form>
            </div>
            
                
                    
                
            
        </div>
    </div>
</div>