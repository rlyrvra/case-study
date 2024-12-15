function fetchAllLeaveTypes(page = 1){
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
        url: 'leaves/modules/leave-types-api',
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
            $('#leave-types-table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function createLeaveTypes(){
    const leaveTypeName = document.getElementById('add_name').value;
    const maxNumber = document.getElementById('add_maximum_number_of_days').value;
    const isPaid = document.getElementById('add_is_paid').checked;
    const description = document.getElementById('add_description').value;
    const status = document.getElementById('add_status').value;

    const leaveTypeData = {
        name: leaveTypeName,
        maximum_number_of_days: maxNumber,
        is_paid: isPaid,
        description: description,
        status: status
    };
    
    $.ajax({
        url: 'leaves/modules/leave-types-api',
        method: 'POST',
        data: {
            action: 'create',
            leave_type: leaveTypeData
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchAllLeaveTypes();
            document.getElementById('add_leave_type_form').reset();
        },
        error(xhr, status, error) {
            console.error("Error creating leave types:", error);
        }
    });
}

function updateLeaveType(button){
    const token = button.getAttribute('data-token');

    const leaveTypeName = document.getElementById('update_name').value;
    const maxNumber = document.getElementById('update_maximum_number_of_days').value;
    const isPaid = document.getElementById('update_is_paid').checked;
    const description = document.getElementById('update_description').value;
    const status = document.getElementById('update_status').value;
    
    // console.log(`Leave Type Name: ${leaveTypeName}, 
    //     Max Number of Days: ${maxNumber}, 
    //     Is Paid: ${isPaid}, 
    //     Description: ${description}, 
    //     Status: ${status}`);
    $.ajax({
        url: 'leaves/modules/leave-types-api',
        type: 'POST',
        data: {
            action: 'update',
            md5_id: token,
            leave_type: {
                name: leaveTypeName,
                maxNumberOfDays: maxNumber,
                isPaid: isPaid,
                description: description,
                status: status
            }
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchAllLeaveTypes();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function deleteLeaveTypes(button){
    const row = button.closest('tr');  // Get the closest row
    const leaveTypeData = {
        token: row.getAttribute('data-id'),
    };
    
    $.ajax({
        url: 'leaves/modules/leave-types-api',
        type: 'POST',
        data: {
            action: 'delete',
            md5_id: leaveTypeData.token
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchAllLeaveTypes();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}