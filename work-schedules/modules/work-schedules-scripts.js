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
    const totalHours = document.getElementById('totalHoursPerWeek');

    isFlextimeCheckbox.addEventListener('change', function () {
        const isRequired = isFlextimeCheckbox.checked;

        totalHours.required = isRequired;
        
    });
    
});

document.addEventListener("DOMContentLoaded", function () {
    const startTimeSelect = document.getElementById("startTime");
    const endTimeSelect = document.getElementById("endTime");
    
    endTimeSelect.addEventListener("change", createCalculateWorkHrs);
});

function calculateWorkHours(rows, startTime, endTime, selectedBreaks, totalWorkHrs) {
    if (startTime && endTime) {
        const startDate = new Date(`1970-01-01T${convertTo24Hour(startTime)}`);
        const endDate = new Date(`1970-01-01T${convertTo24Hour(endTime)}`);

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

        totalWorkHrs.value = diff;
    }
    
    
}

function createCalculateWorkHrs(){
    const rows = document.getElementById('create_break_assignment_table_body').getElementsByTagName('tr');
    const startTime = document.getElementById("startTime").value;
    const endTime = document.getElementById("endTime").value;
    const selectedBreaks = getCreateBreaksValues(rows);
    const totalWorkHrs = document.getElementById("totalWorkHours");
    calculateWorkHours(rows, startTime, endTime, selectedBreaks, totalWorkHrs);
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
        <select class="form-select" id="create_start_time" name="create_start_time" required onchange="updateEndTime(this); createCalculateWorkHrs();">
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
        <button class="btn btn-danger" title="Click to Delete" onclick="cancelBreakAssignment(this); createCalculateWorkHrs();">
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
    const row = select.closest('tr');
    const status = row.querySelector('#paid_status');
    const startTime = row.querySelector('#create_start_time');
    const endTime = row.querySelector('#create_end_time');
    const token = parseInt(select.value, 10);
    const matchingBreak = breakTypes.find(breakType => breakType.id === token);
    const matchingBreakPaid = matchingBreak.is_paid;
    const paidStatus = status;
    if(matchingBreakPaid === 1){
        paidStatus.classList.remove('bg-danger');
        paidStatus.classList.add('bg-success');
        paidStatus.innerHTML = "PAID"
    }else{
        paidStatus.classList.add('bg-danger');
        paidStatus.classList.remove('bg-success');
        paidStatus.innerHTML = "UNPAID"
    }
    startTime.value = '';
    endTime.value = '';

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
    getCreateBreaksValues(rows = document.getElementById('create_break_assignment_table_body').getElementsByTagName('tr'));
}

function cancelBreakAssignment(button){
    const row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
    rowAddedWork = false;
}

