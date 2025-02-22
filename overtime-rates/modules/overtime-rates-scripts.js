// JavaScript function to get all values in the table
function getRatesValues(rows) {
    const rates = [];

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const dayType = row.cells[0].innerHTML.trim();
        const holidayType = row.cells[1].innerHTML.trim();
        const regularHr = row.cells[2].children[0].value;
        const overRate = row.cells[3].children[0].value;
        const nightDiff = row.cells[4].children[0].value;
        const nightAndOvertimeRate = row.cells[5].children[0].value;

        rates.push({
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
        timer: 2000,
        confirmButtonText: 'OK'
    });
}