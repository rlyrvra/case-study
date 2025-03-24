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
    const settingKey = row.cells[1].textContent.trim().toLowerCase().replace(/\s+/g, '_'); // Setting Key formatted
    const settingValue = row.cells[2].querySelector("input[type='number']").value.trim(); // Setting Value (from input)
    const groupName = row.cells[3].textContent.trim().toLowerCase().replace(/\s+/g, '_'); // Group Name formatted


    // Return an object
    return {
        id: token,
        setting_key: settingKey,
        setting_value: settingValue,
        group_name: groupName
    };
}

function showValidationError(errorMessages) {
    $('#update-allowances-modal').modal('hide');
    $('#add-allowances-modal').modal('hide');

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
    Swal.fire({
        title: 'Error!',
        text: message,
        icon: 'error',
        confirmButtonText: 'OK'
    });
}

function showFatalError(message) {
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