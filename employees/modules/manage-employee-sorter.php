<div class="controls row align-items-center">

    <!-- Sort By -->
    <div class="col-lg-auto col-md-6">
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bx bx-sort-alt-2"></i> Sort By
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" data-group="sort_by" data-value="full_name">Name</a></li>
                <li><a class="dropdown-item selected" href="#" data-group="sort_by" data-value="created_at">Date Created</a></li>
                <li><a class="dropdown-item" href="#" data-group="sort_by" data-value="updated_at">Date Modified</a></li>
                <li><hr/></li>
                <li><a class="dropdown-item" href="#" data-group="order_by" data-value="ASC">Ascending</a></li>
                <li><a class="dropdown-item selected" href="#" data-group="order_by" data-value="DESC">Descending</a></li>
            </ul>
        </div>
    </div>

    <!-- Entries Per Page -->
    <div class="col-lg-auto col-md-6 d-flex align-items-center">
        <label for="entries-per-page" class="me-2">Show</label>
        <select class="form-select w-auto" id="entries-per-page" onchange="fetchAllEmployees();">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <label for="entries-per-page" class="ms-2">Entries</label>
    </div>

    <!-- Filter by Department (Larger Size) -->
    <div class="col-lg-4 col-md-6">
        <div class="input-group">
            <span class="input-group-text"><i class="bx bx-filter"></i></span>
            <select class="form-select selectize-department-sorter" id="selectize_department_sorter" name="selectize-department-sorter" placeholder="Filter Department" onchange="fetchAllEmployees();">
            </select>
        </div>
    </div>

    <!-- Search (Smaller Search Dropdown, Larger Text Field) -->
    <div class="col-lg flex-grow-1">
        <div class="input-group">
            <span class="input-group-text"><i class="bx bx-search"></i></span>
            <select class="form-select" id="search_at" name="search_at" style="width: 70px;">
                <option value="none" selected>All</option>
                <option value="full_name">Name</option>
                <option value="title">Job Title</option>
                <option value="email">Email</option>
                <option value="employee_code">Employee Code</option>
            </select>
            <input type="text" class="form-control" id="searchText" placeholder="Enter search text" style="flex-grow: 2;">
            <button id="openModalBtn" class="btn btn-success" onclick="fetchAllEmployees()">
                <i class="bx bx-search"></i> Search
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
    order_by: null};

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
    fetchAllEmployees();

    });
});
</script>

<style>
.dropdown-item.selected {
    font-weight: bold;
    color: #4CAF50;
}
</style>