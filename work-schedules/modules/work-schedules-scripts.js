function getPage(page){
    let output;
    if(page === 'next'){
        page = $("#pagination .active .page-link").text();
        let currentPage = parseInt($("#pagination .active .page-link").text(), 10);
        let maxPage = getMaxPageValue();
        if(currentPage < maxPage) page = currentPage + 1;
    } else if(page === 'prev'){
        page = $("#pagination .active .page-link").text();
        let currentPage = parseInt($("#pagination .active .page-link").text(), 10);
        if(currentPage != 1) page = currentPage - 1;
    }
    return page;
}

function getMaxPageValue() {
    // Find all <a> tags inside the <ul> with id "pagination"
    let pageNumbers = $("#pagination .page-link").map(function() {
        // Get the text content of each <a> tag and convert it to a number
        let pageText = $(this).text().trim(); // Use trim to remove any extra spaces
        return parseInt(pageText, 10);
    }).get(); // `.get()` turns the jQuery object into a plain array

    // Get the maximum value from the array (excluding NaN values)
    let maxPage = Math.max(...pageNumbers.filter(num => !isNaN(num)));

    return maxPage;
}

function getSortByColumn(){
    var sortBy = selectedOptions.sort_by;
    return sortBy;
}

function getOrderBy(){
    var orderBy = selectedOptions.order_by;
    return orderBy;
}

function getByDate(){
    var byDate = selectedOptions.by_date;
    return byDate;
}


document.addEventListener('DOMContentLoaded', function () {
    const startTime = document.getElementById('startTime');
    const endTime = document.getElementById('endTime');
    const isFlextimeCheckbox = document.getElementById('isFlextime');
    // const coreStartTime = document.getElementById('coreStartTime');
    // const coreEndTime = document.getElementById('coreEndTime');
    const totalHours = document.getElementById('totalHoursPerWeek');

    isFlextimeCheckbox.addEventListener('change', function () {
        const isRequired = isFlextimeCheckbox.checked;

        // coreStartTime.required = isRequired;
        // coreEndTime.required = isRequired;
        totalHours.required = isRequired;
        
    });
    
});

document.addEventListener("DOMContentLoaded", function () {
    const startTimeSelect = document.getElementById("startTime");
    const endTimeSelect = document.getElementById("endTime");

    endTimeSelect.addEventListener("change", calculateWorkHours);
});

function calculateWorkHours() {
    const startTime = document.getElementById("startTime").value;
    const endTime = document.getElementById("endTime").value;

    if (startTime && endTime) {
        const startDate = new Date(`1970-01-01T${convertTo24Hour(startTime)}`);
        const endDate = new Date(`1970-01-01T${convertTo24Hour(endTime)}`);
        
        const selectedBreaks = getCreateBreaksValues();
        const totalBreakMinutes = selectedBreaks.reduce((total, selectedBreak) => {
            if(selectedBreak.paid == "PAID"){
                return total;
            }
            // Find the corresponding break type in breakTypes array
            const breakType = breakTypes.find(breakType => breakType.id === parseInt(selectedBreak.id, 10));
            
            // If a matching break type is found, add its duration to the total
            if (breakType) {
                return total + breakType.duration_in_minutes;
            }
            
            // If no matching break type is found, return the current total
            return total;
        }, 0);

        let diff = (((endDate - startDate) / (1000 * 60 * 60)) - (totalBreakMinutes / 60)).toFixed(2); // Difference in hours

        // Adjust for cases where end time is on the next day
        if (diff < 0) {
            diff += 24;
        }

        document.getElementById("totalWorkHours").value = diff;
    }
}

function convertTo24Hour(time) {
    const [hours, minutes, period] = time.match(/(\d+):(\d+)(AM|PM)/).slice(1);
    let hour = parseInt(hours, 10);
    if (period === "PM" && hour !== 12) {
        hour += 12;
    } else if (period === "AM" && hour === 12) {
        hour = 0;
    }
    return `${hour.toString().padStart(2, "0")}:${minutes}`;
}

