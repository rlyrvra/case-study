function fetchAllJobTitles() {
    $.ajax({
        url: 'apiTest.php',
        method: 'POST',
        data: {
            action: 'fetchAll'
        },
        dataType: 'html',
        success(response) {
            $('#job_title_table').html(response);
        },
        error(xhr, status, error) {
            console.error("Error fetching departments:", error);
        }
    });
}

function fetchAllSort(page = 1){
    var numberEntries = $("#entries").val();
    var sortByColumn = $("#sortBy").val();
    var pageNumber = getPage(page);
    if(sortByColumn == null) return;
    var sortOrderBy = $("#orderBy").val();
    if(sortOrderBy == null) return;
    var filterStatus = $("#status").val();
    var searchColumn = $("#searchColumn").val();
    var dateColumn = $("#dateColumn").val();
    var startDate, endDate;
    if(dateColumn !== "none"){
        startDate = $("#dateStart").val();
        endDate = $("#dateEnd").val();
    }
    var search = $("#searchText").val();

    
    console.log(`
        Number of Entries: ${numberEntries}, 
        Sort By Column: ${sortByColumn}, 
        Page Number: ${pageNumber}, 
        Sort Order By: ${sortOrderBy}, 
        Filter Status: ${filterStatus}, 
        Search At Column: ${searchColumn},
        Date Column: ${dateColumn}, 
        Start Date: ${startDate}, 
        End Date: ${endDate}, 
        Search Text: ${search}`);


    $.ajax({
        url: 'apiTest.php',
        type: 'POST',
        data: {
            action: 'fetchAllSort',
            page: pageNumber,
            numberEntries: numberEntries,
            sort_by: sortByColumn,
            sort_order: sortOrderBy,
            filter_status: filterStatus,
            filter_searchAt: searchColumn,
            filter_search: search,
            filter_date_column: dateColumn,
            filter_startDate: startDate,
            filter_endDate: endDate
        },
        success: function(response) {
            $('#job_title_table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function createJobTitle() {
    const jobTitleName = document.getElementById('createJobTitle_title').value;
    const jobTitleDepartmentName = document.getElementById('createJobTitle_department_name').value;
    const jobTitleDescription = document.getElementById('createJobTitle_description').value;
    const jobTitleStatus = document.getElementById('createJobTitle_status').value;

    console.log(`Job Title Name: ${jobTitleName}, 
        Job Title Department Name: ${jobTitleDepartmentName}, 
        Job Title Description: ${jobTitleDescription}, 
        Job Title Status: ${jobTitleStatus}`);

    const jobTitleData = {
        title: jobTitleName,
        department_id: jobTitleDepartmentName,
        description: jobTitleDescription,
        status: jobTitleStatus,
    };

    $.ajax({
        url: 'apiTest.php',
        method: 'POST',
        data: {
            action: 'create',
            job_title: jobTitleData
        },
        success(response) {
            fetchAllSort();
            document.getElementById('create_job_title_form').reset();
        },
        error(xhr, status, error) {
            console.error("Error creating department:", error);
        }
    });
}

function updateJobTitle(button){
    var token = button.getAttribute('data-token');;
    const jobTitleName = document.getElementById('updateJobTitleName').value;
    const jobTitleDepartmentName = document.getElementById('updateJobTitleDepartmentName').value;
    const jobTitleDescription = document.getElementById('updateJobTitledescription').value;
    const jobTitleStatus = document.getElementById('updateJobTitleStatus').value;

    console.log(`MD5 ID: ${token}, 
        Job Title Name: ${jobTitleName}, 
        Job Title Department Name: ${jobTitleDepartmentName}, 
        Job Title Description: ${jobTitleDescription}, 
        Job Title Status: ${jobTitleStatus}`);
    
    
    $.ajax({
        url: 'apiTest.php',
        type: 'POST',
        data: {
            action: 'update',
            job_title: {
                md5_id: token,
                title: jobTitleName,
                department_id: jobTitleDepartmentName,
                description: jobTitleDescription,
                status: jobTitleStatus,
            }
        },
        success: function(response) {
            $('#responseTest').html(response);
            showSuccessAlert();
            fetchAllSort();
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
    
}

function deleteJobTitle(button){
    const row = button.closest('tr');  // Get the closest row
    const jobTitleData = {
        token: row.getAttribute('data-id'),
    };
    
    $.ajax({
        url: 'apiTest.php',
        type: 'POST',
        data: {
            action: 'delete',
            md5_id: jobTitleData.token
        },
        success: function(response) {
            $('#responseTest').html(response);
            fetchAllSort();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
    
}

function confirmDeleteJobTitle(button) {
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
        deleteJobTitle(button);
        Swal.fire(
            'Deleted!',
            'The department has been deleted.',
            'success'
        );
        }
    });
}

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


function updateJobTitleClick(button){
    const row = button.closest('tr');  // Get the closest row
    const jobTitleData = {
        token: row.getAttribute('data-id'),
        title: row.getAttribute('data-name'),
        departmentId: row.getAttribute('data-department-id'),
        departmentName: row.getAttribute('data-job-title-name'),
        description: row.getAttribute('data-description'),
        status: row.getAttribute('data-status')
    };
    console.log(jobTitleData);
    const txtJobTitleName = $("#updateJobTitleName");
    const selectDepartmentName = document.getElementById("updateJobTitleDepartmentName");
            
    const txtDescription = $("#updateJobTitledescription");
    const txtStatus = $("#updateJobTitleStatus");
    const btnUpdateJobTitle = document.getElementById('updateJobTitleBtn');

    txtJobTitleName.val(jobTitleData.title);
    departments = getDepartmentValues();
    populateDepartmentSelect(selectDepartmentName);
    selectDepartmentJobTitle(jobTitleData.departmentId, selectDepartmentName);
    txtDescription.val(jobTitleData.description);
    txtStatus.val(jobTitleData.status);
    btnUpdateJobTitle.setAttribute('data-token', jobTitleData.token);

}

function showSuccessAlert() {
    Swal.fire({
        title: 'Success!',
        text: 'Updated successfully.',
        icon: 'success',
        timer: 2000,
        confirmButtonText: 'OK'
    });
}


function hideUpdateOverlay(){
    const updateOverlay = $("#updateOverlay");
    const formContainer = document.getElementById('formContainer');
    const overlay = document.getElementById('overlay');

    formContainer.style.display = 'none';
    overlay.style.display = 'none';
    updateOverlay.innerHTML = '';
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

document.addEventListener('DOMContentLoaded', function () {
    fetchAllSort();
});

