<div class="controls d-flex justify-content-between flex-column flex-lg-row"> <!--Entries Per Page Text-->
    <div class="align col-auto mx-1 d-flex align-items-center"> 
        <label for="entries-per-page">Show:</label>
        <select id="entries-per-page">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
        </select>
        <label for="entries-per-page">Entries</label>  
    </div>
    
    <div class="dropdown col-auto mx-1 d-flex align-items-center sort mx-1">
        <button
            class="btn btn-primary dropdown-toggle"
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
    <div class="dropdown filter col-auto  mx-1">
        <div class="input-group">
            <span class="input-group-text"><i class="bx bx-category-alt fs-4 lh-0"></i></span>
            <select class="form-select" id="status" name="status" placeholder="Filter Department" onchange="">
                <option value="" selected>All</option>
                <option value="Approved">Approved</option>
                <option value="Rejected">Rejected</option>
                <option value="Canceled">Canceled</option>
            </select>
        </div>
    </div>  
    <div class="dropdown flex-fill col-auto mx-1">
        <div class="input-group">
            <span class="input-group-text"><i class="bx bx-category fs-4 lh-0"></i></span>
            <select class="form-select" id="search_at" name="search_at" placeholder="Search At">
                <option value="none" selected>All</option>
                <option value="name">Leave Type</option>
                <option value="full_name">Employee Name</option>
                <option value="title">Job Title</option>
                <option value="email">Email</option>
            </select>
        </div>
    </div>
    <div class="search flex-fill">
        <div class="input-group ms-lg-1">
            <span class="input-group-text"><i class="bx bx-search-alt-2 fs-4 lh-0"></i></span>
            <input type="text" class="form-control" id="searchText" />
            <button id="openModalBtn" class="btn btn-success" onclick=""> Search
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
    //fetchAllEmployees();

    });
});
</script>

<style>
.dropdown-item.selected {
    font-weight: bold;
    color: #4CAF50;
}
</style>