let rowAddedWork = false;
function addWorkSchedulesBreakCreate() {
    if(rowAddedWork){
        return;
    }
    const tableBody = document.getElementById('create_break_assignment_table_body'); // Ensure we target tbody
    if(tableBody.rows.length >= 5){
        return;
    }
    const row = document.createElement('tr');

    let breaksAddHTML = `
    <td>
        <select class="form-select" id="create_breaks" name="create_breaks" required onchange="updatePaidStatus(this)">
            `;
    breakTypes.forEach(breakType => {
        breaksAddHTML += "<option value='" + breakType.id + "'>" + breakType.name + "</option>";
    });
    breaksAddHTML += `
        </select>
    </td>
    <td>
        <span class="badge bg-badge" id="paid_status"></span>
    </td>
    <td>
        <select class="form-select" id="create_start_time" name="create_start_time" required onchange="updateEndTime(this); calculateWorkHours();">
            <option value="" selected disabled>Select start time...</option>
            <option value="12:00AM">12:00AM</option>
            <option value="1:00AM">1:00AM</option>
            <option value="2:00AM">2:00AM</option>
            <option value="3:00AM">3:00AM</option>
            <option value="4:00AM">4:00AM</option>
            <option value="5:00AM">5:00AM</option>
            <option value="6:00AM">6:00AM</option>
            <option value="7:00AM">7:00AM</option>
            <option value="8:00AM">8:00AM</option>
            <option value="9:00AM">9:00AM</option>
            <option value="10:00AM">10:00AM</option>
            <option value="11:00AM">11:00AM</option>
            <option value="12:00PM">12:00PM</option>
            <option value="1:00PM">1:00PM</option>
            <option value="2:00PM">2:00PM</option>
            <option value="3:00PM">3:00PM</option>
            <option value="4:00PM">4:00PM</option>
            <option value="5:00PM">5:00PM</option>
            <option value="6:00PM">6:00PM</option>
            <option value="7:00PM">7:00PM</option>
            <option value="8:00PM">8:00PM</option>
            <option value="9:00PM">9:00PM</option>
            <option value="10:00PM">10:00PM</option>
            <option value="11:00PM">11:00PM</option>
        </select>
    </td>
    <td>
        <input type="text" class="form-control" id="create_end_time" readonly required/>
    </td>
    <td>
        <button class="btn btn-danger" title="Click to Delete" onclick="cancelBreakAssignment(this); calculateWorkHours();">
            <i class="bx bx-trash"></i>
        </button> 
    </td>
    `;
    row.innerHTML = breaksAddHTML;
    tableBody.appendChild(row);
    rowAddedWork = true;
    updatePaidStatus(row.querySelector('#create_breaks'));

}

function updatePaidStatus(select){
    const row = select.closest('tr');  // Get the closest row
    const token = parseInt(select.value, 10);
    const matchingBreak = breakTypes.find(breakType => breakType.id === token);
    const matchingBreakPaid = matchingBreak.is_paid;
    const paidStatus = row.querySelector('#paid_status');
    const startTime = row.querySelector('#create_start_time');
    const endTime = row.querySelector('#create_end_time');
    if(matchingBreakPaid === 1){
        paidStatus.classList.remove('bg-danger');
        paidStatus.classList.add('bg-success');
        paidStatus.innerHTML = "PAID"
    }else{
        paidStatus.classList.add('bg-danger');
        paidStatus.classList.remove('bg-success');
        paidStatus.innerHTML = "UNPAID"
    }
    startTime.value = "";
    endTime.value = "";

}

function updateEndTime(select){
    const row = select.closest('tr');  // Get the closest row
    const token = parseInt(row.querySelector('#create_breaks').value, 10);
    const matchingBreak = breakTypes.find(breakType => breakType.id === token);
    const format = { timeStyle: 'short', hour12: true };
    const startTime = new Date(`1970-01-01T${convertTo24Hour(row.querySelector('#create_start_time').value)}`);
    const addMinutes = matchingBreak.duration_in_minutes;
    const sumTime = new Date(startTime.getTime() + addMinutes * 60000).toLocaleTimeString('en-US', format);
    row.querySelector('#create_end_time').value = sumTime;
    rowAddedWork = false;
    getCreateBreaksValues();
}

function cancelBreakAssignment(button){
    const row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
    rowAddedWork = false;
}

// JavaScript function to get all values in the table
function getCreateBreaksValues() {
    const rows = document.getElementById('create_break_assignment_table_body').getElementsByTagName('tr');
    const workScheduleBreaks = [];

    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const breakTypeId = row.cells[0].children[0].value;
        const paid = row.cells[1].children[0].innerHTML;
        const startTime = row.cells[2].children[0].value;
        const endTime = row.cells[3].children[0].value;

        // Only add if a valid allowance was selected
        if (breakTypeId && breakTypeId !== "" && startTime !== "") {
            workScheduleBreaks.push({
                id: breakTypeId,
                paid: paid,
                start_time: startTime,
                end_time: endTime
            });
        }
    }

    //console.log(workScheduleBreaks); // Display in console or process as needed
    return workScheduleBreaks;
}


function showFormIncomplete(){
    $('#add_work_schedules').modal('hide');
    Swal.fire({
        title: 'Warning!',
        text: 'Please fill up the create form.',
        icon: 'warning',
        timer: 2000,
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#add_work_schedules').modal('show');
        }
    });
    
}

function missingFieldValues(fieldName){
    $('#add_work_schedules').modal('hide');
    Swal.fire({
        title: 'Warning!',
        text: `The ${fieldName} is missing. Please fill it up and try again.`,
        icon: 'warning',
        confirmButtonText: 'OK'
    });
}

function showSuccessCreate() {
    $('#add_work_schedules').modal('hide');
    Swal.fire({
        title: 'Success!',
        text: 'The work schedule has been created successfully.',
        icon: 'success',
        timer: 2000,
        confirmButtonText: 'OK'
    });
}

function showError(){
    Swal.fire({
        title: 'Error!',
        text: 'An error has occured. Please try again.',
        icon: 'error',
        confirmButtonText: 'OK'
    }).then((result) => {
        if(result.isConfirmed){
            window.location.href = SMARTWAGE_LOCATION + "/work-schedule";
        }
    });
}