function fetchAll(){
    $.ajax({
        url: 'apiTest.php',
        method: 'POST',
        data: {
            action: 'fetchAll'
        },
        dataType: 'html',
        success(response) {
            $('#leave-types-table').html(response);
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
            $('#leave-types-table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function createLeaveType(){
    const leaveTypeName = document.getElementById('name').value;
    const maxNumber = document.getElementById('maximum_number_of_days').value;
    const isPaid = document.getElementById('is_paid').checked;
    const description = document.getElementById('description').value;
    const status = document.getElementById('status').value;

    const leaveTypeData = {
        name: leaveTypeName,
        maximum_number_of_days: maxNumber,
        is_paid: isPaid,
        description: description,
        status: status
    };

    console.log(leaveTypeData);

    $.ajax({
        url: 'apiTest.php',
        method: 'POST',
        data: {
            action: 'create',
            leave_type: leaveTypeData
        },
        success: function(response) {
            fetchAllSort();
            document.getElementById('leave_type_form').reset();
        },
        error(xhr, status, error) {
            console.error("Error creating department:", error);
        }
    });
}

function deleteLeaveType(button) {
    const row = button.closest('tr');  // Get the closest row
    const leaveTypeData = {
        token: row.getAttribute('data-id'),
    };
    $.ajax({
        url: 'apiTest.php',
        method: 'POST',
        data: {
            action: 'delete',
            md5_id: leaveTypeData.token
        },
        success: function(response) {
            
            fetchAllSort();
        },
        error(xhr, status, error) {
            console.error("Error deleting leave type:", error);
        }
    });
}

function updateLeaveType(button){
    const token = button.getAttribute('data-token');

    const leaveTypeName = document.getElementById('updateName').value;
    const maxNumber = document.getElementById('updateMaximum_number_of_days').value;
    const isPaid = document.getElementById('updateIs_paid').checked;
    const description = document.getElementById('updateDescription').value;
    const status = document.getElementById('updateStatus').value;
    
    console.log(`Leave Type Name: ${leaveTypeName}, 
        Max Number of Days: ${maxNumber}, 
        Is Paid: ${isPaid}, 
        Description: ${description}, 
        Status: ${status}`);
    $.ajax({
        url: 'apiTest.php',
        type: 'POST',
        data: {
            action: 'update',
            leave_type: {
                md5_id: token,
                name: leaveTypeName,
                maxNumberOfDays: maxNumber,
                isPaid: isPaid,
                description: description,
                status: status
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

function confirmDeleteLeaveType(button) {
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
        deleteLeaveType(button);
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

    const txtLeaveTypeName = document.getElementById('updateName');
    const txtMaxNumber = document.getElementById('updateMaximum_number_of_days');
    const cbIsPaid = document.getElementById('updateIs_paid');
    const txtDescription = document.getElementById('updateDescription');
    const txtStatus = document.getElementById('updateStatus');
    const btnUpdateLeaveType = document.getElementById('updateLeaveTypeBtn');

    txtLeaveTypeName.value = leaveTypeData.name;
    txtMaxNumber.value = leaveTypeData.maxNumberOfDays;
    cbIsPaid.checked = leaveTypeData.isPaid; 
    txtDescription.value = leaveTypeData.description;
    txtStatus.value = leaveTypeData.status;
    btnUpdateLeaveType.setAttribute('data-token', leaveTypeData.token);

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