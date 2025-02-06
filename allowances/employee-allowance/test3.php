<?php
require_once __DIR__ . '/../AllowanceDao.php';
require_once __DIR__ . '/../Allowance.php';
require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../includes/enums/ErrorCode.php';
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
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Employee Allowances</title>
<script>
// Example allowance data (you can replace this with values fetched from a database)
const initialAllowances = [
    { id: 1, amount: "100.00" },
    { id: 2, amount: "100.00" }
];

// JavaScript function to add a new row
function addAllowanceRow(allowanceId = null, amount = "") {
    const tableBody = document.getElementById('allowanceTableBody');
    const row = document.createElement('tr');

    // Dropdown for allowances
    const allowanceCell = document.createElement('td');
    const select = document.createElement('select');
    select.name = 'allowance_id[]';
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
        option.setAttribute('data-amount', allowance.amount);

        // Preselect the option if it matches the provided allowanceId
        if (allowanceId && allowance.id === allowanceId) {
            option.selected = true;
        }

        select.appendChild(option);
    });

    allowanceCell.appendChild(select);
    row.appendChild(allowanceCell);

    // Readonly textbox for amount
    const amountCell = document.createElement('td');
    const amountInput = document.createElement('input');
    amountInput.type = 'text';
    amountInput.name = 'allowance_amount[]';
    amountInput.readOnly = true;
    amountInput.placeholder = 'Amount';
    amountInput.value = amount; // Set the amount value if provided
    amountCell.appendChild(amountInput);
    row.appendChild(amountCell);

    // Delete button
    const deleteCell = document.createElement('td');
    const deleteButton = document.createElement('button');
    deleteButton.type = 'button';
    deleteButton.innerText = 'Delete';
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
    row.cells[1].children[0].value = amount;
}

// JavaScript function to delete a row
function deleteRow(button) {
    const row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
}

// Function to load initial allowance data
function loadInitialAllowances() {
    initialAllowances.forEach(allowance => {
        addAllowanceRow(allowance.id, allowance.amount);
    });
}

// Load initial allowances when the page is ready
document.addEventListener('DOMContentLoaded', loadInitialAllowances);
</script>
</head>
<body>

<h2>Assign Allowances to Employee</h2>

<!-- Button to add new allowance row -->
<button type="button" onclick="addAllowanceRow()">Add Allowance</button>

<!-- Table for allowances -->
<table id="allowanceTable" border="1" style="margin-top: 10px;">
<thead>
<tr>
<th>Allowance</th>
<th>Amount</th>
<th>Action</th>
</tr>
</thead>
<tbody id="allowanceTableBody">
<!-- Rows will be added dynamically here -->
</tbody>
</table>

</body>
</html>