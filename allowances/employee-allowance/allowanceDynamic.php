<?php
require_once __DIR__ . '/../AllowanceDao.php';
require_once __DIR__ . '/../Allowance.php';
require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../database/database.php';

// Example allowance data; replace this with your database query to fetch allowances
$allowanceDao = new AllowanceDao($pdo);
$selectedColumns = ["id", "name", "amount"];
$filterCriteria = [
    ["column" => "allowance.status", "operator" => "=", "value" => "Active"]
];
$data = $allowanceDao->fetchAll($selectedColumns, $filterCriteria, []);
$allowances = $data['result_set'];


?>


<script src="ajax-requests.js?v=1.1"></script>
<script>
// JavaScript function to add a new row
function addAllowanceRow() {
    const tableBody = document.getElementById('allowanceTableBody'); // Ensure we target tbody
    const row = document.createElement('tr');

    // Dropdown for allowances
    const allowanceCell = document.createElement('td');
    const select = document.createElement('select');
    select.name = 'allowance_id[]';
    select.classList.add("form-select");
    select.onchange = function() { updateAmount(this); };

    // Insert options in dropdown
    const allowances = <?php echo json_encode($allowances); ?>;
    const defaultOption = document.createElement('option');
    defaultOption.text = 'Select Allowance';
    defaultOption.disabled = true;
    defaultOption.selected = true;
    select.appendChild(defaultOption);

    allowances.forEach(allowance => {
        const option = document.createElement('option');
        option.value = allowance.id;
        option.text = allowance.name;
        option.setAttribute('data-amount', allowance.amount); // Store amount in data-attribute
        select.appendChild(option);
    });

    allowanceCell.appendChild(select);
    row.appendChild(allowanceCell);

    // Readonly textbox for amount
    const amountCell = document.createElement('td');
    const amountInput = document.createElement('input');
    amountInput.type = 'text';
    amountInput.name = 'allowance_amount[]';
    amountInput.classList.add("form-control");
    amountInput.readOnly = true;
    amountInput.placeholder = 'Amount'; // Placeholder for clarity
    amountCell.appendChild(amountInput);
    row.appendChild(amountCell);

    // Delete button
    const deleteCell = document.createElement('td');
    const deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.innerText = 'Delete';
    deleteButton.classList.add("btn", "btn-primary");
    deleteButton.onclick = function() { deleteRow(this); };
    deleteCell.appendChild(deleteButton);
    row.appendChild(deleteCell);

    // Add row to table body
    tableBody.appendChild(row);
}

// JavaScript function to update the amount textbox based on the selected allowance
function updateAmount(selectElement) {
    const selectedOption = selectElement.options[selectElement.selectedIndex];
    const amount = selectedOption.getAttribute('data-amount');
    const row = selectElement.parentNode.parentNode;
    row.cells[1].children[0].value = amount; // Update the readonly textbox in the second cell
}

// JavaScript function to delete a row
function deleteRow(button) {
    const row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

// JavaScript function to get all values in the table
function getAllowanceValues() {
    const rows = document.getElementById('allowanceTableBody').getElementsByTagName('tr');
    const allowances = [];

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const allowanceId = row.cells[0].children[0].value; // Select value
        const amount = row.cells[1].children[0].value; // Amount text value

        // Only add if a valid allowance was selected
        if (allowanceId && allowanceId !== "Select Allowance") {
            allowances.push({
                allowanceId: allowanceId,
                amount: amount
            });
        }
    }

    console.log(allowances); // Display in console or process as needed
    return allowances;
}

</script>