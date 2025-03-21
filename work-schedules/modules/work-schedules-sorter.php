<div class="controls d-flex justify-content-between flex-column flex-lg-row"> 
    <style>
        .space{
            padding-left: 5px;
        }
    </style>
    <!--View Mode-->
    <div class="col-auto d-flex align-items-center mx-1">
        <div class="btn-group">
            <input class="btn-check" type="radio" name="view" id="table-view" value="table" checked onchange="fetchAllWorkSchedules()">
            <label class="btn btn-outline-primary" for="table-view">
                <i class="bx bx-table"></i>
            </label>

            <input class="btn-check" type="radio" name="view" id="card-view" value="card" onchange="fetchAllWorkSchedules()">
            <label class="btn btn-outline-primary" for="card-view">
                <i class="bx bx-grid-alt"></i>
            </label>
        </div>
    </div>
    <div class="col-auto d-flex align-items-center mx-1">
        <!--Sort By dropdown-->
        <div class="ddropdown sort mx-1">
            <button
                class="btn btn-primary dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
            >
                Sort By <span class="tf-icons bx bx-sort"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="dropdownMenuButton">
                <li><a class="dropdown-item" href="#" data-group="sort_by" data-value="employee_id">Name</a></li>
                <li><a class="dropdown-item selected" href="#" data-group="sort_by" data-value="created_at">Date Created</a></li>
                <li><a class="dropdown-item" href="#" data-group="sort_by" data-value="updated_at">Date Modified</a></li>
                <li><hr/></li>
                <li><a class="dropdown-item" href="#" data-group="order_by" data-value="ASC">Ascending</a></li>
                <li><a class="dropdown-item selected" href="#" data-group="order_by" data-value="DESC">Descending</a></li>
            </ul>
        </div>
        <!--Filter By Date dropdown-->
        <div class="dropdown sort mx-1">
            <button
                class="btn btn-primary dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
            >
                Filter By Date <span class="tf-icons bx bx-sort"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="dropdownMenuButton">
                <li><a class="dropdown-item selected" href="#" data-group="by_date" data-value="">None</a></li>
                <li><a class="dropdown-item" href="#" data-group="by_date" data-value="created_at">Date Created</a></li>
                <li><a class="dropdown-item" href="#" data-group="by_date" data-value="updated_at">Date Modified</a></li>
                <li><hr/></li>
                <div class="space m-3">
                    <label for="dateStart" class="pb-1"><b>Start Date</b></label> 
                    <input type="date" id="dateStart"  class="form-control" required />
                </div>
                <div class="space m-3">
                    <label for="dateEnd" class="pb-1"><b>End Date</b></label> 
                    <input type="date" id="dateEnd"  class="form-control" required />
                </div>
            </ul>
        </div>  
    </div>

    <!--Entries Per Page -->
    <div class="align mx-1 d-flex align-items-center"> 
        <label for="entries-per-page" class="mx-1">Show:</label>
        <select class="form-select" id="entries-per-page" onchange="fetchAllWorkSchedules()">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <label for="entries-per-page" class="mx-1">Entries</label>  
    </div>

    <!--Filter By Status-->
    <div class="dropdown filter flex-fill col-auto  mx-1">
        <div class="input-group">
            <span class="input-group-text"><i class="bx bx-category-alt fs-4 lh-0"></i></span>
            <select class="form-select" id="status" name="status" placeholder="Filter By Status" onchange="fetchAllWorkSchedules()">
                <option value="" selected>All</option>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
                <option value="Archived">Archived</option>
            </select>
        </div>
    </div>

    <!--Search At-->
    <div class="search col-auto flex-fill col-auto mx-1">
        <div class="input-group">
        <span class="input-group-text"><i class="bx bx-search-alt-2 fs-4 lh-0"></i></span>
            <select class="form-select" id="search_at" name="search_at" placeholder="Search At">
                <option value="" selected>All</option>
                <option value="employee.full_name">Employee Name</option>
                <option value="department.name">Department Name</option>
                <option value="job_title.title">Job Title</option>
            </select>
            <input type="text" class="form-control" id="searchText" />
            <button id="openModalBtn" class="btn btn-success" onclick="fetchAllWorkSchedules()"> Search
            </button>
        </div>  
    </div>
</div>


<script>
//Dropdown Selection Highlight
const dropdownItems = document.querySelectorAll('.dropdown-item');
const dropdownButton = document.getElementById('dropdownMenuButton');

var selectedOptions = {
    sort_by: null,
    order_by: null,
    by_date: null};

dropdownItems.forEach(item => {
    item.addEventListener('click', (e) => {
    e.preventDefault();

    const group = item.getAttribute('data-group');
    const value = item.getAttribute('data-value');

    // Deselect previously selected option in the same group
    dropdownItems.forEach(option => {
    if (option.getAttribute('data-group') === group) {
        option.classList.remove('selected');
        }
    });
    
    // Select the clicked option
    item.classList.add('selected');
    selectedOptions[group] = value;

    // Update dropdown button text
    const selectedText = Object.values(selectedOptions)
    .filter(val => val)
    .map(val => val.replace('option', 'Option '))
    .join(', ');
    fetchAllWorkSchedules();

    });
});
</script>

<style>
.dropdown-item.selected {
    font-weight: bold;
    color: #4CAF50;
}
</style>