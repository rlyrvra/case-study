var skeletonLoaded = false;
function loadSkeletonView(cols = 1, colNames = ['default'], rows = 1, targetTableId) {
    let table = document.getElementById(targetTableId);
    
    // If the table does not exist, create it
    if (!table) {
        const tableContainer = targetTableId;
        table = document.createElement("table");
        table.id = targetTableId;
        table.className = "table table-bordered table-hover table-striped";
        tableContainer.appendChild(table);
    }
    
    // Ensure thead and tbody exist
    table.innerHTML = "<thead><tr></tr></thead><tbody></tbody>";
    const thead = table.querySelector("thead tr");
    const tbody = table.querySelector("tbody");
    
    // Generate header
    colNames.forEach(name => {
        thead.innerHTML += `<th>${name}</th>`;
    });
    
    // Generate skeleton rows
    for (let i = 0; i < rows; i++) {
        let row = "<tr>";
        for (let j = 0; j < cols; j++) {
            row += '<td class="skeleton-loader"></td>';
        }
        row += "</tr>";
        tbody.innerHTML += row;
    }
}