<div class="controls d-flex justify-content-between flex-column flex-lg-row"> 
    <!--Entries Per Page Text-->
    <div class="align mx-1 d-flex align-items-center"> 
        <label for="entries-per-page" class="mx-1">Show:</label>
        <select id="entries-per-page">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <label for="entries-per-page" class="mx-1" >Entries</label>  
    </div>
    
    <!-- Sort By -->
    <div class="dropdown sort mx-1 d-flex align align-items-center">
    <button
        class="btn btn-outline-primary dropdown-toggle"
        type="button"
        data-bs-toggle="dropdown"
        aria-expanded="false"
    >
        Sort By <span class="tf-icons bx bx-sort"></span>
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
    <div class="dropdown filter flex-fill w-25 col-auto mx-1">
        <div class="input-group">
            <span class="input-group-text"><i class="bx bx-filter fs-4 lh-0"></i></span>
            <select class="form-select selectize-department-sorter" id="selectize_department_sorter" name="selectize-department-sorter" placeholder="Filter Department" onchange="fetchAllEmployees();">
                
            </select>
        </div>
    </div>  
    <div class="search col-auto flex-fill mx-1 d-flex align align-items-center">
        <div class="input-group">
            <span class="input-group-text"><i class="bx bx-category fs-4 lh-0"></i></span>
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