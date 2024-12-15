function fetchAllDepartments(page = 1) {
    var numberEntries = $("#entries").val();
    var sortByColumn = $("#sortBy").val();
    var pageNumber = getPage(page);
    if(sortByColumn == null) return;
    var sortOrderBy = $("#orderBy").val();
    if(sortOrderBy == null) return;
    var filterStatus = $("#status").val();
    var searchColumn = $("#searchColumn").val();
    var dateColumn = $("#dateColumn").val();
    var startDate, endDate;
    if(dateColumn !== "none"){
        startDate = $("#dateStart").val();
        endDate = $("#dateEnd").val();
    }
    var search = $("#searchText").val();

    
    console.log(`
        Number of Entries: ${numberEntries}, 
        Sort By Column: ${sortByColumn}, 
        Page Number: ${pageNumber}, 
        Sort Order By: ${sortOrderBy}, 
        Filter Status: ${filterStatus}, 
        Search At Column: ${searchColumn}, 
        Date Column: ${dateColumn}, 
        Start Date: ${startDate}, 
        End Date: ${endDate}, 
        Search Text: ${search}`);

        
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
            $('#departments-table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}


function createDepartment() {
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
            $('#departments-table').html(response);
            fetchAllDepartments();
            document.getElementById('add-departments-form').reset();
            showCreatedSuccessAlert();
        },
        error(xhr, status, error) {
            console.error("Error creating department:", error);
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
            $('#departments').html(response);
            fetchAllDepartments();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
    
}

function updateDepartment(button){
    var md5_id = button.getAttribute('data-token');
    var departmentName = document.getElementById('update_department_name').value;
    var departmentHeadId = document.getElementById('update_department_head').value;
    var departmentDescription = document.getElementById('update_department_description').value;
    var departmentStatus = document.getElementById('update_department_status').value;

    console.log(`MD5 ID: ${md5_id}, 
        Department Name: ${departmentName}, 
        Department Head ID: ${departmentHeadId}, 
        Department Description: ${departmentDescription}, 
        Department Status: ${departmentStatus}`);

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
            $('#responseTest').html(response);
            showSuccessUpdate();
            fetchAllDepartments();
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
    
}