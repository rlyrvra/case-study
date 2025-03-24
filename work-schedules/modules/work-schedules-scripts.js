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

function fetchPage(){
    Swal.fire({
        title: 'Enter a Number',
        input: 'number',
        inputAttributes: {
            min: 1,
            max: getMaxPageValue(),
            step: 1
        },
        showCancelButton: true,
        confirmButtonText: 'Submit',
        cancelButtonText: 'Cancel',
        preConfirm: (value) => {
            if (!value || isNaN(value)) {
                Swal.showValidationMessage('Please enter a valid number');
            }
            return value;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetchAllWorkSchedules(result.value);
        }
    });
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

function getViewMode() {
    let selected = document.querySelector('input[name="view"]:checked');
    return selected ? selected.value : '';
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
    
    endTimeSelect.addEventListener("change", resetBreakHours);
    startTimeSelect.addEventListener("change", resetBreakHours);
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

        // Handle overnight shift (endTime is technically the next day)
        if (endDate < startDate) {
            endDate.setDate(endDate.getDate() + 1); 
        }

        let diff = ((endDate - startDate) / (1000 * 60 * 60)) - (totalBreakMinutes / 60);

        totalWorkHrs.value = diff.toFixed(2);
    }
    
    
}

function resetBreakHours(){
    const rows = document.getElementById('create_break_assignment_table_body').getElementsByTagName('tr');
    const startTime = document.getElementById("startTime").value;
    const endTime = document.getElementById("endTime").value;
    const startDate = new Date(`1970-01-01T${convertTo24Hour(startTime)}`);
    const endDate = new Date(`1970-01-01T${convertTo24Hour(endTime)}`);
    const selectedBreaks = getCreateBreaksValues(rows);
    for (let i = 0; i < rows.length; i++) {
        let row = rows[i];
        row.cells[2].children[0].innerHTML = "";
        row.cells[2].children[0].innerHTML = generateBreakOptions(startDate, endDate);
        row.cells[2].children[0].value = "";
        row.cells[3].children[0].value = "";
    }
    const totalWorkHrs = document.getElementById("totalWorkHours");
    calculateWorkHours(rows, startTime, endTime, selectedBreaks, totalWorkHrs);
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
    // console.log(`Raw time: ${time}`);
    // Insert a space if it's missing between the time and AM/PM
    const formattedTime = time.replace(/(AM|PM)$/, " $1");
    // console.log(`Formatted Time: ${moment(formattedTime, "h:mm A").format("HH:mm")}`);
    return moment(formattedTime, "h:mm A").format("HH:mm");

}



let rowAddedWork = false;
function addWorkSchedulesBreakCreate() {
    const form = document.getElementById("work_schedules_add_form");
    if(!form.checkValidity()){
        const modal = $('#add_work_schedules');
        showFormIncomplete(modal);
        return;
    }

    if(rowAddedWork){
        return;
    }
    const isFlextime = Boolean(document.getElementById('isFlextime').checked);

    if(isFlextime){
        return;
    }

    const tableBody = document.getElementById('create_break_assignment_table_body'); // Ensure we target tbody
    if(tableBody.rows.length >= 5){
        return;
    }

    const startTime = document.getElementById("startTime").value;
    const endTime = document.getElementById("endTime").value;

    if(startTime === '' && endTime === ''){
        showTimeNullable();
        return;
    }



    const startDate = new Date(`1970-01-01T${convertTo24Hour(startTime)}`);
    const endDate = new Date(`1970-01-01T${convertTo24Hour(endTime)}`);
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
            `;
    breaksAddHTML += generateBreakOptions(startDate, endDate);
    breaksAddHTML += `
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
    const sumTime = new Date(startTime.getTime() + addMinutes * 60000).toLocaleTimeString('en-US', format).replace(/\s/g, '');
    row.querySelector('#create_end_time').value = sumTime;
    rowAddedWork = false;
    getCreateBreaksValues(rows = document.getElementById('create_break_assignment_table_body').getElementsByTagName('tr'));
}

function cancelBreakAssignment(button){
    const row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
    rowAddedWork = false;
}

