<div class="controls d-flex justify-content-between align-content-center flex-column flex-lg-row"> 
    <!--View Mode-->
    <div class="col-auto d-flex align-items-center mx-1">
        <div class="btn-group">
            <input class="btn-check" type="radio" name="view" id="table-view" value="table" checked onchange="fetchAllMyAttendance()">
            <label class="btn btn-outline-primary" for="table-view">
                <i class="bx bx-table"></i>
            </label>

            <input class="btn-check" type="radio" name="view" id="card-view" value="card" onchange="fetchAllMyAttendance()">
            <label class="btn btn-outline-primary" for="card-view">
                <i class="bx bx-grid-alt"></i>
            </label>
        </div>
    </div>
    <div class="col-auto d-flex align-items-center mx-1">
        <!--Sort By dropdown-->
        <div class="dropdown sort mx-1">
            <button
                class="btn btn-primary dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
            >
                Sort By <span class="tf-icons bx bx-sort"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="dropdownMenuButton">
                <li><a class="dropdown-item" href="#" data-group="sort_by" data-value="name">Name</a></li>
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
                <div class="space p-2">
                    <p class="m-0 mx-3"><b>Start</b></p>
                    <input type="date" id="dateStart"  class="form-control" required />
                </div>
                <div class="space p-2">
                    <p class="m-0 mx-3"><b>End</b></p>
                    <input type="date" id="dateEnd"  class="form-control" required />
                </div>
            </ul>
        </div>  

        <!--Filter By Records dropdown-->
        <div class="dropdown sort mx-1">
            <button
                class="btn btn-primary dropdown-toggle"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
            >
                Filter By Records <span class="tf-icons bx bx-sort"></span>
            </button>
            <ul class="dropdown-menu byRecords" aria-labelledby="dropdownMenuButton" id="dropdownMenuButton">
                <li><a class="dropdown-item selected" href="#" data-group="by_record" data-value="">None</a></li>
            </ul>
        </div> 
    </div>

    <!--Entries Per Page -->
    <div class="align mx-1 d-flex align-items-center"> 
        <label for="entries-per-page" class="mx-1">Show</label>
        <select class="form-select" id="entries-per-page" onchange="fetchAllMyAttendance()">
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
            <select class="form-select" id="status" name="status" placeholder="Filter By Status" onchange="fetchAllMyAttendance()">
                <option value="" selected>All</option>
                <option value="Present">Present</option>
                <option value="Late">Late</option>
                <option value="Absent">Absent</option>
                <option value="Undertime">Undertime</option>
                <option value="Overtime">Overtime</option>
            </select>
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
    by_date: null,
    by_record: null};

$(document).ready(function() {
    addItemListener(dropdownItems);
});

function addItemListener(dropdownItems){
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
        fetchAllMyAttendance();

        });
    });
}

</script>

<style>
.dropdown-item.selected {
    font-weight: bold;
    color: #4CAF50;
}
</style>