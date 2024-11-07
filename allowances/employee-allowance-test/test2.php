<?php
// Example allowance data; replace this with your database query to fetch allowances
$allowances = [
['id' => 1, 'name' => 'Housing Allowance', 'amount' => 500],
['id' => 2, 'name' => 'Transport Allowance', 'amount' => 300],
// Add more allowances as needed
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Employee Allowances</title>
<script>
// JavaScript function to add a new row
function addAllowanceRow() {
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

// JavaScript function to get all values in the table
function getAllowanceValues() {
    const rows = document.getElementById('allowanceTableBody').getElementsByTagName('tr');
    const allowances = [];

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const allowanceId = row.cells[0].children[0].value; // Select value
        const amount = row.cells[1].children[0].value; // Amount text value

        // Only add if a valid allowance was selected
        if (allowanceId) {
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
</head>
<body>

<h2>Assign Allowances to Employee</h2>

<!-- Button to add new allowance row -->
<button type="button" onclick="addAllowanceRow()">Add Allowance</button>
<button type="button" onclick="getAllowanceValues()">Get Allowance Values</button> <!-- New button to get values -->

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