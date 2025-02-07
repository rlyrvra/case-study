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

function showCreatedSuccessAlert() {
    Swal.fire({
        title: 'Success!',
        text: 'Job title created successfully.',
        icon: 'success',
        timer: 2000,
        confirmButtonText: 'OK'
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
    }).then((result) => {
        if (result.isConfirmed) {
        deleteDepartment(button);
        Swal.fire(
            'Deleted!',
            'The job title has been deleted.',
            'success'
        );
        }
    });
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

function showSuccessUpdateAlert() {
    Swal.fire({
        title: 'Success!',
        text: 'Job Title updated successfully.',
        icon: 'success',
        timer: 2000,
        confirmButtonText: 'OK'
    });
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
        Swal.fire(
            'Deleted!',
            'The job title has been deleted.',
            'success'
        );
        }
    });
}