// JavaScript function to get all values in the table
function getCreateBreaksValues(rows) {
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

function updateWorkScheduleData(data){

    const workSchedule = data[0].work_schedule_data[0];

    document.getElementById("update_startTime").value = new Date(`1970-01-01T${workSchedule.start_time}`).toLocaleTimeString('en-US', { timeStyle: 'short', hour12: true }).replace(/\s/g, '');
    document.getElementById("update_endTime").value = new Date(`1970-01-01T${workSchedule.end_time}`).toLocaleTimeString('en-US', { timeStyle: 'short', hour12: true }).replace(/\s/g, '');
    document.getElementById("update_isFlextime").checked = workSchedule.is_flextime;
    if(workSchedule.is_flextime == 1) document.getElementById("update_flextimeOptions").classList.add('show');
    if(workSchedule.is_flextime == 0) document.getElementById("update_flextimeOptions").classList.remove('show');
    document.getElementById("update_totalHoursPerWeek").value = workSchedule.total_hours_per_week;
    document.getElementById("update_totalWorkHours").value = workSchedule.total_work_hours;
}


function populateWorkSchedulesBreak(data, token = '') {
    const tableBody = document.getElementById('update_break_assignment_table_body'); // Ensure we target tbody
    tableBody.innerHTML = "";
    if(tableBody.rows.length >= 5){
        return;
    }
    if(Array.isArray(data) && data.length === 0){
        return;
    }
    const currentBreaks = data[1].break_schedules_data; 
    currentBreaks.forEach(currentBreak => {
        const row = document.createElement('tr');
        row.setAttribute('data-token', token);
        let breaksAddHTML = `
        <td>
            <select class="form-select" id="update_breaks" name="update_breaks" required onchange="updatePaidStatusUpdateForm(this)">
                `;
        breakTypes.forEach(breakType => {
            breaksAddHTML += "<option value='" + breakType.id + "'>" + breakType.name + "</option>";
        });
        breaksAddHTML += `
            </select>
        </td>
        <td>
            <span class="badge bg-badge" id="update_paid_status"></span>
        </td>
        <td>
            <select class="form-select" id="update_start_time" name="update_start_time" required onchange="updateEndTime(this); updateCalculateWorkHrs();">
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
            <input type="text" class="form-control" id="update_end_time" readonly required/>
        </td>
        <td>
            <button class="btn btn-danger" title="Click to Delete" onclick="cancelBreakAssignment(this); updateCalculateWorkHrs();">
                <i class="bx bx-trash"></i>
            </button> 
        </td>
        `;
        row.innerHTML = breaksAddHTML;
        tableBody.appendChild(row);
        updateSelect = row.querySelector('#update_breaks');
        updateSelect.value = currentBreak.break_type_id;
        updatePaidStatusUpdateForm(
        select = updateSelect, 
        time_start = new Date(`1970-01-01T${currentBreak.start_time}`).toLocaleTimeString('en-US', { timeStyle: 'short', hour12: true }).replace(/\s/g, ''),
        time_end = new Date(`1970-01-01T${currentBreak.end_time}`).toLocaleTimeString('en-US', { timeStyle: 'short', hour12: true }).replace(/\s/g, '')
        );
    });
    updateCalculateWorkHrs();
}

let rowAddedUpdate = false;
function updateWorkSchedulesBreakCreate(){
    if(rowAddedUpdate){
        return;
    }
    const tableBody = document.getElementById('update_break_assignment_table_body'); // Ensure we target tbody
    if(tableBody.rows.length >= 5){
        return;
    }
    const row = document.createElement('tr');

    let breaksAddHTML = `
    <td>
        <select class="form-select" id="update_breaks" name="update_breaks" required onchange="updatePaidStatusUpdateForm(this)">
            `;
    breakTypes.forEach(breakType => {
        breaksAddHTML += "<option value='" + breakType.id + "'>" + breakType.name + "</option>";
    });
    breaksAddHTML += `
        </select>
    </td>
    <td>
        <span class="badge bg-badge" id="update_paid_status"></span>
    </td>
    <td>
        <select class="form-select" id="update_start_time" name="update_start_time" required onchange="updateEndTimeAssignment(this); updateCalculateWorkHrs();">
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
        <input type="text" class="form-control" id="update_end_time" readonly required/>
    </td>
    <td>
        <button class="btn btn-danger" title="Click to Delete" onclick="deleteBreakAssignment(this); updateCalculateWorkHrs();">
            <i class="bx bx-trash"></i>
        </button> 
    </td>
    `;
    row.innerHTML = breaksAddHTML;
    tableBody.appendChild(row);
    rowAddedUpdate = true;
    updatePaidStatusUpdateForm(row.querySelector('#update_breaks'));
}

function updatePaidStatusUpdateForm(select, time_start = '', time_end = ''){
    const row = select.closest('tr');
    const status = row.querySelector('#update_paid_status');
    const startTime = row.querySelector('#update_start_time');
    const endTime = row.querySelector('#update_end_time');
    const token = parseInt(select.value, 10);
    const matchingBreak = breakTypes.find(breakType => breakType.id === token);
    const matchingBreakPaid = matchingBreak.is_paid;
    const paidStatus = status;
    if(matchingBreakPaid === 1){
        paidStatus.classList.remove('bg-danger');
        paidStatus.classList.add('bg-success');
        paidStatus.innerHTML = "PAID"
    }else{
        paidStatus.classList.add('bg-danger');
        paidStatus.classList.remove('bg-success');
        paidStatus.innerHTML = "UNPAID"
    }
    startTime.value = time_start;
    endTime.value = time_end;
}

function updateCalculateWorkHrs(){
    const rows = document.getElementById('update_break_assignment_table_body').getElementsByTagName('tr');
    const startTime = document.getElementById("update_startTime").value;
    const endTime = document.getElementById("update_endTime").value;
    const selectedBreaks = getCreateBreaksValues(rows);
    const totalWorkHrs = document.getElementById("update_totalWorkHours");
    calculateWorkHours(rows, startTime, endTime, selectedBreaks, totalWorkHrs);
}

function deleteBreakAssignment(button){
    const row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
    rowAddedUpdate = false;
}

function updateEndTimeAssignment(select){
    const row = select.closest('tr');  // Get the closest row
    const token = parseInt(row.querySelector('#update_breaks').value, 10);
    const matchingBreak = breakTypes.find(breakType => breakType.id === token);
    const format = { timeStyle: 'short', hour12: true };
    const startTime = new Date(`1970-01-01T${convertTo24Hour(row.querySelector('#update_startTime').value)}`);
    const addMinutes = matchingBreak.duration_in_minutes;
    const sumTime = new Date(startTime.getTime() + addMinutes * 60000).toLocaleTimeString('en-US', format);
    row.querySelector('#update_endTime').value = sumTime;
    rowAddedWork = false;
    getCreateBreaksValues(rows = document.getElementById('create_break_assignment_table_body').getElementsByTagName('tr'));
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

function showSuccessCreate(message = 'The work schedule has been created successfully.', indicator = 'success') {
    $('#add_work_schedules').modal('hide');
    Swal.fire({
        title: 'Success!',
        text: message,
        icon: indicator,
        confirmButtonText: 'OK'
    });
}

function showSuccessDeletion() {
    Swal.fire({
        title: 'Success!',
        text: 'This work schedule has been deleted successfully.',
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

function confirmDeleteWorkSchedule(button) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to delete this work schedule?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
        deleteWorkSchedule(button);
        }
    });
}