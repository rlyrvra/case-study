<!-- Modal -->
<style>
    .label-danger {
        color: red;
    }
</style>
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
                <hr>
                <form onsubmit="event.preventDefault();" id="add-departments-form">
                    <div class="mb-3">
                        <label for="create_department_name" class="form-label">Department Name<span class="label-danger">(*)</span>:</label>
                        <input type="text" class="form-control" id="create_department_name" name="create_department_name" required placeholder="Warehouse and Management" min=1 max=50>
                    </div>
                    <div class="mb-3">
                        <label for="create_department_head" class="form-label">Department Head:</label>
                        <select class="form-select" id="create_department_head" name="create_department_head" placeholder="Enter Department"></select>
                    </div>
                    <div class="mb-3">
                        <label for="create_department_description" class="form-label">Department Description:</label>
                        <textarea class="form-control" id="create_department_description" name="create_department_description" placeholder="Sample Description" min=0 max=255></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="create_department_status" class="form-label">Department Status<span class="label-danger">(*)</span>:</label>
                        <select class="form-select" id="create_department_status" name="create_department_status" value="" required>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                
                    <hr>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-arrow-back bx-xs"></i>Close
                        </button>
                        <button type="submit" class="btn btn-success" onclick="createDepartment();"><i class="bx bx-plus bx-xs"></i>Create</button>
                    </div>
                </form>
            </div>
            
                
                    
                
            
        </div>
    </div>
</div>