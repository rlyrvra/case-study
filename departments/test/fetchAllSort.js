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
            'The leave type has been deleted.',
            'success'
        );
        }
    });
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


function updateDepartmentClick(button){

    const row = button.closest('tr');  // Get the closest row
    const departmentData = {
        token: row.getAttribute('data-id'),
        name: row.getAttribute('data-name'),
        departmentHeadId: row.getAttribute('data-department-head-id'),
        description: row.getAttribute('data-description'),
        status: row.getAttribute('data-status')
    };

    console.log(departmentData);

    const txtDepartmentName = $("#updateDepartmentName");
    const txtDepartmentHeadId = $("#updateDepartmentHeadId");
    const txtDepartmentDescription = $("#updateDepartmentDescription");
    const txtDepartmentStatus = $("#updateDepartmentStatus");
    const btnUpdateDepartment = document.getElementById('updateDepartmentBtn');

    txtDepartmentName.val(departmentData.name);
    txtDepartmentHeadId.val(departmentData.departmentHeadId);
    txtDepartmentDescription.val(departmentData.description);
    txtDepartmentStatus.val(departmentData.status);
    btnUpdateDepartment.setAttribute('data-token', departmentData.token);
    
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