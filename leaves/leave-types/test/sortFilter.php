<div class="container mt-5">
<h4 class="mb-4">Sort Criteria:</h4>
<form onsubmit="event.preventDefault();" class="mb-4">
    <!-- Row for Entries, Sort By, Order By -->
    <fieldset class="row mb-3">
        <!-- Number of Entries -->
        <div class="col-md-4">
            <label for="entries" class="form-label">Number of Entries</label>
            <select id="entries" class="form-select">
                <option value="2" selected>2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
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
        <legend>Filter Criteria:</legend>

        <!-- Status -->
        <div class="col-md-4">
            <label for="status" class="form-label">Status</label>
            <select id="status" class="form-select">
                <option value="Active" selected>Active</option>
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
    <!-- Apply Button -->
    <button onclick="fetchAllSort()" class="btn btn-primary">Apply Filters</button>
</form>