function getCreateBreaksValues(rows) {
    const workScheduleBreaks = [];

    
    for (let i = 0; i < rows.length; i++) {
        const row = rows[i];
        const breakTypeId = row.cells[0].children[0].value;
        const paid = row.cells[1].children[0].innerHTML;
        const startTime = row.cells[2].children[0].value;
        const endTime = row.cells[3].children[0].value;

        if (breakTypeId && breakTypeId !== "" && startTime !== "") {
            const start24 = convertTo24Hour(startTime);
            const end24 = convertTo24Hour(endTime);

            // Check for overlaps with previously added breaks
            let hasOverlap = workScheduleBreaks.some(breakItem => 
                (start24 <= breakItem.end_time && end24 > breakItem.start_time)
            );            

            if (hasOverlap) {
                // Clear overlapping row values
                row.cells[0].children[0].value = "";
                row.cells[2].children[0].value = "";
                row.cells[3].children[0].value = "";
            } else {
                workScheduleBreaks.push({
                    id: breakTypeId,
                    paid: paid,
                    start_time: start24,
                    end_time: end24
                });
            }
        }
    }

    return workScheduleBreaks;
}

function clickCardEvent(card, event){
    // Prevent modal from opening if the clicked element are buttons
    if (event.target.closest('.btn')) {
        return;
    }

    const button = card.querySelector('[onclick="fetchBreakTypes(); fetchWorkScheduleAndBreak(this);"]');
    if(!button){
        return;
    }
    $('#update_work_schedules').modal('show');
    fetchBreakTypes();
    fetchWorkScheduleAndBreak(button);
}

function updateWorkScheduleData(data){

    const workSchedule = data[0].work_schedule_data[0];

    document.getElementById("update_startTime").value = normalizeTime(workSchedule.start_time);
    document.getElementById("update_endTime").value = normalizeTime(workSchedule.end_time);
    document.getElementById("update_isFlextime").checked = workSchedule.is_flextime;
    if(workSchedule.is_flextime == 1) document.getElementById("update_flextimeOptions").classList.add('show'); 
    if(workSchedule.is_flextime == 0) document.getElementById("update_flextimeOptions").classList.remove('show');
    document.getElementById("update_totalHoursPerWeek").value = parseFloat(workSchedule.total_hours_per_week / 6);
    document.getElementById("update_totalWorkHours").value = workSchedule.total_work_hours;
    updateFlextimeEnabled();
}


function populateWorkSchedulesBreak(data) {
    const tableBody = document.getElementById('update_break_assignment_table_body'); // Ensure we target tbody
    tableBody.innerHTML = "";
    if(tableBody.rows.length >= 5){
        return;
    }
    if(Array.isArray(data) && data.length === 0){
        return;
    }
    const startTime = document.getElementById("update_startTime").value;
    const endTime = document.getElementById("update_endTime").value;
    const startDate = new Date(`1970-01-01T${convertTo24Hour(startTime)}`);
    const endDate = new Date(`1970-01-01T${convertTo24Hour(endTime)}`);
    
    const currentBreaks = data[1].break_schedules_data; 
    currentBreaks.forEach(currentBreak => {
        const row = document.createElement('tr');
        row.setAttribute('data-token', currentBreak.id);
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
                `;
        breaksAddHTML += generateBreakOptions(startDate, endDate);
        breaksAddHTML += `
            </select>
        </td>
        <td>
            <input type="text" class="form-control" id="update_end_time" readonly required/>
        </td>
        <td>
            <button class="btn btn-danger" title="Click to Delete" onclick="deleteBreakSchedules(this); cancelBreakAssignment(this); updateCalculateWorkHrs();">
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
        time_start = normalizeTime(currentBreak.start_time),
        time_end = normalizeTime(currentBreak.end_time)
        );
    });
    updateCalculateWorkHrs();
}

// Normalize time to "H:MMAM/PM" format
function normalizeTime(time) {
    return new Date(`1970-01-01T${time}`)
        .toLocaleTimeString('en-US', { timeStyle: 'short', hour12: true })
        .replace(/\s/g, ''); // Remove spaces
}

// Function to add hours to a date
function addHours(date, hours) {
    const newDate = new Date(date);
    newDate.setHours(newDate.getHours() + hours);
    return newDate;
}

