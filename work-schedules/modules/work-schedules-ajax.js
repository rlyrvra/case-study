function fetchAllWorkSchedules(page = 1){
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

    var loadingSpinner = document.getElementById("loadingSpinner");
    loadingSpinner.classList.remove("visually-hidden");
    
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
        url: 'work-schedules/modules/work-schedules-api',
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
            $('#work-schedules-table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}