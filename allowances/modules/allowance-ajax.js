function fetchAllAllowances(page = 1) {
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


    if(!skeletonLoaded){
        loadSkeletonView(7, ['Name', 'Amount', 'Frequency', 'Description', 'Status', 'Created At', 'Updated At'] , numberEntries, document.getElementById("skeleton-allowance-table"));
        document.getElementById('skeleton-allowance-table').classList.remove("visually-hidden");
        document.getElementById('allowance-table').classList.add("visually-hidden");
        skeletonLoaded = true;
    }else{
        document.getElementById('skeleton-allowance-table').classList.remove("visually-hidden");
        document.getElementById('allowance-table').classList.add("visually-hidden");
    }


    $.ajax({
        url: 'allowances/modules/allowance-api',
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
            document.getElementById('skeleton-allowance-table').classList.add("visually-hidden");
            document.getElementById('allowance-table').classList.remove("visually-hidden");
            loadingSpinner.classList.add("visually-hidden");
            $('#allowance-table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function createAllowance() {
    const createForm = document.getElementById("add_allowance_form");
    if(!createForm.checkValidity()){
        return;
    }
    const allowanceName = document.getElementById('create_name').value;
    const allowanceAmount = document.getElementById('create_amount').value;
    const allowanceFrequency = document.getElementById('create_frequency').value;
    const allowanceDesc = document.getElementById('create_description').value;
    const allowanceStatus = document.getElementById('create_status').value;
    

    const allowanceData = {
        name: allowanceName,
        amount: allowanceAmount,
        frequency: allowanceFrequency,
        description: allowanceDesc,
        status: allowanceStatus
    };


    $.ajax({
        url: 'allowances/modules/allowance-api',
        method: 'POST',
        data: {
            action: 'create',
            allowance: allowanceData
        },
        success: function(response) {
            $('#response-test').html(response);
            //fetchAllAllowances();
            document.getElementById('add_allowance_form').reset();
            //showSuccessCreate();
        },
        error(xhr, status, error) {
            console.error("Error creating department:", error);
        }
    });
}

function updateAllowance(button){
    var md5_id = button.getAttribute('data-token');
    const allowanceName = document.getElementById('update_name').value;
    const allowanceAmount = document.getElementById('update_amount').value;
    const allowanceFrequency = document.getElementById('update_frequency').value;
    const allowanceDesc = document.getElementById('update_description').value;
    const allowanceStatus = document.getElementById('update_status').value;
    

    $.ajax({
        url: 'allowances/modules/allowance-api',
        type: 'POST',
        data: {
            action: 'update',
            allowance: {
                id: md5_id,
                name: allowanceName,
                amount: allowanceAmount,
                frequency: allowanceFrequency,
                description: allowanceDesc,
                status: allowanceStatus
            }
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchAllAllowances();
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
    
}

function deleteAllowance(button){
    const row = button.closest('tr');  // Get the closest row
    const allowance = {
        token: row.getAttribute('data-id'),
    };
    
    $.ajax({
        url: 'allowances/modules/allowance-api',
        type: 'POST',
        data: {
            action: 'delete',
            id: allowance.token
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchAllAllowances();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
    
}


