// Function to render leave types in the table
function renderAllowances(tbody) {
    allowances.forEach((allowance, index) => {
        const row = document.createElement('tr');

        // Create checkbox cell
        const selectCell = document.createElement('td');
        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.id = `allowance_${index}`;
        selectCell.appendChild(checkbox);
        
        // Create leave type cell
        const allowanceCell = document.createElement('td');
        allowanceCell.textContent = allowance.name;

        // Create credits cell
        const amountCell = document.createElement('td');
        amountCell.textContent = allowance.amount;

        // Create credits cell
        const frequencyCell = document.createElement('td');
        frequencyCell.textContent = allowance.frequency;

        // Append cells to the row
        row.appendChild(selectCell);
        row.appendChild(allowanceCell);
        row.appendChild(amountCell);
        row.appendChild(frequencyCell);

        // Append row to table body
        tbody.appendChild(row);
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Call the render function
    renderAllowances(document.getElementById('allowances_body'));
});

function assignAllowanceName(){
    const form = document.getElementById('allowance_form');
    if(!form.checkValidity()){
        return;
    }
    const modalHide = $('#assign_allowances_modal');
    modalHide.modal('hide');
    const modalShow = $('#allowance_entitlement_modal');
    modalShow.modal('show');
    const select = $('#select_employee').selectize();
    const employeeId = parseInt(select[0].selectize.getValue(), 10);
    const matchedEmployee = employees.find(employee => employee.id === employeeId);
    $("#employee_allowance_entitlement").html(matchedEmployee.full_name);
}

function getSelectedAllowances() {
    const selectedAllowances = [];
    // Get all checkboxes
    const checkboxes = document.querySelectorAll('#allowance_entitlement_modal #allowances_body input[type="checkbox"]');
    checkboxes.forEach((checkbox, index) => {
        if (checkbox.checked) {
        // If the checkbox is checked, push the leave type and credits to the array
        selectedAllowances.push({
            id: allowances[index].id,
            name: allowances[index].name,
            amount: allowances[index].amount
            });
        }
    });
    return selectedAllowances;
}

function clearSelectedAllowances(){
    const checkboxes = document.querySelectorAll('#allowance_entitlement_modal #allowances_body input[type="checkbox"]');
    checkboxes.forEach((checkbox) => {
        checkbox.checked = false;
    });
}

function assignAllowancesClick(){
    $('#allowance_entitlement_modal').modal('hide');
    Swal.fire({
        title: "Assign Allowances",
        text: "Assign allowances to this employee?",
        icon: "info",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes"
      }).then((result) => {
        if (result.isConfirmed) {
            assignAllowances();
        }else{
            $('#allowance_entitlement_modal').modal('show');
        }
      });
}

function showSuccessEntitlement(){
    $('#allowance_entitlement_modal').modal('hide');
    $('#assign_allowances_modal').modal('hide');
    Swal.fire({
        title: 'Success!',
        text: 'The allowances have been assigned successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#assign_allowances_modal').modal('show');
        }
    });
}

function showSuccessDeleteAllowance(){
    $('#allowance_entitlement_modal').modal('hide');
    $('#assign_allowances_modal').modal('hide');
    Swal.fire({
        title: 'Success!',
        text: 'The allowance has been sucessfully deleted.',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#assign_allowances_modal').modal('show');
        }
    });
}

function confirmDeleteAssignedAllowance(button){
    $('#assign_allowances_modal').modal('hide');
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to remove this assigned allowance from the employee?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
        if (result.isConfirmed) {
            deleteAssignedAllowance(button);
        } else {
            $('#assign_allowances_modal').modal('show');
        }
    });
}