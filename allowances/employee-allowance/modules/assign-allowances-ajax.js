function fetchEmployeeAllowances(){
    const employeeId = document.getElementById('select_employee').value;
    
    $.ajax({
        url: 'allowances/employee-allowance/modules/assign-allowances-api',
        type: 'POST',
        data: {
            action: 'fetchEmployeeAllowances',
            employee_id: employeeId,
        },
        success: function(response) {
            $('#employee-allowances-table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function assignAllowances(){
    const selectedAllowances = getSelectedAllowances();
    const employeeId = document.getElementById('select_employee').value;
    $.ajax({
        url: 'allowances/employee-allowance/modules/assign-allowances-api',
        type: 'POST',
        data: {
            action: 'assignAllowances',
            employee_id: employeeId,
            selectedAllowances: selectedAllowances
        },
        success: function(response) {
            $('#response-test').html(response);
            clearSelectedAllowances();
            $('#allowance_entitlement_modal').modal('hide');
            $('#assign_allowances_modal').modal('hide');
            fetchEmployeeAllowances();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function deleteAssignedAllowance(button){
    const employeeAllowanceId = button.getAttribute("data-id");
    
    $.ajax({
        url: 'allowances/employee-allowance/modules/assign-allowances-api',
        type: 'POST',
        data: {
            action: 'deleteAllowance',
            employee_allowance_id: employeeAllowanceId,
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchEmployeeAllowances();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}   