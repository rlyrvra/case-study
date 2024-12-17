function fetchAllLeaveRequests(page = 1){
    var pageNumber = getPage(page);
    $.ajax({
        url: 'leaves/leave-approvals/modules/leave-requests-api',
        type: 'POST',
        data: {
            action: 'fetchAll'
        },
        success: function(response) {
            $('#leave_requests_table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}