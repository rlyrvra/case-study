<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
</head>
<body>

    <!-- Button to Show the Form -->
    <button class="btn btn-primary" id="showFormBtn">Edit Department</button>

    <!-- Full-Screen Overlay (Initially Hidden) -->
    <div class="overlay" id="overlay" style="display: none;"></div>

    <!-- Form Container (Initially Hidden) -->
    <div class="form-container" id="formContainer" style="display: none;">
        <form action="#" method="post">
            <div class="mb-3">
                <label for="departmentName" class="form-label">Department Name</label>
                <input type="text" class="form-control" id="departmentName" name="name" required>
            </div>
            <div class="mb-3">
                <label for="departmentHeadId" class="form-label">Department Head ID</label>
                <input type="number" class="form-control" id="departmentHeadId" name="departmentHeadId">
            </div>
            <div class="mb-3">
                <label for="departmentDescription" class="form-label">Department Description</label>
                <textarea class="form-control" id="departmentDescription" name="departmentDescription"></textarea>
            </div>
            <div class="mb-3">
                <label for="departmentStatus" class="form-label">Department Status</label>
                <select class="form-select" id="departmentStatus" name="departmentStatus">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Archived">Archived</option>
                </select>
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Update</button>
                <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS (optional for dropdowns, etc.) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>