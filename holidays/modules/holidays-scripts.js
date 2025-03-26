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
            fetchAllHolidays(result.value);
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

function getByDate(){
    var byDate = selectedOptions.by_date;
    return byDate;
}

function getViewMode() {
    let selected = document.querySelector('input[name="view"]:checked');
    return selected ? selected.value : '';
}

function missingFieldValues(fieldName){
    $('#add-holidays-modal').modal('hide');
    $('#update-holidays-modal').modal('hide');
    Swal.fire({
        title: 'Warning!',
        text: `The ${fieldName} is missing. Please fill it up and try again.`,
        icon: 'warning',
        confirmButtonText: 'OK'
    });
}

function clickCardEvent(card, event){
    // Prevent modal from opening if the clicked element are buttons
    if (event.target.closest('.btn')) {
        return;
    }
    
    const button = card.querySelector('[onclick="updateHolidayClick(this)"]');
    if(!button){
        return;
    }
    $('#update-holidays-modal').modal('show');
    updateHolidayClick(button);
}

function updateHolidayClick(button){
    const row = button.closest('tr');  // Get the closest row
    const holidayData = {
        token: row.getAttribute('data-id'),
        name: row.getAttribute('data-name'),
        start_date: row.getAttribute('data-start'),
        end_date: row.getAttribute('data-end'),
        isPaid: row.getAttribute('data-paid'),
        isRecurring: row.getAttribute('data-recurring'),
        description: row.getAttribute('data-description'),
        status: row.getAttribute('data-status')
    };

    const holidayName = $('#update_name');
    const holidayStart = $('#update_start_date');
    const holidayEnd = $('#update_end_date');
    const holidayIsPaid = $('#update_isPaid');
    const holidayIsRecurring = $('#update_isRecurring');
    const holidayDescription = $('#update_description');
    const holidayStatus = $("#update_status");
    const btnUpdateHoliday = document.getElementById('update_allowance_btn');

    holidayName.val(holidayData.name);
    holidayStart.val(holidayData.start_date);
    holidayEnd.val(holidayData.end_date);
    holidayIsPaid.prop('checked', holidayData.isPaid == 1);
    holidayIsRecurring.prop('checked', holidayData.isRecurring == 1);
    holidayDescription.val(holidayData.description);
    holidayStatus.val(holidayData.status);
    btnUpdateHoliday.setAttribute('data-token', holidayData.token);

    


}


function confirmDeleteHoliday(button) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to delete this holiday?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
        deleteHoliday(button);
        }
    });
}



// Initialize the calendar once the document is loaded
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    const events = {
        events: holidays.map(event => {
            const eventObj = {
                title: event.name,
                start: event.start_date,
                end: event.end_date,
                description: event.description
            };
    
            // Check if the event is recurring annually
            if (event.is_recurring_annually) {
                eventObj.rrule = {
                    freq: 'yearly',
                    dtstart: event.start_date
                };
            }
    
            return eventObj;
        })
    };
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',  // Set initial view to month view
        themeSystem: 'bootstrap5',
        events: events,
        headerToolbar: {
            left: 'prev,next today',    // Buttons to navigate to previous, next, and today
            center: 'title',            // Display the title of the calendar
            right: 'dayGridMonth, listMonth'  // Views for month, week, and day
        }
    });
    calendar.render();

    // Function to update the view based on the screen size
    function checkScreenSize() {
        // Use window.matchMedia to check the screen size
        if (window.matchMedia('(max-width: 991px)').matches) {
            // If the screen is smaller than 992px (Bootstrap col-lg), switch to list view
            calendar.changeView('listMonth');
        } else {
            // If the screen is larger, switch back to month view
            calendar.changeView('dayGridMonth');
        }
    }

    // Initial check
    checkScreenSize();

    // Listen for window resize events and adjust the calendar view accordingly
    window.addEventListener('resize', checkScreenSize);
});


function showSuccessCreate() {
    $('#add-holidays-modal').modal('hide');
    Swal.fire({
        title: 'Success!',
        text: 'This holiday has been created successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
    $('#add_holidays_form').get(0).reset();
}

function showSuccessUpdate(){
    $('#update-holidays-modal').modal('hide');
    Swal.fire({
        title: 'Success!',
        text: 'This holiday has been updated successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
    $('#update_holidays_form').get(0).reset();
}

function showSuccessDelete() {
    Swal.fire({
        title: 'Success!',
        text: 'This holiday has been deleted successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
}

function showValidationError(errorMessages, modal) {
    $('#add-holidays-modal').modal('hide');
    $('#update-holidays-modal').modal('hide');

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
    }).then((result) => {
        if (result.isConfirmed) {
            modal.modal('show');
        }
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