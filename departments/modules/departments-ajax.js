function fetchAllDepartments(page = 1) {
    var numberEntries = $("#entries-per-page").val();
    var sortByColumn = getSortByColumn();
    var pageNumber = getPage(page);
    if(sortByColumn == null){
        sortByColumn = "created_at";
    };
    var sortOrderBy = getOrderBy();
    if(sortOrderBy == null) {
        sortOrderBy = "DESC";
    };
    var filterStatus = $("#status").val();
    var searchColumn = $("#search_at").val();
    if(searchColumn == 'none'){
        searchColumn = "";
    };
    var dateColumn = getByDate();
    var startDate, endDate;
    if(dateColumn){
        startDate = $("#dateStart").val();
        endDate = $("#dateEnd").val();
    }
    var search = $("#searchText").val();
    var viewMode = getViewMode();


    var loadingSpinner = document.getElementById("loadingSpinner");
    loadingSpinner.classList.remove("visually-hidden");


    if(!skeletonLoaded){
        loadSkeletonView(7, ['Name', 'DEPARTMENT HEAD', 'DESCRIPTION', 'STATUS', 'Created At', 'Updated At'] , numberEntries, document.getElementById("skeleton-departments-table"));
        document.getElementById('skeleton-departments-table').classList.remove("visually-hidden");
        document.getElementById('departments-table').classList.add("visually-hidden");
        skeletonLoaded = true;
    }else{
        document.getElementById('skeleton-departments-table').classList.remove("visually-hidden");
        document.getElementById('departments-table').classList.add("visually-hidden");
    }

    
    
    $.ajax({
        url: 'departments/modules/departments-api',
        type: 'POST',
        data: {
            action: 'fetchAll',
            page: pageNumber,
            numberEntries: numberEntries,
            sort_by: sortByColumn,
            sort_order: sortOrderBy,
            filter_status: filterStatus,
            filter_searchAt: searchColumn,
            filter_search: search,
            filter_date_column: dateColumn,
            filter_startDate: startDate,
            filter_endDate: endDate,
            view_mode: viewMode
        },
        success: function(response) {
            loadingSpinner.classList.add("visually-hidden");
            document.getElementById('skeleton-departments-table').classList.add("visually-hidden");
            document.getElementById('departments-table').classList.remove("visually-hidden");
            $('#departments-table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
            showFatalError("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}


function createDepartment() {
    const addDepartmentForm = document.getElementById('add-departments-form');
    if(addDepartmentForm.checkValidity() === false){
        return;
    };
    const departmentName = document.getElementById('create_department_name').value;
    const departmentHeadId = document.getElementById('create_department_head').value;
    const departmentDescription = document.getElementById('create_department_description').value;
    const departmentStatus = document.getElementById('create_department_status').value;

    const departmentData = {
        name: departmentName,
        department_head_id: departmentHeadId,
        description: departmentDescription,
        status: departmentStatus
    };


    $.ajax({
        url: 'departments/modules/departments-api',
        method: 'POST',
        data: {
            action: 'create',
            department: departmentData
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchAllDepartments();
        },
        error(xhr, status, error) {
            console.error("Error creating department:", error);
            showFatalError("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function deleteDepartment(button){
    const row = button.closest('tr');  // Get the closest row
    const departmentData = {
        id: row.getAttribute('data-id'),
    };
    console.log(departmentData);
    $.ajax({
        url: 'departments/modules/departments-api',
        type: 'POST',
        data: {
            action: 'delete',
            department: departmentData
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchAllDepartments();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
            showFatalError("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
    
}

function updateDepartment(button){
    const updateDepartmentForm = document.getElementById('update_departments_form');
    if(updateDepartmentForm.checkValidity() === false){
        return;
    };
    var md5_id = button.getAttribute('data-token');
    var departmentName = document.getElementById('update_department_name').value;
    var departmentHeadId = document.getElementById('update_department_head').value;
    var departmentDescription = document.getElementById('update_department_description').value;
    var departmentStatus = document.getElementById('update_department_status').value;

    $.ajax({
        url: 'departments/modules/departments-api',
        type: 'POST',
        data: {
            action: 'update',
            department: {
                id: md5_id,
                name: departmentName,
                department_head_id: departmentHeadId,
                description: departmentDescription,
                status: departmentStatus
            }
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchAllDepartments();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
            showFatalError("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
    
}

function printFetchAll(){
    var type = $('#print_record').val();
    var numberEntries = $("#print-entries-per-page").val();
    var sortByColumn = getPrintSortByColumn();
    if(sortByColumn == null){
        sortByColumn = "created_at";
    };
    var sortOrderBy = getPrintOrderBy();
    if(sortOrderBy == null) {
        sortOrderBy = "DESC";
    };
    var filterStatus = $("#print-status").val();
    var searchColumn = $("#print-search_at").val();
    if(searchColumn == 'none'){
        searchColumn = "";
    };
    var dateColumn = getPrintByDate();
    var startDate, endDate;
    if(dateColumn){
        startDate = $("#print-dateStart").val();
        endDate = $("#print-dateEnd").val();
    }
    var search = $("#print-searchText").val();
    const time = $('#time').text();
    const date = $('#date').text();
    showSpinnerLoader();
    $.ajax({
        url: 'departments/modules/departments-api',
        type: "POST",
        data: {
            action: "printFetch",
            type: type,
            numberEntries: numberEntries,
            sort_by: sortByColumn,
            sort_order: sortOrderBy,
            filter_status: filterStatus,
            filter_searchAt: searchColumn,
            filter_search: search,
            filter_date_column: dateColumn,
            filter_startDate: startDate,
            filter_endDate: endDate
        },
        xhrFields: { responseType: 'blob' }, // Expect binary data
        success: function (response) {
            var blob = new Blob([response], { type: "application/pdf" });
            var link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = `department_record${date}${time}.pdf`;
            link.click();
            closeSpinnerLoader();
            // $('#response-test').html(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        },
    });
}