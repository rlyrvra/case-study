function fetchAllDeductions(page = 1) {
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
        url: 'deductions/modules/deductions-api',
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
            $('#deductions-table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}


function createDeductions(){
    const createForm = document.getElementById("add_deductions_form");
    if(!createForm.checkValidity()){
        //showWarningIncompleteForm()
        return;
    }
    const deductionName = document.getElementById('create_name').value;
    const deductionAmount = document.getElementById('create_amount').value;
    const deductionFrequency = document.getElementById('create_frequency').value;
    const deductionDesc = document.getElementById('create_description').value;
    const deductionStatus = document.getElementById('create_status').value;
    

    const deductionData = {
        name: deductionName,
        amount: deductionAmount,
        frequency: deductionFrequency,
        description: deductionDesc,
        status: deductionStatus
    };


    $.ajax({
        url: 'deductions/modules/deductions-api',
        method: 'POST',
        data: {
            action: 'create',
            deduction: deductionData
        },
        success: function(response) {
            $('#deductions-table').html(response);
            fetchAllDeductions();
            document.getElementById('add_deductions_form').reset();
        },
        error(xhr, status, error) {
            console.error("Error creating department:", error);
        }
    });
}

function updateDeductions(button){
    const md5_id = button.getAttribute('data-token');
    const deductionName = document.getElementById('update_name').value;
    const deductionAmount = document.getElementById('update_amount').value;
    const deductionFrequency = document.getElementById('update_frequency').value;
    const deductionDesc = document.getElementById('update_description').value;
    const deductionStatus = document.getElementById('update_status').value;

    $.ajax({
        url: 'deductions/modules/deductions-api',
        type: 'POST',
        data: {
            action: 'update',
            deduction: {
                md5_id: md5_id,
                name: deductionName,
                amount: deductionAmount,
                frequency: deductionFrequency,
                description: deductionDesc,
                status: deductionStatus
            }
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchAllDeductions();
            
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
    
}

function deleteDeduction(button){
    const row = button.closest('tr');  // Get the closest row
    const deductionData = {
        token: row.getAttribute('data-id'),
    };
    
    $.ajax({
        url: 'deductions/modules/deductions-api',
        type: 'POST',
        data: {
            action: 'delete',
            md5_id: deductionData.token
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchAllDeductions();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
    
}

