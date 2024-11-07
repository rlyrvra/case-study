<style>
    /* Full-screen overlay background with opacity */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Black background with opacity */
        z-index: 999; /* Make sure it is above other content */
    }

    /* Centering the form container */
    .form-container {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        z-index: 1000; /* Ensure form is above the overlay */
        max-width: 600px;
        width: 100%;
    }
</style>

<!-- Full-Screen Overlay (Initially Hidden) -->
<div class="overlay" id="overlay" style="display: none;" onclick="hideUpdateOverlay()"></div>

<!-- Form Container (Initially Hidden) -->
<div class="form-container" id="formContainer" style="display: none;">
    <form action="#" onsubmit="event.preventDefault();">
        <?php if (!empty($departments)): ?>
        <?php foreach ($departments as $row): ?>
            <div class="mb-3">
                <label for="departmentName" class="form-label">Department Name</label>
                <input type="text" class="form-control" id="departmentName" name="name" required value="<?php echo htmlspecialchars($row['name']); ?>">
            </div>
            <div class="mb-3">
                <label for="departmentHeadId" class="form-label">Department Head ID</label>
                <input type="number" class="form-control" id="departmentHeadId" name="departmentHeadId" value="<?php echo htmlspecialchars($row['department_head_id']); ?>">
            </div>
            <div class="mb-3">
                <label for="departmentDescription" class="form-label">Department Description</label>
                <textarea class="form-control" id="departmentDescription" name="departmentDescription"><?php echo htmlspecialchars($row['description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="departmentStatus" class="form-label">Department Status</label>
                <select class="form-select" id="departmentStatus" name="departmentStatus" value="value=<?php echo htmlspecialchars($row['status']); ?>">
                    <option value="Active" <?php echo ($row['status'] === 'Active') ? 'selected' : ''; ?>>Active</option>
                    <option value="Inactive" <?php echo ($row['status'] === 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                    <option value="Archived" <?php echo ($row['status'] === 'Archived') ? 'selected' : ''; ?>>Archived</option>
                </select>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success" onclick="updateDepartment('<?php echo MD5(htmlspecialchars($row['id'])); ?>')">Update</button>
                <button type="button" class="btn btn-secondary" id="cancelBtn" onclick="hideUpdateOverlay()">Cancel</button>
            </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </form>
    
</div>