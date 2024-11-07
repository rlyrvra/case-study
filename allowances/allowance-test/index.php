<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<body>
    <div class="container mt-5">
    <h2>Add Allowances</h2>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.43/moment-timezone-with-data.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="ajax-requests.js?v=1.1"></script>
    <div class="container mt-5">
        <h4 class="mb-4">Add Allowances</h4>
        <div class="container">
            <form onsubmit='event.preventDefault()' id="allowance-form">
            <!-- Name -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" maxlength="50" required>
            </div>

            <!-- Amount -->
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" class="form-control" id="amount" name="amount" step="0.01" required>
            </div>

            <!-- Is Taxable -->
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="is_taxable" name="is_taxable">
                <label class="form-check-label" for="is_taxable">Is Taxable</label>
            </div>

            <!-- Frequency -->
            <div class="form-group">
                <label for="frequency">Frequency</label>
                <select class="form-control" id="frequency" name="frequency" required>
                    <option value="">Select Frequency</option>
                    <option value="Weekly">Weekly</option>
                    <option value="Bi-weekly">Bi-weekly</option>
                    <option value="Semi-monthly">Semi-monthly</option>
                    <option value="Monthly">Monthly</option>
                </select>
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" maxlength="255"></textarea>
            </div>

            <!-- Status -->
            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Archived">Archived</option>
                </select>
            </div>

            <!-- Effective Date -->
            <div class="form-group">
                <label for="effective_date">Effective Date</label>
                <input type="date" class="form-control" id="effective_date" name="effective_date" required>
            </div>

            <!-- End Date -->
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary" onclick="create()">Submit</button>
            </form>
        </div>
        <button type="submit" class="btn btn-primary" onclick="fetchAll()">Load Table</button>
        
        

        <div class="mb-3" id="job_title_preview">

        </div>
        <div class="container">
            <h2>Allowances Table</h2>
        </div>
        <div class="mb-3" id="allowance_table">

        </div>
    </div>
</body>
