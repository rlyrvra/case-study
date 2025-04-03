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
            fetchLeaveRequests(result.value);
        }
    });
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

$(document).ready(function() {
    const startDate = document.getElementById('startDate');
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];
    const future = new Date();
    future.setFullYear(future.getFullYear() + 300); // Add 300 years
    const futureformattedDate = future.toISOString().split('T')[0];
    // Function to disable past dates based on the selected date
    startDate.addEventListener('focus', function() {
        startDate.setAttribute('min', formattedDate);
        startDate.setAttribute('max', futureformattedDate);
    });
    

    startDate.addEventListener("input", function () {
        const minDate = new Date(this.min);
        const maxDate = new Date(this.max);
        const currentDate = new Date(this.value);

        if (currentDate < minDate || currentDate > maxDate) {
            console.log("Hello");
            alert(`Please select a date between ${formattedDate} and ${futureformattedDate}.`);
            this.value = ""; // Clear invalid input
        }
    });

    document.getElementById("isHalfday").addEventListener("change", function () {
        let half_day_options = document.getElementById("half_day_options");
        if (this.checked) {
            half_day_options.required = true;
        } else {
            half_day_options.required = false;
        }
    });

});

function setStartDate(){
    const startDate = document.getElementById('startDate');
    startDate.disabled = false;
}

function setEndDateMin(date){
    const endDate = document.getElementById('endDate');
    if (!date.value || isNaN(new Date(date.value).getTime())){
        endDate.disabled = true;
        endDate.value = "";
        $("#totalDays").val("");
        return;
    }
    limitDate = new Date(date.value);
    limitDate.setDate(limitDate.getDate());
    const formattedDate = limitDate.toISOString().split('T')[0];
    endDate.setAttribute('min', formattedDate);
    endDate.value = "";
    endDate.disabled = false;
    endDate.removeEventListener("input", function () {
        
    });
    endDate.addEventListener("input", function () {
        const minDate = limitDate;
        const currentDate = new Date(this.value);

        if (currentDate < minDate) {
            alert(`Please select a date beyond ${formattedDate}`);
            this.value = ""; // Clear invalid input
        }
    });
}

function calculateTotalNumberOfDays(){
    const leaveTypeInput = document.getElementById("leaveType").value;
    const startDateId = document.getElementById('startDate').value;
    const endDateId = document.getElementById('endDate').value;
    let startDate, endDate, totalNumberOfDays;
    if(!startDateId || !endDateId){
        console.log("missing");
        return;
    }
    startDate = new Date(startDateId);
    endDate = new Date(endDateId);
    totalNumberOfDays = (endDate - startDate) / (1000 * 60 * 60 * 24);
    const isHalfDay = document.getElementById('isHalfday').checked;
    if(startDate.getDate() === endDate.getDate()){
        if(isHalfDay) totalNumberOfDays = 0.5;
        if(!isHalfDay) totalNumberOfDays = 1;
    }
    if(!checkHalfDayValidity(totalNumberOfDays, isHalfDay)){
        return false;
    }
    $("#totalDays").val(totalNumberOfDays);
    const remainingBalance = $("#remainingBalance").val();
    if(remainingBalance <= 0){
        return false;
    }
    if(totalNumberOfDays > remainingBalance){
        showInvalidBalance();
        return false;
    }
    return true;

}

function checkHalfDayValidity(numberOfDays, isHalfDay){
    if(numberOfDays > 1 && isHalfDay === true){
        Swal.fire({
            title: 'Warning!',
            text: 'Half day requests are only available for one day leaves.',
            icon: 'warning',
            confirmButtonText: 'OK'
        }).then((result) => {
            if(result.isConfirmed){
                formReset();
            }
        });
        return false;
    }
    return true;
}

function updateLeaveRequestClick(button){
    const row = button.closest('tr');  // Get the closest row
    const leaveRequestData = {
        token: row.getAttribute('data-token'),
        name: row.getAttribute('data-leave-type-name'),
        start_date: row.getAttribute('data-start-date'),
        end_date: row.getAttribute('data-end-date'),
        reason: row.getAttribute('data-reason')
    };

    //console.log(leaveRequestData);

    const leaveTypeName = $("#leaveType");
    const startDate = $("#startDate");
    const endDate = $("#endDate");
    const reason = $("#reason");

    leaveTypeName.val(leaveRequestData.token);
    startDate.val(leaveRequestData.start_date);
    endDate.val(leaveRequestData.end_date);
    reason.val(leaveRequestData.reason);
    document.getElementById("form_indicator").innerHTML = "Update My Leave";
    if(!calculateTotalNumberOfDays()) return;
}

function formReset(){
    document.getElementById('apply_leave_form').reset();
    const endDate = document.getElementById('endDate');
    const startDate = document.getElementById('startDate');
    const isHalfDay = document.getElementById('isHalfday').checked;
    document.getElementById('leaveType').value = "";
    document.getElementById('halfdayOptions').classList.remove("show");
    isHalfDay.checked = false;
    endDate.disabled = true;
    startDate.disabled = true;
    endDate.value = "";
    startDate.value = "";
    $("#totalDays").val("");
}

function showValidationError(errorMessages, modal) {

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

function showInvalidBalance(){
    Swal.fire({
        title: 'Error Request!',
        text: 'Your requested days is greater than your balance.',
        icon: 'error',
        confirmButtonText: 'OK'
    }).then((result) => {
        if(result.isConfirmed){
            formReset();
        }
    });
}

function showSuccessRequest(){
    Swal.fire({
        title: 'Request Success!',
        text: 'Your leave request has been filed.',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then((result) => {
        if(result.isConfirmed){
            formReset();
        }
    });
}

function showSuccessDeleteRequest(){
    Swal.fire({
        title: 'Delete Success!',
        text: 'Your leave request has been deleted.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
}

function showSuccessCancelRequest(){
    Swal.fire({
        title: 'Cancel Success!',
        text: 'Your leave request has been canceled.',
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
            window.location.href = "apply-leave";
        }
    });
}
