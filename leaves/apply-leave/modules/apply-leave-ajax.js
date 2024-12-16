function createLeaveRequest(){
    const form = document.getElementById('apply_leave_form');
    if(!form.checkValidity()){
        return;
    }
    const leaveType = document.getElementById('leaveType').value;
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const reason = document.getElementById('reason').value;
    const leave_request = {
        leave_type_id: leaveType,
        start_date: startDate,
        end_date: endDate,
        reason: reason
    };

    $.ajax({
        url: 'leaves/apply-leave/modules/apply-leave-api',
        method: 'POST',
        data: {
            action: 'create',
            leave_request: leave_request
        },
        success: function(response) {
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

function fetchLeaveRequests(){
    $.ajax({
        url: 'leaves/apply-leave/modules/apply-leave-api',
        type: 'POST',
        data: {
            action: 'fetchAll'
        },
        success: function(response) {
            $('#apply_leaves_table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}