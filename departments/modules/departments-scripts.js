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
            fetchAllDepartments(result.value);
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

function getPrintSortByColumn(){
    var sortBy = selectedOptions.sort_by;
    return sortBy;
}

function getPrintOrderBy(){
    var orderBy = selectedOptions.order_by;
    return orderBy;
}

function getPrintByDate(){
    var byDate = selectedOptions.by_date;
    return byDate;
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


function updateDepartmentClick(button){

    const row = button.closest('tr');  // Get the closest row
    const departmentData = {
        token: row.getAttribute('data-id'),
        name: row.getAttribute('data-name'),
        departHeadId: row.getAttribute('data-dept-head-id'),
        departmentHeadId: row.getAttribute('data-department-head-id'),
        description: row.getAttribute('data-description'),
        status: row.getAttribute('data-status')
    };

    const txtDepartmentName = $("#update_department_name");
    const txtDepartmentHeadId = $("#update_department_head");
    const txtDepartmentDescription = $("#update_department_description");
    const $select = $('#update_department_head').selectize();
    const txtDepartmentStatus = $("#update_department_status");
    const btnUpdateDepartment = document.getElementById('update_department_btn');

    txtDepartmentName.val(departmentData.name);
    txtDepartmentHeadId.val(departmentData.departmentHeadId);
    txtDepartmentDescription.val(departmentData.description);
    txtDepartmentStatus.val(departmentData.status);
    // Get the Selectize instance
    var selectize = $select[0].selectize;
    // Set a value
    selectize.setValue(departmentData.departHeadId);
    btnUpdateDepartment.setAttribute('data-token', departmentData.token);
    
}

function confirmDeleteDepartment(button) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to delete this department?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
        deleteDepartment(button);
        Swal.fire(
            'Deleted!',
            'This department has been deleted.',
            'success'
        );
        }
    });
}

function showSuccessCreate() {
    const modal = $('#add-departments-modal');
    modal.modal('hide');
    const form = $('#add-departments-form');
    modal.modal('hide');
    Swal.fire({
        title: 'Created!',
        text: 'The department has been CREATED successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
    form.get(0).reset();
}

function showSuccessUpdate() {
    const modal = $('#update_departments_modal');
    modal.modal('hide');
    const form = $('#update_departments_form');
    Swal.fire({
        title: 'Updated!',
        text: 'This department has been UPDATED successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
    form.get(0).reset();
}

function showSuccessDelete() {
    Swal.fire({
        title: 'Deleted!',
        text: 'The department has been DELETED successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
}

function showValidationError(errorMessages) {
    $('#add-departments-modal').modal('hide');
    $('#update_departments_modal').modal('hide');

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
    $('#add-departments-modal').modal('hide');
    $('#update_departments_modal').modal('hide');
    Swal.fire({
        title: 'Error!',
        text: message,
        icon: 'error',
        confirmButtonText: 'OK'
    });
}

function showFatalError(message) {
    $('#add-departments-modal').modal('hide');
    $('#update_departments_modal').modal('hide');
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

function showCouldNotFindData(){
    Swal.fire({
        title: 'Error!',
        text: 'The department data does not exist.',
        icon: 'errror',
        confirmButtonText: 'OK'
    });
}