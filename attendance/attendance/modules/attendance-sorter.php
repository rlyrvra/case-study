<div class="controls d-flex justify-content-between align-content-center flex-column flex-lg-row"> 
    <!--View Mode-->
    <div class="col-auto d-flex align-items-center mx-1">
        <div class="btn-group">
            <input class="btn-check" type="radio" name="view" id="table-view" value="table" checked onchange="fetchAllAttendance()">
            <label class="btn btn-outline-primary" for="table-view">
                <i class="bx bx-table"></i>
            </label>

            <input class="btn-check" type="radio" name="view" id="card-view" value="card" onchange="fetchAllAttendance()">
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
                <li><a class="dropdown-item" href="#" data-group="sort_by" data-value="id">Name</a></li>
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
    </div>
    

    <!--Entries Per Page -->
    <div class="align mx-1 d-flex align-items-center"> 
        <label for="entries-per-page" class="mx-1">Show</label>
        <select class="form-select" id="entries-per-page" onchange="fetchAllAttendance()">
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
            <select class="form-select" id="status" name="status" placeholder="Filter By Status" onchange="fetchAllAttendance()">
                <option value="" selected>All</option>
                <option value="Present">Present</option>
                <option value="Late">Late</option>
                <option value="Absent">Absent</option>
                <option value="Undertime">Undertime</option>
                <option value="Overtime">Overtime</option>
            </select>
        </div>
    </div>
    <div class="dropdown filter flex-fill col-auto  mx-1">
        <div class="input-group">
            <span class="input-group-text"><i class="bx bx-filter fs-4 lh-0"></i></span>
            <select class="form-select selectize-employee-sorter" id="selectize_employee_sorter" name="selectize-employee-sorter" placeholder="Filter Employee" onchange="fetchAllAttendance();">
                
            </select>
        </div>
    </div>

    
</div>

<style>
.selectize-control.selectize-employee-sorter .selectize-input > div .description {
  opacity: 0.8;
}
.selectize-control.selectize-employee-sorter .selectize-input > div .name + .description {
  margin-left: 5px;
}
.selectize-control.selectize-employee-sorter .selectize-input > div .description:before {
  content: "<";
}
.selectize-control.selectize-employee-sorter .selectize-input > div .description:after {
  content: ">";
}
.selectize-control.selectize-employee-sorter .selectize-dropdown .caption {
  font-size: 12px;
  display: block;
  color: #a0a0a0;
}
</style>



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
    fetchAllAttendance();

    });
});
</script>


<script>
  $(document).ready(function () {
  const REGEX_EMAIL = "([a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@" + "(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)";
  $("#selectize_employee_sorter").selectize({
      persist: false,
      maxItems: 1,
      placeholder: 'Select an employee',
      allowEmptyOption: true,
      valueField: "id",
      valueField: "id",
      labelField: "description",
      searchField: ["full_name", "email_address"],
      options: employees,
      render: {
      item: function (item, escape) {
          return (
          "<div>" +
          (item.full_name
              ? '<span class="name">' + escape(item.full_name) + "</span>"
              : "") +
          (item.email_address
              ? '<span class="description">' + escape(item.email_address) + "</span>"
              : "") +
          "</div>"
          );
      },
      option: function (item, escape) {
          var label = item.full_name || item.email_address;
          var caption = item.full_name ? item.email_address : null;
          return (
          "<div>" +
          '<span class="label">' +
          escape(label) +
          "</span>" +
          (caption
              ? '<span class="caption">' + escape(caption) + "</span>"
              : "") +
          "</div>"
          );
      },
      },
      createFilter: function (input) {
      var match, regex;

      // email@address.com
      regex = new RegExp("^" + REGEX_EMAIL + "$", "i");
      match = input.match(regex);
      if (match) return !this.options.hasOwnProperty(match[0]);

      // name <email@address.com>
      regex = new RegExp("^([^<]*)<" + REGEX_EMAIL + ">$", "i");
      match = input.match(regex);
      if (match) return !this.options.hasOwnProperty(match[2]);

      return false;
      },
      create: function (input) {
      if (new RegExp("^" + REGEX_EMAIL + "$", "i").test(input)) {
          return { email: input };
      }
      var match = input.match(
          new RegExp("^([^<]*)<" + REGEX_EMAIL + ">$", "i")
      );
      if (match) {
          return {
          email: match[2],
          name: $.trim(match[1]),
          };
      }
      alert("Invalid email address.");
      return false;
      },
  });
});
</script>

<style>
.dropdown-item.selected {
    font-weight: bold;
    color: #4CAF50;
}
</style>