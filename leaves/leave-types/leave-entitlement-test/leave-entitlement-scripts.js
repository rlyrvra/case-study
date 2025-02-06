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

function clearSelectedLeaveTypes(){
    const checkboxes = document.querySelectorAll('#leaveEntitlementModal #leaveTableBody input[type="checkbox"]');
    checkboxes.forEach((checkbox) => {
        checkbox.checked = false;
    });
}

function leaveTypeInputTest(){
    const selectedLeaveTypes = getSelectedLeaveTypes();
    assignLeaves(selectedLeaveTypes);
    console.log(selectedLeaveTypes);
    clearSelectedLeaveTypes();
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

 

document.addEventListener('DOMContentLoaded', function() {
    // Call the render function
    renderLeaveTypes(document.getElementById('leaveTableBody'));
});