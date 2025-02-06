<!-- Bootstrap Modal Structure -->
<div class="modal fade" id="jobTitleUpdateFormModal" tabindex="-1" aria-labelledby="jobTitleUpdateFormModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="jobTitleUpdateFormModalLabel">Job Title Update Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form onsubmit="event.preventDefault();">
            <div class="mb-3">
                <label for="updateJobTitleName" class="form-label">Job Title</label>
                <input type="text" class="form-control" id="updateJobTitleName" name="updateJobTitleName" required value="">
            </div>
            <div class="mb-3">
                <label for="updateJobTitleDepartmentName" class="form-label">Department Name</label>
                <select class="form-select" id="updateJobTitleDepartmentName" name="updateJobTitleDepartmentName" placeholder="Enter Department" require></select>
            </div>
            <div class="mb-3">
                <label for="updateJobTitledescription" class="form-label">Job Description</label>
                <textarea class="form-control" id="updateJobTitledescription" name="updateJobTitledescription"></textarea>
            </div>
            <div class="mb-3">
                <label for="updateJobTitleStatus" class="form-label">Job Title Status</label>
                <select class="form-select" id="updateJobTitleStatus" name="updateJobTitleStatus" value="">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Archived">Archived</option>
                </select>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="updateJobTitleBtn" onclick="updateJobTitle(this)" data-bs-dismiss="modal">Update</button>
      </div>
    </div>
  </div>
</div>