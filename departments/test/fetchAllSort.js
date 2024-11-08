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
            $('#departments').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
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

function deleteDepartment(button){

    const row = button.closest('tr');  // Get the closest row
    const departmentData = {
        token: row.getAttribute('data-id'),
    };
    
    $.ajax({
        url: 'apiTest.php',
        type: 'POST',
        data: {
            action: 'delete',
            md5_id: departmentData.token
        },
        success: function(response) {
            $('#departments').html(response);
            fetchAllSort();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
    
}

function updateDepartmentClick(button){
    let updateOverlay = $("#updateOverlay");
    updateOverlay.innerHTML = '';


    const row = button.closest('tr');  // Get the closest row
    const departmentData = {
        token: row.getAttribute('data-id'),
        name: row.getAttribute('data-name'),
        departmentHeadId: row.getAttribute('data-department-head-id'),
        description: row.getAttribute('data-description'),
        status: row.getAttribute('data-status')
    };

    console.log(departmentData);

    $.ajax({
        url: 'apiTest.php',
        type: 'POST',
        data: {
            action: 'updateDepartmentsClick',
            md5_id: departmentData.token
        },
        success: function(response) {
            $('#updateOverlay').html(response);

            const formContainer = document.getElementById('formContainer');
            const overlay = document.getElementById('overlay');
            
            formContainer.style.display = 'block';
            overlay.style.display = 'block';

            const txtDepartmentName = $("#departmentName");
            const txtDepartmentHeadId = $("#departmentHeadId");
            const txtDepartmentDescription = $("#departmentDescription");
            const txtDepartmentStatus = $("#departmentStatus");

            txtDepartmentName.val(departmentData.name);
            txtDepartmentHeadId.val(departmentData.departmentHeadId);
            txtDepartmentDescription.val(departmentData.description);
            txtDepartmentStatus.val(departmentData.status);
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
    
}

function updateDepartment(token){
    var md5_id = token;
    var departmentName = $("#departmentName").val();
    var departmentHeadId = $("#departmentHeadId").val();
    var departmentDescription = $("#departmentDescription").val();
    var departmentStatus = $("#departmentStatus").val();
    $.ajax({
        url: 'apiTest.php',
        type: 'POST',
        data: {
            action: 'update',
            department: {
                md5_id: md5_id,
                name: departmentName,
                departmentHeadId: departmentHeadId,
                departmentDescription: departmentDescription,
                departmentStatus: departmentStatus
            }
        },
        success: function(response) {
            $('#updateOverlay').html(response);
            fetchAllSort();
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
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