<style>
</style>
<form onsubmit="event.preventDefault();" class="container-fluid p-2">
    <legend>Sort Criteria:</legend>
    <!-- Row for Entries, Sort By, Order By -->
    <fieldset class="row mb-3">
        <!-- Number of Entries -->
        <div class="col-md-4">
            <label for="entries" class="form-label">Number of Entries</label>
            <select id="entries" class="form-select">
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>

        <!-- Sort By -->
        <div class="col-md-4">
            <label for="sortBy" class="form-label">Sort By</label>
            <select id="sortBy" class="form-select">
                <option value="name">Name</option>
                <option value="created_at" selected>Created At</option>
                <option value="updated_at">Updated At</option>
            </select>
        </div>

        <!-- Order By -->
        <div class="col-md-4">
            <label for="orderBy" class="form-label">Order By</label>
            <select id="orderBy" class="form-select">
                <option value="ASC">Ascending</option>
                <option value="DESC" selected>Descending</option>
            </select>
        </div>
    </fieldset>

    <!-- Filter By Section -->
    <fieldset class="row mb-3">
        <legend>Filter By:</legend>

        <!-- Status -->
        <div class="col-md-4">
            <label for="status" class="form-label">Status</label>
            <select id="status" class="form-select" onchange="toggleDeletedAtOption()">
                <option value="" selected>All</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
                <option value="Archived">Archived</option>
            </select>
        </div>

        <!-- Search At: -->
        <div class="col-md-4">
            <label class="form-label">Search At:</label>
            <div class="row">
                <div class="col">
                <select id="searchColumn" class="form-select">
                    <option value="name" selected>Name</option>
                    <option value="description">Description</option>
                </select>
                </div>
                <div class="col">
                    <input type="text" id="searchText" class="form-control" placeholder="Enter text">
                </div>
            </div>
        </div>

        <!-- Date Modified -->
        <div class="col-md-4">
            <label class="form-label">At Date:</label>
            <div class="row g-1">
                <div class="col-4">
                    <select id="dateColumn" class="form-select">
                        <option value="none">None</option>
                        <option value="created_at">Date Created</option>
                        <option value="updated_at">Date Modified</option>
                    </select>
                </div>
                <div class="col-4">
                    <input type="date" id="dateStart" class="form-control" placeholder="Start Date">
                </div>
                <div class="col-4">
                    <input type="date" id="dateEnd" class="form-control" placeholder="End Date">
                </div>
            </div>
        </div>
    </fieldset>

    <!-- Submit Button -->
    <button onclick="fetchAllDepartments()" class="btn btn-primary">Apply Filters</button>
</form>