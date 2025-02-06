function fetchAllDepartments(page = 1) {
    console.log(page);
    $.ajax({
        url: 'apiTest.php',
        method: 'POST',
        data: {
            action: 'fetchAll',
            page: page
        },
        dataType: 'html',
        success(response) {
            $('#departments').html(response);
        },
        error(xhr, status, error) {
            console.error("Error fetching departments:", error);
        }
    });
}

function fetchAllSort(page = 1){
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
        url: 'apiTest.php',
        type: 'POST',
        data: {
            action: 'fetchAllSort',
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
            $('#departments').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function createDepartment() {
    const departmentName = document.getElementById('createDepartmentName').value;
    const departmentHeadId = document.getElementById('createDepartmentHeadId').value;

    const departmentData = {
        name: departmentName,
        departmentHeadId: departmentHeadId
    };
    $.ajax({
        url: 'apiTest.php',
        method: 'POST',
        data: {
            action: 'create',
            department: departmentData
        },
        success: function(response) {
            $('#responseTest').html(response);
            fetchAllSort();
            document.getElementById('createDepartmentForm').reset();
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
        url: 'apiTest.php',
        type: 'POST',
        data: {
            action: 'delete',
            md5_id: departmentData.token
        },
        success: function(response) {
            $('#departments').html(response);
            fetchAllSort();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
    
}

function updateDepartment(button){
    var md5_id = button.getAttribute('data-token');;
    var departmentName = document.getElementById('updateDepartmentName').value;
    var departmentHeadId = document.getElementById('updateDepartmentHeadId').value;
    var departmentDescription = document.getElementById('updateDepartmentDescription').value;
    var departmentStatus = document.getElementById('updateDepartmentStatus').value;

    console.log(`MD5 ID: ${md5_id}, 
        Department Name: ${departmentName}, 
        Department Head ID: ${departmentHeadId}, 
        Department Description: ${departmentDescription}, 
        Department Status: ${departmentStatus}`);

    $.ajax({
        url: 'apiTest.php',
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
            showSuccessAlert();
            fetchAllSort();
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
    
}


// $(document).on('click', '.page-link', function(e) {
//     e.preventDefault();
//     const page = $(this).data('page');
//     fetchAllDepartments(page);
// });