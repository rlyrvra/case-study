<!-- Modal -->
<div class="modal fade" id="add-departments-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="add-departments-modalTitle">Department Form</h2>
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
                <form onsubmit="event.preventDefault();" id="add-departments-form">
                    <div class="mb-3">
                        <label for="create_department_name" class="form-label">Department Name</label>
                        <input type="text" class="form-control" id="create_department_name" name="create_department_name" required value="">
                    </div>
                    <div class="mb-3">
                        <label for="create_department_head" class="form-label">Department Head</label>
                        <select class="form-select" id="create_department_head" name="create_department_head" placeholder="Enter Department"></select>
                    </div>
                    <div class="mb-3">
                        <label for="create_department_description" class="form-label">Department Description</label>
                        <textarea class="form-control" id="create_department_description" name="create_department_description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="create_department_status" class="form-label">Department Status</label>
                        <select class="form-select" id="create_department_status" name="create_department_status" value="">
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
                        <button type="submit" class="btn btn-success" onclick="createDepartment();" data-bs-dismiss="modal"><i class="bx bx-plus bx-xs"></i>Create</button>
                    </div>
                </form>
            </div>
            
                
                    
                
            
        </div>
    </div>
</div>