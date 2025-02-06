// Function to render leave types in the table
function renderLeaveTypes(tbody) {
    leaveTypes.forEach((leaveType, index) => {
        const row = document.createElement('tr');

        // Create checkbox cell
        const selectCell = document.createElement('td');
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.id = `leaveType_${index}`;
        selectCell.appendChild(checkbox);
        
        // Create leave type cell
        const leaveTypeCell = document.createElement('td');
        leaveTypeCell.textContent = leaveType.name;

        // Create credits cell
        const creditsCell = document.createElement('td');
        creditsCell.textContent = leaveType.maximum_number_of_days;

        // Append cells to the row
        row.appendChild(selectCell);
        row.appendChild(leaveTypeCell);
        row.appendChild(creditsCell);

        // Append row to table body
        tbody.appendChild(row);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Call the render function
    renderLeaveTypes(document.getElementById('leaveTableBody'));
});

function clearSelectedLeaveTypes(){
    const checkboxes = document.querySelectorAll('#leaveEntitlementModal #leaveTableBody input[type="checkbox"]');
    checkboxes.forEach((checkbox) => {
        checkbox.checked = false;
    });
}

function leaveTypeInputTest(){
    const employment_type = document.getElementById('employment-type').value;
    if(!employment_type){
        return;
    }
    $('#assign_leave_types_modal').modal('hide');
    $('#leaveEntitlementModal').modal('hide');
    Swal.fire({
        title: 'Are you sure?',
        text: "This action is irreversible and will affect all employees with selected employment type.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, continue!',
    }).then((result) => {
        if (result.isConfirmed) {
            const selectedLeaveTypes = getSelectedLeaveTypes();
            assignLeaves(selectedLeaveTypes);
            clearSelectedLeaveTypes();
        } else {
            $('#assign_leave_types_modal').modal('show');
        }
    });
    
    
}



// Function to collect selected leave types
function getSelectedLeaveTypes() {
    const selectedLeaveTypes = [];
    // Get all checkboxes
    const checkboxes = document.querySelectorAll('#leaveEntitlementModal #leaveTableBody input[type="checkbox"]');
    checkboxes.forEach((checkbox, index) => {
        if (checkbox.checked) {
        // If the checkbox is checked, push the leave type and credits to the array
        selectedLeaveTypes.push({
            id: leaveTypes[index].id,
            name: leaveTypes[index].name,
            credits: leaveTypes[index].maximum_number_of_days
            });
        }
    });
    return selectedLeaveTypes;
}

function showSelectedEmployee(){
    const selectedToken = parseInt(document.getElementById("select_employee").value, 10);

    const matchingEmployee = employees.find(employee => selectedToken === employee.id);
    if(!matchingEmployee){
        document.getElementById("leaveEntitlementModalLabel").innerHTML = "WARNING! No Selected Employee";
        return;
    }
    document.getElementById("leaveEntitlementModalLabel").innerHTML = matchingEmployee.full_name + " <br/> " + "<span class='display-6'>" + matchingEmployee.email_address + "</span>"
}



function confirmDeleteEmployeeLeave(button){
    $('#assign_leave_types_modal').modal('hide');
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to remove this assigned leave from the employee?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
        if (result.isConfirmed) {
        deleteEmployeeLeave(button);
        } else {
            $('#assign_leave_types_modal').modal('show');
        }
    });
}

function showSuccessLeaveEntitlement() {
    $('#assign_leave_types_modal').modal('hide');
    $('#leaveEntitlementModal').modal('hide');
    Swal.fire({
        title: 'Success!',
        text: 'The leaves have been assigned successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#assign_leave_types_modal').modal('show');
        }
    });
}

function showSuccessDeleteLeaveEntitlement(){
    $('#assign_leave_types_modal').modal('hide');
    Swal.fire({
        title: 'Success!',
        text: 'This leaves type has been removed from this employee.',
        icon: 'success',
        timer: 2000,
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#assign_leave_types_modal').modal('show');
        }
    });
}

function showNoEmployeePresent(){
    $('#assign_leave_types_modal').modal('hide');
    $('#leaveEntitlementModal').modal('hide');
    Swal.fire({
        title: 'Warning!',
        text: 'The selected employment type has no employee present but its leaves have been successfully assigned.',
        icon: 'warning',
        timer: 2000,
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#assign_leave_types_modal').modal('show');
        }
    });
}


function showError(){
    $('#assign_leave_types_modal').modal('hide');
    $('#leaveEntitlementModal').modal('hide');
    Swal.fire({
        title: 'Error!',
        text: 'An error has occured.',
        icon: 'error',
        timer: 2000,
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#assign_leave_types_modal').modal('show');
        }
    });
}