function generateBreakOptions(startDate, endDate) {
    let breaksAddHTML = ''; // Initialize the variable properly

    // Handle overnight shifts (endDate is technically the next day)
    if (endDate < startDate) {
        endDate.setDate(endDate.getDate() + 1);
    }

    let currentDate = new Date(startDate); // Ensure we don't mutate the original startDate

    while (currentDate <= endDate) {
        let formattedTime = currentDate.toLocaleTimeString('en-US', { timeStyle: 'short', hour12: true }).replace(/\s/g, '');

        breaksAddHTML += `
        <option value="${formattedTime}">${formattedTime}</option>`;

        currentDate = addHours(currentDate, 1); // Increment by 1 hour
    }
    return breaksAddHTML;
}

let rowAddedUpdate = false;
function updateWorkSchedulesBreakCreate(){
    const form = document.getElementById("work_schedules_update_form");
    if(!form.checkValidity()){
        const modal = $('#update_work_schedules')
        showFormIncomplete(modal);
        return;
    }
    if(rowAddedUpdate){
        return;
    }

    const isFlextime = Boolean(document.getElementById('update_isFlextime').checked);

    if(isFlextime){
        return;
    }

    const tableBody = document.getElementById('update_break_assignment_table_body'); // Ensure we target tbody
    if(tableBody.rows.length >= 5){
        return;
    }
    const startTime = document.getElementById("update_startTime").value;
    const endTime = document.getElementById("update_endTime").value;

    if(startTime === '' && endTime === ''){
        showTimeNullable();
        return;
    }


    const startDate = new Date(`1970-01-01T${convertTo24Hour(startTime)}`);
    const endDate = new Date(`1970-01-01T${convertTo24Hour(endTime)}`);

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
            <option value="" selected disabled>Select start time...</option>`;
    breaksAddHTML += generateBreakOptions(startDate, endDate);
    breaksAddHTML += `
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

function updateResetBreakHours(){
    const rows = document.getElementById('update_break_assignment_table_body').getElementsByTagName('tr');
    const startTime = document.getElementById("update_startTime").value;
    const endTime = document.getElementById("update_endTime").value;
    const startDate = new Date(`1970-01-01T${convertTo24Hour(startTime)}`);
    const endDate = new Date(`1970-01-01T${convertTo24Hour(endTime)}`);
    const selectedBreaks = getCreateBreaksValues(rows);
    for (let i = 0; i < rows.length; i++) {
        let row = rows[i];
        row.cells[2].children[0].innerHTML = "";
        row.cells[2].children[0].innerHTML = generateBreakOptions(startDate, endDate);
        row.cells[2].children[0].value = "";
        row.cells[3].children[0].value = "";
    }
    const totalWorkHrs = document.getElementById("update_totalWorkHours");
    calculateWorkHours(rows, startTime, endTime, selectedBreaks, totalWorkHrs);
}

function updateCalculateWorkHrs(){
    const rows = document.getElementById('update_break_assignment_table_body').getElementsByTagName('tr');
    const startTime = document.getElementById("update_startTime").value;
    const endTime = document.getElementById("update_endTime").value;
    const selectedBreaks = getCreateBreaksValues(rows);
    const totalWorkHrs = document.getElementById("update_totalWorkHours");
    rowAddedUpdate = false;
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
    const startTime = new Date(`1970-01-01T${convertTo24Hour(row.querySelector('#update_start_time').value)}`);
    const addMinutes = matchingBreak.duration_in_minutes;
    const sumTime = new Date(startTime.getTime() + addMinutes * 60000).toLocaleTimeString('en-US', format).replace(/\s/g, '');
    row.querySelector('#update_end_time').value = sumTime;
    rowAddedWork = false;
    getCreateBreaksValues(rows = document.getElementById('create_break_assignment_table_body').getElementsByTagName('tr'));
}


function findDifferences(currentBreakSchedules, updatedBreakSchedules) {
    const differences = [];
  
    // Normalize currentBreakSchedules times
    const normalizedCurrentBreakSchedules = currentBreakSchedules.map((currentBreak) => ({
      ...currentBreak,
      start_time: normalizeTime(currentBreak.start_time),
      end_time: normalizeTime(currentBreak.end_time)
    }));

    // console.log(normalizedCurrentBreakSchedules);
  
    // Process updatedBreakSchedules (remove "paid" and convert "id" to int)
    const processedUpdatedBreakSchedules = updatedBreakSchedules.map((updatedBreak) => {
      const { id, paid, ...rest } = updatedBreak; // Remove "paid" key
      return {
        ...rest,
        break_type_id: parseInt(updatedBreak.id, 10), // Convert "id" to integer
        start_time: normalizeTime(updatedBreak.start_time),
        end_time:normalizeTime(updatedBreak.end_time),
      };
    });

    //console.log(processedUpdatedBreakSchedules);
  
    // Compare the processed to normalized schedules
    processedUpdatedBreakSchedules.forEach((updatedBreak, index) => {
        const currentBreak = normalizedCurrentBreakSchedules[index];
        
        // If the item is missing in normalizedCurrentBreakSchedules
        if (!currentBreak) {
            differences.push(updatedBreak);
            return;
        }
        
        // Ensure "id" key from currentBreak is retained if it exists
        const differenceEntry = { ...updatedBreak };
            if (currentBreak.id !== undefined) {
            differenceEntry.id = currentBreak.id;
        }
        
        // Compare each key in the objects
        for (const key in updatedBreak) {
            if (updatedBreak[key] !== currentBreak[key]) {
                differences.push(differenceEntry);
                break;
            }
        }
    });
  
    
    const formattedBreakSchedules = differences.map((formattedBreakSchedule) =>{
        const {...rest} = formattedBreakSchedule;
        return{
            ...rest,
            start_time: convertTo24Hour(formattedBreakSchedule.start_time),
            end_time: convertTo24Hour(formattedBreakSchedule.end_time)
        }
    });

    return formattedBreakSchedules;
}

function createFlextimeEnabled(){
    const isFlextime = Boolean(document.getElementById('isFlextime').checked);
    if(isFlextime){
        const startTime = document.getElementById('startTime');
        startTime.disabled = true;
        startTime.required = false;
        startTime.value = "";
        const endTime = document.getElementById('endTime');
        endTime.disabled = true;
        endTime.required = false;
        endTime.value = "";
        const workHrs = document.getElementById('totalWorkHours');
        workHrs.value = 0.00;
        const tableBody = document.querySelector('#create_break_assignment table tbody');
        if (tableBody) {
            tableBody.innerHTML = "";
        }
        rowAddedWork = false;
    }else{
        const startTime = document.getElementById('startTime');
        startTime.disabled = false;
        startTime.required = true;
        const endTime = document.getElementById('endTime');
        endTime.disabled = false;
        endTime.required = true;
        const workHrs = document.getElementById('totalWorkHours');
        workHrs.value = 0.00;
    }
    
}

function updateFlextimeEnabled(){
    const isFlextime = Boolean(document.getElementById('update_isFlextime').checked);
    if(isFlextime){
        const startTime = document.getElementById('update_startTime');
        startTime.disabled = true;
        startTime.required = false;
        startTime.value = "";
        const endTime = document.getElementById('update_endTime');
        endTime.disabled = true;
        endTime.required = false;
        endTime.value = "";
        const tableBody = document.querySelector('#update_break_assignment table tbody');
        if (tableBody) {
            tableBody.innerHTML = "";
        }
        rowAddedUpdate = false;
    }else{
        const startTime = document.getElementById('update_startTime');
        startTime.disabled = false;
        startTime.required = true;
        const endTime = document.getElementById('update_endTime');
        endTime.disabled = false;
        endTime.required = true;
        const workHrs = document.getElementById('update_totalWorkHours');
        workHrs.value = 0.00;
    }
    
}




function showFormIncomplete(modal){
    modal.modal('hide');
    Swal.fire({
        title: 'Warning!',
        text: 'Please fill up the create form.',
        icon: 'warning',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            modal.modal('show');
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
    $('#update_work_schedules').modal('hide');
    Swal.fire({
        title: 'Success!',
        text: message,
        icon: indicator,
        confirmButtonText: 'OK'
    });
}


function showTimeNullable() {
    $('#add_work_schedules').modal('hide');
    $('#update_work_schedules').modal('hide');
    Swal.fire({
        title: 'Error!',
        text: 'Flexitime cannot have assigned breaks.',
        icon: 'warning',
        confirmButtonText: 'OK'
    });
}

function showSuccessDeletion() {
    Swal.fire({
        title: 'Success!',
        text: 'This work schedule has been deleted successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
}

function showSuccessDeletionBreakSchedule(){
    Swal.fire({
        title: 'Success!',
        text: 'This break schedule has been removed from the work schedule successfully.',
        icon: 'success',
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