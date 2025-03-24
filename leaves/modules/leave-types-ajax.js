function fetchAllLeaveTypes(page = 1){
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
    var viewMode = getViewMode();

    
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

    var loadingSpinner = document.getElementById("loadingSpinner");
    loadingSpinner.classList.remove("visually-hidden");


    if(!skeletonLoaded){
        loadSkeletonView(7, ['Name', 'Maximum Number of Days', 'Paid', 'description', 'status', 'Created At', 'Updated At'] , numberEntries, document.getElementById("skeleton-leaves-table"));
        document.getElementById('skeleton-leaves-table').classList.remove("visually-hidden");
        document.getElementById('leave-types-table').classList.add("visually-hidden");
        skeletonLoaded = true;
    }else{
        document.getElementById('skeleton-leaves-table').classList.remove("visually-hidden");
        document.getElementById('leave-types-table').classList.add("visually-hidden");
    }


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
            filter_endDate: endDate,
            view_mode: viewMode
        },
        success: function(response) {
            document.getElementById('skeleton-leaves-table').classList.add("visually-hidden");
        document.getElementById('leave-types-table').classList.remove("visually-hidden");
            loadingSpinner.classList.add("visually-hidden");
            $('#leave-types-table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function createLeaveTypes(){
    const form = document.getElementById('add_leave_type_form');
    if(!form.checkValidity()){
        return;
    }
    const leaveTypeName = document.getElementById('add_name').value;
    const maxNumber = document.getElementById('add_maximum_number_of_days').value;
    const isPaid = document.getElementById('add_is_paid').checked;
    //const isEncashable = document.getElementById('add_is_encashable').checked;
    const description = document.getElementById('add_description').value;
    const status = document.getElementById('add_status').value;

    const leaveTypeData = {
        name: leaveTypeName,
        maximum_number_of_days: maxNumber,
        is_paid: isPaid,
        is_encashable: false,
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
    const form = document.getElementById('update_leave_type_form');
    if(!form.checkValidity()){
        return;
    }
    const token = button.getAttribute('data-token');

    const leaveTypeName = document.getElementById('update_name').value;
    const maxNumber = document.getElementById('update_maximum_number_of_days').value;
    const isPaid = document.getElementById('update_is_paid').checked;
    //const isEncashable = document.getElementById('update_is_encashable').checked;
    const description = document.getElementById('update_description').value;
    const status = document.getElementById('update_status').value;
    
    // console.log(`Leave Type Name: ${leaveTypeName}, 
    //     Max Number of Days: ${maxNumber}, 
    //     Is Paid: ${isPaid}, 
    //     Description: ${description}, 
    //     Status: ${status}`);
    const leave_type = {
        id: token,
        name: leaveTypeName,
        maximum_number_of_days: maxNumber,
        is_paid: isPaid,
        is_encashable: false,
        description: description,
        status: status
    };

    //console.log(leave_type);

    $.ajax({
        url: 'leaves/modules/leave-types-api',
        type: 'POST',
        data: {
            action: 'update',
            leave_type: leave_type
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
        id: row.getAttribute('data-id'),
    };
    
    $.ajax({
        url: 'leaves/modules/leave-types-api',
        type: 'POST',
        data: {
            action: 'delete',
            leave_type: leaveTypeData
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