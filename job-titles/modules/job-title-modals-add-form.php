<!-- Modal -->
<style>
    .label-danger {
        color: red;
    }
</style>
<div class="modal fade" id="add_job_titles_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="add_job_titles_modalTitle">Job Title Form</h2>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            
            <div class="modal-body">
                <hr>
                <form onsubmit="event.preventDefault();" id="create_job_title_form">
                    <div class="mb-3">
                        <label for="create_jobtitle_title" class="form-label">Title<span class="label-danger">(*)</span></label>
                        <input 
                        type="text" 
                        class="form-control" 
                        id="create_jobtitle_title" 
                        name="create_jobtitle_title" 
                        placeholder="Enter Name" 
                        required 
                        minlength="1" 
                        maxlength="50">
                    </div>
                    <div class="mb-3">
                        <label for="create_jobtitle_department_name" class="form-label">Department Name<span class="label-danger">(*)</span></label>
                        <select 
                        class="form-select add_department" 
                        id="create_jobtitle_department_name" 
                        name="create_jobtitle_department_name" 
                        placeholder="Enter Department">
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="create_jobtitle_description" class="form-label">Description:</label>
                        <textarea class="form-select"
                         id="create_jobtitle_description" 
                         name="create_jobtitle_description" 
                         rows="3" 
                         placeholder="Enter Job Description"
                         maxlength="50"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="create_jobtitle_status" class="form-label">Status<span class="label-danger">(*)</span></label>
                        <select 
                        class="form-select" 
                        id="create_jobtitle_status" 
                        name="create_jobtitle_status"
                        required >
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <hr>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-arrow-back bx-xs"></i>Close
                        </button>
                        <button type="submit" class="btn btn-success" onclick="createJobTitle();"><i class="bx bx-plus bx-xs"></i>Create</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>