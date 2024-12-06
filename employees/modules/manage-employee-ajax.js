function fetchAllDepartments(page = 1) {
    // var numberEntries = $("#entries").val();
    // var sortByColumn = $("#sortBy").val();
    // var pageNumber = getPage(page);
    // if(sortByColumn == null) return;
    // var sortOrderBy = $("#orderBy").val();
    // if(sortOrderBy == null) return;
    // var filterStatus = $("#status").val();
    // var searchColumn = $("#searchColumn").val();
    // var dateColumn = $("#dateColumn").val();
    // var startDate, endDate;
    // if(dateColumn !== "none"){
    //     startDate = $("#dateStart").val();
    //     endDate = $("#dateEnd").val();
    // }
    // var search = $("#searchText").val();

    
    // console.log(`
    //     Number of Entries: ${numberEntries}, 
    //     Sort By Column: ${sortByColumn}, 
    //     Page Number: ${pageNumber}, 
    //     Sort Order By: ${sortOrderBy}, 
    //     Filter Status: ${filterStatus}, 
    //     Search At Column: ${searchColumn}, 
    //     Date Column: ${dateColumn}, 
    //     Start Date: ${startDate}, 
    //     End Date: ${endDate}, 
    //     Search Text: ${search}`);

        
    $.ajax({
        url: 'departments/modules/departments-api.php',
        type: 'POST',
        data: {
            action: 'fetchAll',
            page: 1,
            numberEntries: 10,
            sort_by: created_at,
            sort_order: DESC,
            filter_status: none,
            filter_searchAt: none,
            filter_search: '',
            filter_date_column: '',
            filter_startDate: '',
            filter_endDate: ''
        },
        success: function(response) {
            $('#departments-table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}