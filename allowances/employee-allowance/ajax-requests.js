function fetchAll() {
    
    $.ajax({
        url: 'apiTest.php',
        method: 'POST',
        data: {
            action: 'fetchAll'
        },
        dataType: 'html',
        success(response) {
            $('#allowance_table').html(response);
        },
        error(xhr, status, error) {
            console.error("Error fetching departments:", error);
        }
    });
}

function fetchAllEmployeeAllowances(){
    const employeeId = $("#employee_id").val();
    $.ajax({
        url: 'apiTest.php',
        method: 'POST',
        data: {
            action: 'fetchAllEmployeeAllowances',
            employee_id: employeeId
        },
        dataType: 'html',
        success(response) {
            $('#allowanceOutput').html(response);
        },
        error(xhr, status, error) {
            console.error("Error fetching departments:", error);
        }
    });
}

function createEmployeeAllowance() {
    const allowances = getAllowanceValues();
    const employeeId = $("#employee_id").val();
    console.log(allowances);
    console.log(employeeId);
    if(allowances.length <= 0){
        return;
    }
    $.ajax({
        url: 'apiTest.php',
        method: 'POST',
        data: {
            action: 'create',
            employee_id: employeeId,
            allowance: allowances
        },
        dataType: 'html',
        success(response) {
            $('#allowanceOutput').html(response);
            //$('#allowance-form').trigger('reset');
            fetchAll();
        },
        error(xhr, status, error) {
            console.error("Error fetching departments:", error);
        }
    });
    
}