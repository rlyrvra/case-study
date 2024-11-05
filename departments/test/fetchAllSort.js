function fetchAllSort(page){
    var numberEntries = $("#entries").val();
    var sortByColumn = $("#sortBy").val();
    
    
    if(sortByColumn == null) return;
    var sortOrderBy = $("#orderBy").val();
    if(sortOrderBy == null) return;
    var filterStatus = $("#status").val();
    console.log(filterStatus);
    var startDate = $("#dateCreatedStart").val();
    
    $.ajax({
        url: 'apiTest.php',
        type: 'POST',
        data: {
            action: 'fetchAllSort',
            numberEntries: numberEntries,
            sort_by: sortByColumn,
            sort_order: sortOrderBy,
            filter_status: filterStatus
        },
        success: function(response) {
            $('#departments').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}