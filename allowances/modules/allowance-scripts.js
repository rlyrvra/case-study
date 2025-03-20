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
            fetchAllAllowances(result.value);
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

function showWarningIncompleteForm() {
    $('#add-allowances-modal').modal('hide');
    Swal.fire({
        title: 'Warning',
        text: 'Please fill up the required details (*) in the form.',
        icon: 'warning',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#add-allowances-modal').modal('show');
        }
    });
}

function showSuccessCreate() {
    $('#add-allowances-modal').modal('hide');
    Swal.fire({
        title: 'Success!',
        text: 'This allowance has been created successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
}

function showSuccessUpdate() {
    $('#update-allowances-modal').modal('hide');
    Swal.fire({
        title: 'Success!',
        text: 'This allowance has been updated successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
}



function showSuccessDeletion() {
    Swal.fire({
        title: 'Success!',
        text: 'This allowance has been deleted successfully.',
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


function missingFieldValues(fieldName){
    $('#add-allowances-modal').modal('hide');
    $('#update-allowances-modal').modal('hide');
    Swal.fire({
        title: 'Warning!',
        text: `The ${fieldName} is missing. Please fill it up and try again.`,
        icon: 'warning',
        confirmButtonText: 'OK'
    });
}

function updateAllowanceClick(button){

    const row = button.closest('tr');  // Get the closest row
    const allowanceData = {
        token: row.getAttribute('data-id'),
        name: row.getAttribute('data-name'),
        amount: row.getAttribute('data-amount'),
        frequency: row.getAttribute('data-frequency'),
        description: row.getAttribute('data-description'),
        status: row.getAttribute('data-status')
    };

    const allowanceName = $('#update_name');
    const allowanceAmount = $('#update_amount');
    const allowanceFrequency = $('#update_frequency');
    const allowanceDesc = $('#update_description');
    const allowanceStatus = $('#update_status');
    const btnUpdateAllowance = document.getElementById('update_allowance_btn');

    allowanceName.val(allowanceData.name);
    allowanceAmount.val(allowanceData.amount);
    allowanceFrequency.val(allowanceData.frequency);
    allowanceDesc.val(allowanceData.description);
    allowanceStatus.val(allowanceData.status);
    btnUpdateAllowance.setAttribute('data-token', allowanceData.token);
    
}

function confirmDeleteAllowance(button) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to delete this allowance?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
        deleteAllowance(button);
        Swal.fire(
            'Deleted!',
            'The allowance has been deleted.',
            'success'
        );
        }
    });
}