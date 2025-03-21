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
            fetchAllJobTitles(result.value);
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

function clickCardEvent(card, event){
    // Prevent modal from opening if the clicked element are buttons
    if (event.target.closest('.btn')) {
        return;
    }

    const button = card.querySelector('[onclick="updateJobTitleClick(this)"]');
    if(!button){
        return;
    }
    $('#update_job_titles_modal').modal('show');
    updateJobTitleClick(button);
}


function updateJobTitleClick(button){

    const row = button.closest('tr');  // Get the closest row
    const jobTitleData = {
        token: row.getAttribute('data-id'),
        title: row.getAttribute('data-title'),
        department_id: row.getAttribute('data-department-id'),
        department_name: row.getAttribute('department_name'),
        description: row.getAttribute('data-description'),
        status: row.getAttribute('data-status')
    };

    const txtJobTitleName = $("#update_jobtitle_title");
    const txtDescription = $("#update_jobtitle_description");
    const $select = $('#update_jobtitle_department_name').selectize();
    const btnUpdateJobTitle = document.getElementById('update_department_btn');

    txtJobTitleName.val(jobTitleData.title);
    txtDescription.val(jobTitleData.description);
    // Get the Selectize instance
    var selectize = $select[0].selectize;
    // Set a value
    selectize.setValue(jobTitleData.department_id);
    btnUpdateJobTitle.setAttribute('data-token', jobTitleData.token);
    
}

function confirmDeleteJobTitle(button) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to delete this job title?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
        deleteJobTitle(button);
        }
    });
}


function confirmDeleteDepartment(button) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to delete this job title?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    })
}


function showSuccessCreate() {
    const modal = $('#add_job_titles_modal');
    modal.modal('hide');
    const form = $('#create_job_title_form');
    Swal.fire({
        title: 'Created!',
        text: 'The job title has been CREATED successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
    form.get(0).reset();
}

function showSuccessUpdate() {
    const modal = $('#update_job_titles_modal');
    modal.modal('hide');
    const form = $('#update_job_title_form');
    form.modal('hide');
    Swal.fire({
        title: 'Updated!',
        text: 'This job title has been UPDATED successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
    form.get(0).reset();
}

function showSuccessDelete() {
    Swal.fire({
        title: 'Deleted!',
        text: 'This job title has been DELETED successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
}

function showFatalError(message) {
    const modal = $('#add_job_titles_modal');
    modal.modal('hide');
    const modal2 = $('#update_job_titles_modal');
    modal2.modal('hide');
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


function showError(message) {
    const modal = $('#add_job_titles_modal');
    modal.modal('hide');
    const modal2 = $('#update_job_titles_modal');
    modal2.modal('hide');
    Swal.fire({
        title: 'Error!',
        text: message,
        icon: 'error',
        confirmButtonText: 'OK'
    });
}

function showCouldNotFindData(){
    const modal = $('#add_job_titles_modal');
    modal.modal('hide');
    const modal2 = $('#update_job_titles_modal');
    modal2.modal('hide');
    Swal.fire({
        title: 'Error!',
        text: 'The job title data does not exist.',
        icon: 'errror',
        confirmButtonText: 'OK'
    });
}