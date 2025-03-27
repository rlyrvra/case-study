// Function to render leave types in the table
function renderDeductions(tbody) {
    deductions.forEach((deduction, index) => {
        const row = document.createElement('tr');

        // Create checkbox cell
        const selectCell = document.createElement('td');
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.id = `deduction_${index}`;
        selectCell.appendChild(checkbox);
        
        // Create name cell
        const deductionCell = document.createElement('td');
        deductionCell.textContent = deduction.name;

        // Create amount cell
        const amountCell = document.createElement('td');
        amountCell.textContent = deduction.amount;

        // Create frequency cell
        const frequencyCell = document.createElement('td');
        frequencyCell.textContent = deduction.frequency;

        // Append cells to the row
        row.appendChild(selectCell);
        row.appendChild(deductionCell);
        row.appendChild(amountCell);
        row.appendChild(frequencyCell);

        // Append row to table body
        tbody.appendChild(row);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Call the render function
    renderDeductions(document.getElementById('deductions_body'));
});

function assignDeductionName(){
    const form = document.getElementById('deduction_form');
    if(!form.checkValidity()){
        return;
    }
    $('#assign_deductions_modal').modal('hide');
    $('#deductions_entitlement_modal').modal('show');
    const select = $('#select_employee').selectize();
    const employeeId = parseInt(select[0].selectize.getValue(), 10);
    const matchedEmployee = employees.find(employee => employee.id === employeeId);
    $("#employee_deductions_entitlement").html(matchedEmployee.full_name);
}

function getSelectedDeductions() {
    const selectedDeductions = [];
    // Get all checkboxes
    const checkboxes = document.querySelectorAll('#deductions_entitlement_modal #deductions_body input[type="checkbox"]');
    checkboxes.forEach((checkbox, index) => {
        if (checkbox.checked) {
        // If the checkbox is checked, push the leave type and credits to the array
        selectedDeductions.push({
            deduction_id: deductions[index].id,
            name: deductions[index].name,
            amount: deductions[index].amount
            });
        }
    });
    return selectedDeductions;
}

function clearSelectedDeductions(){
    const checkboxes = document.querySelectorAll('#deductions_entitlement_modal #deductions_body input[type="checkbox"]');
    checkboxes.forEach((checkbox) => {
        checkbox.checked = false;
    });
}

function showSuccessEntitlement(message = 'The deductions have been assigned successfully.'){
    $('#deductions_entitlement_modal').modal('hide');
    $('#assign_deductions_modal').modal('hide');
    Swal.fire({
        title: 'Success!',
        text: message,
        icon: 'success',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#assign_deductions_modal').modal('show');
            $('#assign_deductions_form').get(0).reset();
        }
    });
}

function assignDeductionsClick(){
    $('#deductions_entitlement_modal').modal('hide');
    Swal.fire({
        title: "Assign Deductions",
        text: "Assign deductions to this employee?",
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes"
      }).then((result) => {
        if (result.isConfirmed) {
            assignDeductions();
        }else{
            $('#deductions_entitlement_modal').modal('show');
        }
      });
}

function showSuccessDeleteDeduction(){
    $('#deductions_entitlement_modal').modal('hide');
    $('#assign_deductions_modal').modal('hide');
    Swal.fire({
        title: 'Success!',
        text: 'The deduction has been sucessfully deleted.',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#assign_allowances_modal').modal('show');
        }
    });
}

function showNoSelectedDeductions(){
    $('#deductions_entitlement_modal').modal('hide');
    Swal.fire({
        title: 'Warning!',
        text: "You have no selected deductions.",
        icon: 'warning',
        confirmButtonText: 'OK',
    }).then((result) => {
        if (result.isConfirmed) {
            $('#deductions_entitlement_modal').modal('show');
        }
    });
}


function confirmDeleteAssignedDeduction(button){
    $('#assign_deductions_modal').modal('hide');
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to remove this assigned deduction from the employee?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
        if (result.isConfirmed) {
            deleteAssignedDeduction(button);
        } else {
            $('#assign_deductions_modal').modal('show');
        }
    });
}

function showValidationErrorAssign(errorMessages) {
    $('#deductions_entitlement_modal').modal('hide');
    $('#assign_deductions_modal').modal('hide');

    let formattedMessages = '';

    if (Array.isArray(errorMessages)) {
        formattedMessages = errorMessages.join('<br>'); // Format as a list
    } else if (typeof errorMessages === 'object') {
        formattedMessages = Object.values(errorMessages).flat().join('<br>'); // Flatten object values
    } else {
        formattedMessages = errorMessages; // Assume it's already a string
    }

    Swal.fire({
        title: 'Warning!',
        html:  formattedMessages,
        icon: 'warning',
        confirmButtonText: 'OK'
    });
}


function showError(message) {
    $('#add-departments-modal').modal('hide');
    $('#update_departments_modal').modal('hide');
    Swal.fire({
        title: 'Error!',
        text: message,
        icon: 'error',
        confirmButtonText: 'OK'
    });
}

function showFatalError(message) {
    $('#add-departments-modal').modal('hide');
    $('#update_departments_modal').modal('hide');
    Swal.fire({
        title: 'Fatal Error!',
        html: `${message} <br> Please contact the system administrator.`,
        icon: 'error',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            location.reload();
        }
    });
}