// JavaScript function to get all values in the table
function getRatesValues(rows) {
    const rates = [];

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const id = rows[i].getAttribute('data-id');
        const dayType = row.cells[0].innerHTML.trim();
        const holidayType = row.cells[1].innerHTML.trim();
        const regularHr = row.cells[2].children[0].value;
        const overRate = row.cells[3].children[0].value;
        const nightDiff = row.cells[4].children[0].value;
        const nightAndOvertimeRate = row.cells[5].children[0].value;

        rates.push({
            id: id,
            day_type: dayType,
            holiday_type: holidayType,
            regular_time_rate: regularHr,
            overtime_rate: overRate,
            night_differential_rate: nightDiff,
            night_differential_and_overtime_rate: nightAndOvertimeRate,
        });
    }

    return rates;
}


function showSuccessCreation() {
    Swal.fire({
        title: 'Success!',
        text: 'The rates has been successfully assigned.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
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

function confirmAssignRates() {
    Swal.fire({
        title: 'Are you sure?',
        text: "These rates will apply to the payroll calculation of your selected [department->job title->employee]!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, apply it!'
    }).then((result) => {
        if (result.isConfirmed) {
            assignRates();
        }
    });
}