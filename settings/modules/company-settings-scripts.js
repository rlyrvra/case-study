function showUpdateSuccess() {
    Swal.fire({
        title: "Success!",
        text: "This setting has been updated successfully.",
        icon: "success",
        confirmButtonText: "OK",
    });
}


function getSettingValues(button) {
    // Find the closest row (tr)
    const row = button.closest("tr");
    const token = row.getAttribute("data-token");

    // Get the Setting Key and Group Name as text
    const settingKey = row.cells[1].textContent.trim(); // Setting Key
    const settingValue = row.cells[2].querySelector("input[type='number']").value.trim(); // Setting Value (from input)
    const groupName = row.cells[3].textContent.trim(); // Group Name

    // Return an object
    return {
        token: token,
        setting_key: settingKey,
        setting_value: settingValue,
        group_name: groupName
    };
}