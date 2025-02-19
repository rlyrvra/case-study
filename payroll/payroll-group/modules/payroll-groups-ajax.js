function fetchAllPayrollGroups(page = 1){
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
        url: 'payroll/payroll-group/modules/payroll-groups-api',
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
            $('#payroll-group-table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function createPayrollGroup(){
    const name = document.getElementById("create_name").value;
    const freq = document.getElementById("add_pay_frequency").value;
    const weeklyDay = document.getElementById("weekly_payday").value;
    const biWeeklyDay = document.getElementById("bi_weekly_payday").value;
    const semiFirst = document.getElementById("semi_monthly_first_cutoff").value;
    const semiSecond = document.getElementById("semi_monthly_second_cutoff").value;
    const payOffset = document.getElementById("payday_offset").value;
    const payAdjustment = document.getElementById("payment_adjustment").value;
    const status = document.getElementById("create_status").value;

    const payrollGroupData = {
        name: name,
        payroll_frequency: freq,
        day_of_weekly_cutoff: weeklyDay,
        day_of_biweekly_cutoff: biWeeklyDay,
        semi_monthly_first_cutoff: semiFirst,
        semi_monthly_second_cutoff: semiSecond,
        payday_offset: payOffset,
        payday_adjustment: payAdjustment,
        status: status
    };


    $.ajax({
        url: 'payroll/payroll-group/modules/payroll-groups-api',
        type: 'POST',
        data: {
            action: 'create',
            payroll_groups_data: payrollGroupData
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchAllPayrollGroups();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function updatePayrollGroup(button){
    const name = document.getElementById("update_name").value;
    const freq = document.getElementById("update_pay_frequency").value;
    const weeklyDay = document.getElementById("update_pay_frequency").value;
    const biWeeklyDay = document.getElementById("update_bi_weekly_payday").value;
    const semiFirst = document.getElementById("update_semi_monthly_first_cutoff").value;
    const semiSecond = document.getElementById("update_semi_monthly_second_cutoff").value;
    const payOffset = document.getElementById("update_payday_offset").value;
    const payAdjustment = document.getElementById("update_payment_adjustment").value;
    const status = document.getElementById("update_status").value;

    const payrollGroupData = {
        token: button.getAttribute('data-token'),
        name: name,
        payroll_frequency: freq,
        day_of_weekly_cutoff: weeklyDay,
        day_of_biweekly_cutoff: biWeeklyDay,
        semi_monthly_first_cutoff: semiFirst,
        semi_monthly_second_cutoff: semiSecond,
        payday_offset: payOffset,
        payday_adjustment: payAdjustment,
        status: status
    };

    // console.log(payrollGroupData);

    $.ajax({
        url: 'payroll/payroll-group/modules/payroll-groups-api',
        type: 'POST',
        data: {
            action: 'update',
            payroll_groups_data: payrollGroupData
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchAllPayrollGroups();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}


function deletePayrollGroup(button){
    const row = button.closest('tr');  // Get the closest row
    const token = row.getAttribute('data-id');
    
    $.ajax({
        url: 'payroll/payroll-group/modules/payroll-groups-api',
        type: 'POST',
        data: {
            action: 'delete',
            token: token
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchAllPayrollGroups();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
    
}


