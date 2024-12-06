<div class="controls d-flex justify-content-between flex-column flex-lg-row"> <!--Entries Per Page Text-->
    <div class="align col-auto flex-fill mx-2"> 
        <label for="entries-per-page">Show:</label>
        <select id="entries-per-page">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <label for="entries-per-page">Entries</label>  
    </div>
    
    <div class="dropdown sort col-auto flex-fill mx-2">
    <button
        class="btn btn-default dropdown-toggle"
        type="button"
        data-bs-toggle="dropdown"
        aria-expanded="false"
    >
        Sort By <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="dropdownMenuButton">
        <li><a class="dropdown-item" href="#" data-group="sort_by" data-value="full_name">Name</a></li>
        <li><a class="dropdown-item selected" href="#" data-group="sort_by" data-value="created_at">Date Created</a></li>
        <li><a class="dropdown-item" href="#" data-group="sort_by" data-value="updated_at">Date Modified</a></li>
        <li><hr/></li>
        <li><a class="dropdown-item" href="#" data-group="order_by" data-value="ASC">Ascending</a></li>
        <li><a class="dropdown-item selected" href="#" data-group="order_by" data-value="DESC">Descending</a></li>
    </ul>
    </div>  
    <div class="dropdown filter col-auto flex-fill mx-2">
        <select class="form-select selectize-department-sorter" id="selectize_department_sorter" name="selectize-department-sorter" placeholder="Filter Department" onchange="fetchAllEmployees();">
            
        </select>
    </div>  
    <div class="search col-auto d-flex flex-column flex-lg-row mx-2">
        <select class="form-select" id="search_at" name="search_at" placeholder="Search At">
            <option value="none" selected>All</option>
            <option value="full_name">Name</option>
            <option value="title">Job Title</option>
            <option value="email">Email</option>
            <option value="employee_code">Employee Code</option>
        </select>
        <input type="text" class="form-control" id="searchText" />
        <button id="openModalBtn" class="btn btn-success" onclick="fetchAllEmployees()"> Search
        </button>
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