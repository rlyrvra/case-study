<!-- Bootstrap Modal Structure -->
<div class="modal fade" id="departmentUpdateModal" tabindex="-1" aria-labelledby="departmentUpdateModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="departmentUpdateModalLabel">Deparment Update Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form onsubmit="event.preventDefault();">
            <div class="mb-3">
                <label for="updateDepartmentName" class="form-label">Department Name</label>
                <input type="text" class="form-control" id="updateDepartmentName" name="updateDepartmentName" required>
            </div>
            <div class="mb-3">
                <label for="updateDepartmentHeadId" class="form-label">Department Head ID</label>
                <input type="number" class="form-control" id="updateDepartmentHeadId" name="updateDepartmentHeadId">
            </div>
            <div class="mb-3">
                <label for="updateDepartmentDescription" class="form-label">Department Description</label>
                <textarea class="form-control" id="updateDepartmentDescription" name="updateDepartmentDescription"></textarea>
            </div>
            <div class="mb-3">
                <label for="updateDepartmentStatus" class="form-label">Department Status</label>
                <select class="form-select" id="updateDepartmentStatus" name="updateDepartmentStatus">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Archived">Archived</option>
                </select>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="updateDepartmentBtn" onclick="updateDepartment(this)" data-bs-dismiss="modal">Update</button>
      </div>
    </div>
  </div>
</div>