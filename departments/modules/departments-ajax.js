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
            filter_endDate: endDate
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
        departmentHeadId: departmentHeadId,
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
            document.getElementById('add-departments-form').reset();
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
        token: row.getAttribute('data-id'),
    };
    
    $.ajax({
        url: 'departments/modules/departments-api',
        type: 'POST',
        data: {
            action: 'delete',
            md5_id: departmentData.token
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
    const updateDepartmentForm = document.getElementById('update_departments_modal');
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
                md5_id: md5_id,
                name: departmentName,
                departmentHeadId: departmentHeadId,
                departmentDescription: departmentDescription,
                departmentStatus: departmentStatus
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