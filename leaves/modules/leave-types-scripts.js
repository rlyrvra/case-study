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
            fetchAllLeaveTypes(result.value);
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

// Function to add or remove the "Deleted At" option
function toggleDeletedAtOption() {
    const statusSelect = document.getElementById('status');
    const sortBySelect = document.getElementById('sortBy');
    // Check if the "Deleted At" option already exists
    let deletedAtOption = Array.from(sortBySelect.options).find(option => option.value === 'deleted_at');
    
    if (statusSelect.value === 'Archived') {
        // If "Archived" is selected and "Deleted At" option is not in Sort By, add it
        if (!deletedAtOption) {
            deletedAtOption = document.createElement('option');
            deletedAtOption.value = 'deleted_at';
            deletedAtOption.textContent = 'Deleted At';
            sortBySelect.appendChild(deletedAtOption);
        }
    } else {
        // If "Archived" is not selected, remove the "Deleted At" option if it exists
        if (deletedAtOption) {
            sortBySelect.removeChild(deletedAtOption);
        }
    }
}

function confirmDeleteLeaveTypes(button) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to delete this leave type?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
        deleteLeaveTypes(button);

        }
    });
}


function showSuccessDelete() {
    Swal.fire({
        title: 'Success!',
        text: 'This leave type has been deleted successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
}

function showSuccessCreate() {
    const modal = $('#add_leave_types_modal');
    modal.modal('hide');
    Swal.fire({
        title: 'Success!',
        text: 'This leave type has been created successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
    $('#add_leave_type_form').get(0).reset();
}

function showSuccessUpdate() {
    const modal = $('#update_leave_types_modal');
    modal.modal('hide');
    Swal.fire({
        title: 'Success!',
        text: 'This leave type has been updated successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
    $('#update_leave_type_form').get(0).reset();
}

function showDuplicateError() {
    const modal = $('#add_leave_types_modal');
    modal.modal('hide');
    const modal2 = $('#update_leave_types_modal');
    modal2.modal('hide');
    Swal.fire({
        title: 'Warning!',
        text: 'This leave type already exists.',
        confirmButtonText: 'OK'
    });
}

function missingFieldValues(fieldName){
    const modal = $('#add_leave_types_modal');
    modal.modal.hide();
    const modal2 = $('#update_leave_types_modal');
    modal2.modal.hide();
    Swal.fire({
        title: 'Warning!',
        text: `The ${fieldName} is missing. Please fill it up and try again.`,
        icon: 'warning',
        confirmButtonText: 'OK'
    });
}

function showValidationError(errorMessages) {
    $('#add_leave_types_modal').modal('hide');
    $('#update_leave_types_modal').modal('hide');

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
    const modal = $('#add_leave_types_modal');
    modal.modal.hide();
    const modal2 = $('#update_leave_types_modal');
    modal2.modal.hide();
    Swal.fire({
        title: 'Error!',
        text: message,
        icon: 'error',
        confirmButtonText: 'OK'
    });
}

function showFatalError(message) {
    const modal = $('#add_leave_types_modal');
    modal.modal.hide();
    const modal2 = $('#update_leave_types_modal');
    modal2.modal.hide();
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

function clickCardEvent(card, event){
    // Prevent modal from opening if the clicked element are buttons
    if (event.target.closest('.btn')) {
        return;
    }

    const button = card.querySelector('[onclick="updateLeaveTypeClick(this)"]');
    if(!button){
        return;
    }
    $('#update_leave_types_modal').modal('show');
    updateLeaveTypeClick(button);
}

function updateLeaveTypeClick(button){
    const row = button.closest('tr');  // Get the closest row
    const leaveTypeData = {
        token: row.getAttribute('data-id'),
        name: row.getAttribute('data-name'),
        maxNumberOfDays: row.getAttribute('data-maximum-number-of-days'),
        isPaid: row.getAttribute('data-is-paid'),
        description: row.getAttribute('data-description'),
        status: row.getAttribute('data-status')
    };

    const txtLeaveTypeName = document.getElementById('update_name');
    const txtMaxNumber = document.getElementById('update_maximum_number_of_days');
    const cbIsPaid = document.getElementById('update_is_paid');
    const txtDescription = document.getElementById('update_description');
    const txtStatus = document.getElementById('update_status');
    const btnUpdateLeaveType = document.getElementById('updateLeaveTypeBtn');

    txtLeaveTypeName.value = leaveTypeData.name;
    txtMaxNumber.value = leaveTypeData.maxNumberOfDays;
    cbIsPaid.checked = leaveTypeData.isPaid == '0' ? false : true; 
    txtDescription.value = leaveTypeData.description;
    txtStatus.value = leaveTypeData.status;
    btnUpdateLeaveType.setAttribute('data-token', leaveTypeData.token);

}