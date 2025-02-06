function assignLeaves(selectedLeavesTypes){
    const employeeId = document.getElementById('select_Employee').value;

    $.ajax({
        url: 'apiTest.php',
        type: 'POST',
        data: {
            action: 'assignLeaves',
            employee_id: employeeId,
            selected_leaves: selectedLeavesTypes
        },
        success: function(response) {
            $('#responseTest').html(response);
            fetchEmployeeLeaves();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function fetchEmployeeLeaves(){
    const employeeId = document.getElementById('select_Employee').value;
    
    $.ajax({
        url: 'apiTest.php',
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