function fetchEmployeeLeaves(){
    const employeeId = document.getElementById('select_employee').value;
    
    $.ajax({
        url: 'leaves/modules/assign-leaves-api',
        type: 'POST',
        data: {
            action: 'fetchEmployeeLeave',
            employee_id: employeeId,
        },
        success: function(response) {
            $('#employee-leave-credits-table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function assignLeaves(selectedLeavesTypes){
    const employeeId = document.getElementById('select_employee').value;

    $.ajax({
        url: 'leaves/modules/assign-leaves-api',
        type: 'POST',
        data: {
            action: 'assignLeaves',
            employee_id: employeeId,
            selected_leaves: selectedLeavesTypes
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchEmployeeLeaves();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function deleteEmployeeLeave(button){
    const leaveEntitlementId = button.getAttribute("data-id");
    
    $.ajax({
        url: 'leaves/modules/assign-leaves-api',
        type: 'POST',
        data: {
            action: 'deleteEmployeeLeave',
            leave_entitlement_id: leaveEntitlementId,
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchEmployeeLeaves();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}