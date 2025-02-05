function fetchAllHolidays(page = 1){
    var numberEntries = $("#entries-per-page").val();
    var sortByColumn = getSortByColumn();
    var pageNumber = getPage(page);
    if(sortByColumn == null){
        sortByColumn = "created_at";
    };
    var sortOrderBy = getOrderBy();
    if(sortOrderBy == null) {
        sortOrderBy = "DESC";
    };
    var filterStatus = $("#status").val();
    var searchColumn = $("#search_at").val();
    if(searchColumn == 'none'){
        searchColumn = "";
    };
    var dateColumn = getByDate();
    var startDate, endDate;
    if(dateColumn){
        startDate = $("#dateStart").val();
        endDate = $("#dateEnd").val();
    }
    var search = $("#searchText").val();

    
    // console.log(`
    //     Number of Entries: ${numberEntries}, 
    //     Sort By Column: ${sortByColumn}, 
    //     Page Number: ${pageNumber}, 
    //     Sort Order By: ${sortOrderBy}, 
    //     Filter Status: ${filterStatus}, 
    //     Search At Column: ${searchColumn}, 
    //     Date Column: ${dateColumn}, 
    //     Start Date: ${startDate}, 
    //     End Date: ${endDate}, 
    //     Search Text: ${search}`);

    var loadingSpinner = document.getElementById("loadingSpinner");
    loadingSpinner.classList.remove("visually-hidden");
    $.ajax({
        url: 'holidays/modules/holidays-api',
        type: 'POST',
        data: {
            action: 'fetchAll',
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
            loadingSpinner.classList.add("visually-hidden");
            $('#holiday-table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function createHolidays(){
    const createForm = document.getElementById("add_holidays_form");
    if(!createForm.checkValidity()){
        //showWarningIncompleteForm()
        return;
    }
    const holidayName = document.getElementById('create_name').value;
    const holidayStart = document.getElementById('create_start_date').value;
    const holidayEnd = document.getElementById('create_end_date').value;
    const holidayIsPaid = document.getElementById('create_isPaid').checked;
    const holidayIsRecurring = document.getElementById('create_isRecurring').checked;
    const holidayDescription = document.getElementById('create_description').value;
    const holidayStatus = document.getElementById("create_status").value;
    

    const holidayData = {
        name: holidayName,
        start_date: holidayStart,
        end_date: holidayEnd,
        isPaid: holidayIsPaid,
        isRecurring: holidayIsRecurring,
        description: holidayDescription,
        status: holidayStatus
    };


    $.ajax({
        url: 'holidays/modules/holidays-api',
        method: 'POST',
        data: {
            action: 'create',
            holidayData: holidayData
        },
        success: function(response) {
            $('#holiday-table').html(response);
            fetchAllAllowances();
            document.getElementById('add_holidays_form').reset();
            //showSuccessCreate();
        },
        error(xhr, status, error) {
            console.error("Error creating department:", error);
        }
    });
}

function updateHolidays(button){
    const md5_id = button.getAttribute('data-token');
    const updateForm = document.getElementById("update_holidays_form");
    if(!updateForm.checkValidity()){
        //showWarningIncompleteForm()
        return;
    }
    const holidayName = document.getElementById('update_name').value;
    const holidayStart = document.getElementById('update_start_date').value;
    const holidayEnd = document.getElementById('update_end_date').value;
    const holidayIsPaid = document.getElementById('update_isPaid').checked;
    const holidayIsRecurring = document.getElementById('update_isRecurring').checked;
    const holidayDescription = document.getElementById('update_description').value;
    const holidayStatus = document.getElementById("update_status").value;
    

    const holidayData = {
        md5_id: md5_id,
        name: holidayName,
        start_date: holidayStart,
        end_date: holidayEnd,
        isPaid: holidayIsPaid,
        isRecurring: holidayIsRecurring,
        description: holidayDescription,
        status: holidayStatus
    };

    //console.log(holidayData);


    $.ajax({
        url: 'holidays/modules/holidays-api',
        method: 'POST',
        data: {
            action: 'update',
            holidayData: holidayData
        },
        success: function(response) {
            $('#holiday-table').html(response);
            //fetchAllHolidays();
        },
        error(xhr, status, error) {
            console.error("Error creating department:", error);
        }
    });
}


function deleteHoliday(button){
    const row = button.closest('tr');  // Get the closest row
    const allowanceData = {
        token: row.getAttribute('data-id'),
    };
    
    $.ajax({
        url: 'holidays/modules/holidays-api',
        type: 'POST',
        data: {
            action: 'delete',
            md5_id: allowanceData.token
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchAllHolidays();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
    
}