function fetchEmployeeDeductions(){
    const employeeId = document.getElementById('select_employee').value;
    
    $.ajax({
        url: 'deductions/employee-deduction/modules/assign-deductions-api',
        type: 'POST',
        data: {
            action: 'fetchEmployeeDeductions',
            employee_id: employeeId,
        },
        success: function(response) {
            $('#employee-deductions-table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function assignDeductions(){
    const selectedDeductions = getSelectedDeductions();
    if (!selectedDeductions || selectedDeductions.length === 0) {
        showNoSelectedDeductions();
        return;
    }
    const employeeId = document.getElementById('select_employee').value;

    $.ajax({
        url: 'deductions/employee-deduction/modules/assign-deductions-api',
        type: 'POST',
        data: {
            action: 'assignDeductions',
            employee_id: employeeId,
            selectedDeductions: selectedDeductions
        },
        success: function(response) {
            $('#response-test').html(response);
            clearSelectedDeductions();
            $('#deductions_entitlement_modal').modal('hide');
            $('#assign_deductions_modal').modal('hide');
            fetchEmployeeDeductions();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function deleteAssignedDeduction(button){
    const employeeDeductionId = button.getAttribute("data-id");
    
    $.ajax({
        url: 'deductions/employee-deduction/modules/assign-deductions-api',
        type: 'POST',
        data: {
            action: 'deleteDeduction',
            employee_deduction_id: employeeDeductionId,
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchEmployeeDeductions();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}   