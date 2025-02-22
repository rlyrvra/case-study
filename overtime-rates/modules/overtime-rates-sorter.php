<div class="controls d-flex justify-content-between flex-column flex-lg-row"> 
    <div class="col d-flex align-items-center mx-1">
        <div class="input-group">
            <span class="input-group-text"><i class="bx bx-filter fs-4 lh-0"></i></span>
            <select class="form-select selectize-department-sorter" id="selectize_department_sorter" name="selectize-department-sorter" placeholder="Filter Department" onchange="fetchAllOvertimeRates();">
                
            </select>
        </div>
    </div>

    <div class="col d-flex align-items-center mx-1">
        <div class="input-group">
            <span class="input-group-text"><i class="bx bx-filter fs-4 lh-0"></i></span>
            <select class="form-select selectize-jobTitle-sorter" id="selectize_jobTitle_sorter" name="selectize-jobTitle-sorter" placeholder="Filter Job Titles" onchange="fetchAllOvertimeRates();">
                
            </select>
        </div>
    </div>

    <div class="col d-flex align-items-center mx-1">
        <div class="input-group">
            <span class="input-group-text"><i class="bx bx-filter fs-4 lh-0"></i></span>
            <select class="form-select selectize-employee-sorter" id="selectize_employee_sorter" name="selectize-employee-sorter" placeholder="Filter Employees" onchange="fetchAllOvertimeRates();">
                
            </select>
        </div>
    </div>

<style>
.selectize-control.selectize-department-sorter .selectize-input > div .description {
  opacity: 0.8;
}
.selectize-control.selectize-department-sorter .selectize-input > div .name + .description {
  margin-left: 5px;
}
.selectize-control.selectize-department-sorter .selectize-input > div .description:before {
  content: "<";
}
.selectize-control.selectize-department-sorter .selectize-input > div .description:after {
  content: ">";
}
.selectize-control.selectize-department-sorter .selectize-dropdown .caption {
  font-size: 12px;
  display: block;
  color: #a0a0a0;
}
</style>

<style>
.selectize-control.selectize-jobTitle-sorter .selectize-input > div .description {
  opacity: 0.8;
}
.selectize-control.selectize-jobTitle-sorter .selectize-input > div .name + .description {
  margin-left: 5px;
}
.selectize-control.selectize-jobTitle-sorter .selectize-input > div .description:before {
  content: "<";
}
.selectize-control.selectize-jobTitle-sorter .selectize-input > div .description:after {
  content: ">";
}
.selectize-control.selectize-jobTitle-sorter .selectize-dropdown .caption {
  font-size: 12px;
  display: block;
  color: #a0a0a0;
}
</style>

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

</div>