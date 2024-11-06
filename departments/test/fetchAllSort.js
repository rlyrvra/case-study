function fetchAllSort(){
    var numberEntries = $("#entries").val();
    var sortByColumn = $("#sortBy").val();
    
    
    if(sortByColumn == null) return;
    var sortOrderBy = $("#orderBy").val();
    if(sortOrderBy == null) return;
    var filterStatus = $("#status").val();
    var dateColumn = $("#dateColumn").val();
    console.log(dateColumn);
    var startDate, endDate;
    if(dateColumn !== "none"){
        startDate = $("#dateStart").val();
        endDate = $("#dateEnd").val();
    }
    var search = $("#searchText").val();
    console.log("Search Text:", search);
    console.log("Start Date:", startDate);
    console.log("End Date:", endDate);
    $.ajax({
        url: 'apiTest.php',
        type: 'POST',
        data: {
            action: 'fetchAllSort',
            numberEntries: numberEntries,
            sort_by: sortByColumn,
            sort_order: sortOrderBy,
            filter_status: filterStatus,
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