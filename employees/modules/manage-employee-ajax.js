function fetchAllEmployees(page = 1) {
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
    // var filterStatus = $("#status").val();
    var searchColumn = $("#search_at").val();
    if(searchColumn == 'none'){
        searchColumn = "";
    };
    // var dateColumn = $("#dateColumn").val();
    // var startDate, endDate;
    // if(dateColumn !== "none"){
    //     startDate = $("#dateStart").val();
    //     endDate = $("#dateEnd").val();
    // }
    var search = $("#searchText").val();
    var filterByDepartment = $("#selectize_department_sorter").val();

    
    // console.log(`
    //     Number of Entries: ${numberEntries}, 
    //     Sort By Column: ${sortByColumn}, 
    //     Page Number: ${pageNumber}, 
    //     Sort Order By: ${sortOrderBy}, 
    //     Search At Column: ${searchColumn}, 
    //     Search Text: ${search},
    //     Department ID: ${filterByDepartment}`);

        
    $.ajax({
        url: 'employees/modules/manage-employee-api',
        type: 'POST',
        data: {
            action: 'fetchAll',
            page: pageNumber,
            numberEntries: numberEntries,
            sort_by: sortByColumn,
            sort_order: sortOrderBy,
            filter_status: '',
            filter_searchAt: searchColumn,
            filter_search: search,
            filter_department_id: filterByDepartment,
            filter_date_column: '',
            filter_startDate: '',
            filter_endDate: ''
        },
        success: function(response) {
            $('#manage-employee-table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function deleteEmployee(button){
    const row = button;  // Get the closest row
    const employeeData = {
        token: row.getAttribute('data-id'),
    };
    
    $.ajax({
        url: 'employees/modules/manage-employee-api',
        type: 'POST',
        data: {
            action: 'delete',
            md5_id: employeeData.token
        },
        success: function(response) {
            $('#response-test').html(response);
            //fetchAllEmployees();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
    
}