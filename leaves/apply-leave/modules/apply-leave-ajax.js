// function createLeaveRequest(){
//     calculateTotalNumberOfDays();
//     const form = document.getElementById('apply_leave_form');
//     if(!form.checkValidity()){
//         return;
//     }
//     const leaveType = document.getElementById('leaveType').value;
//     const startDate = document.getElementById('startDate').value;
//     const endDate = document.getElementById('endDate').value;
//     const reason = document.getElementById('reason').value;
//     const attachments = document.getElementById('files').files;

//     // Create a FormData object to include files and form data
//     let leave_request = {
//         leave_type_id: leaveType,
//         start_date: startDate,
//         end_date: endDate,
//         reason: reason,
//         attachments: attachments
//     };
//     // leave_request.append('action', 'create');
//     // leave_request.append('leave_type_id', leaveType);
//     // leave_request.append('start_date', startDate);
//     // leave_request.append('end_date', endDate);
//     // leave_request.append('reason', reason);

//     console.log(leave_request);

//     $.ajax({
//         url: 'leaves/apply-leave/modules/apply-leave-api',
//         method: 'POST',
//         data: {
//             action: 'create',
//             leave_request: leave_request
//         },
//         success: function(response) {
//             $('#response-test').html(response);
//             document.getElementById('apply_leave_form').reset();
//             document.getElementById('leaveType').value = "";
//             fetchLeaveRequests();
//         },
//         error(xhr, status, error) {
//             console.error("Error creating leave types:", error);
//         }
//     });
// }

function createLeaveRequest() {
    if(!calculateTotalNumberOfDays()) return;
    const form = document.getElementById('apply_leave_form');
    if (!form.checkValidity()) return;

    const leaveType = document.getElementById('leaveType').value;
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const isHalfDay = document.getElementById('isHalfday').checked;
    var halfDayPart;
    if(isHalfDay.checked){
        halfDayPart = document.getElementById('half_day_options').value;
    }else{
        halfDayPart = '';
    }
    const reason = document.getElementById('reason').value;
    const attachments = document.getElementById('files').files;

    // Initialize FormData
    const leaveRequestData = new FormData();

    // Add non-file fields to FormData
    leaveRequestData.append('action', 'create');
    leaveRequestData.append('leave_type_id', leaveType);
    leaveRequestData.append('start_date', startDate);
    leaveRequestData.append('end_date', endDate);
    if(isHalfDay.checked){
        leaveRequestData.append('is_half_day', isHalfDay);
        leaveRequestData.append('half_day_part', halfDayPart);
    }
    leaveRequestData.append('reason', reason);

    // Add file attachments to FormData
    for (let i = 0; i < attachments.length; i++) {
        leaveRequestData.append('attachments[]', attachments[i]);
    }

    console.log(leaveRequestData);

    // Make AJAX request
    $.ajax({
        url: 'leaves/apply-leave/modules/apply-leave-api',
        method: 'POST',
        data: leaveRequestData, // Pass FormData
        processData: false, // Prevent jQuery from processing the data
        contentType: false, // Let the browser set the `Content-Type`
        success: function (response) {
            $('#response-test').html(response);
            document.getElementById('apply_leave_form').reset();
            document.getElementById('leaveType').value = "";
            fetchLeaveRequests();
        },
        error(xhr, status, error) {
            console.error("Error creating leave types:", error);
        }
    });
}

function fetchLeaveRequests(page = 1){
    var numberEntries = $("#entries-per-page").val();
    var pageNumber = getPage(page);
    var sortByColumn = getSortByColumn();
    if(sortByColumn == null){
        sortByColumn = "created_at";
    };
    var sortOrderBy = getOrderBy();
    if(sortOrderBy == null) {
        sortOrderBy = "DESC";
    };
    var filterStatus = $("#status").val();

    var loadingSpinner = document.getElementById("loadingSpinner");
    loadingSpinner.classList.remove("visually-hidden");


    if(!skeletonLoaded){
        loadSkeletonView(7, ['#', 'Type', 'Start Date', 'End Date', 'Reason', 'Status', 'Action'] , 10, document.getElementById("skeleton-apply-table"));
        document.getElementById('skeleton-apply-table').classList.remove("visually-hidden");
        document.getElementById('apply_leaves_table').classList.add("visually-hidden");
        skeletonLoaded = true;
    }else{
        document.getElementById('skeleton-apply-table').classList.remove("visually-hidden");
        document.getElementById('apply_leaves_table').classList.add("visually-hidden");
    }

    $.ajax({
        url: 'leaves/apply-leave/modules/apply-leave-api',
        type: 'POST',
        data: {
            action: 'fetchAll',
            page: pageNumber,
            numberEntries: numberEntries,
            sort_by: sortByColumn,
            sort_order: sortOrderBy,
            filter_status: filterStatus
        },
        success: function(response) {
            document.getElementById('skeleton-apply-table').classList.add("visually-hidden");
            document.getElementById('apply_leaves_table').classList.remove("visually-hidden");
            loadingSpinner.classList.add("visually-hidden");
            $('#apply_leaves_table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function deleteLeaveRequest(button){
    const token = button.getAttribute("data-token");
    $.ajax({
        url: 'leaves/apply-leave/modules/apply-leave-api',
        type: 'POST',
        data: {
            action: 'delete',
            md5_id: token
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchLeaveRequests();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function cancelLeaveRequest(button){
    const token = button.getAttribute("data-token");
    $.ajax({
        url: 'leaves/apply-leave/modules/apply-leave-api',
        type: 'POST',
        data: {
            action: 'cancel',
            md5_id: token
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchLeaveRequests();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}