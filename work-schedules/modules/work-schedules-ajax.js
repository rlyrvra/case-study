function fetchAllWorkSchedules(page = 1){
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

    var loadingSpinner = document.getElementById("loadingSpinner");
    loadingSpinner.classList.remove("visually-hidden");
    
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
        loadSkeletonView(7, ['#', 'Employee Name', 'Start Time', 'End Time', 'Work Hours', 'Action'] , numberEntries, document.getElementById("skeleton-workSchedule-table"));
        document.getElementById('skeleton-workSchedule-table').classList.remove("visually-hidden");
        document.getElementById('work-schedules-table').classList.add("visually-hidden");
        skeletonLoaded = true;
    }else{
        document.getElementById('skeleton-workSchedule-table').classList.remove("visually-hidden");
        document.getElementById('work-schedules-table').classList.add("visually-hidden");
    }


    $.ajax({
        url: 'work-schedules/modules/work-schedules-api',
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
            document.getElementById('skeleton-workSchedule-table').classList.add("visually-hidden");
            document.getElementById('work-schedules-table').classList.remove("visually-hidden");
            $('#work-schedules-table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function createWorkSchedule(){
    const form = document.getElementById("work_schedules_add_form");
    if(!form.checkValidity()){
        return;
    }
    const employee = document.getElementById('select_employee').value;
    const start_time = document.getElementById('startTime').value;
    const end_time = document.getElementById('endTime').value;
    const is_flex_time = document.getElementById('isFlextime').checked;
    const total_hrs_per_week = document.getElementById('totalHoursPerWeek').value;
    const total_work_hrs = document.getElementById('totalWorkHours').value;
    const work_schedule = {
        employee: employee,
        start_time: start_time,
        end_time: end_time,
        is_flex_time: is_flex_time,
        total_hrs_per_week: total_hrs_per_week,
        total_work_hrs: total_work_hrs,
    };
    const rows = document.getElementById('create_break_assignment_table_body').getElementsByTagName('tr');
    const breakSchedules = getCreateBreaksValues(rows);

    //console.log(work_schedule);

    $.ajax({
        url: 'work-schedules/modules/work-schedules-api',
        type: 'POST',
        data: {
            action: 'create',
            work_schedule: work_schedule,
            break_schedules: breakSchedules
        },
        success: function(response) {
            loadingSpinner.classList.add("visually-hidden");
            $('#response-test').html(response);
            fetchAllWorkSchedules();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function deleteWorkSchedule(button){
    const row = button.closest('tr');  // Get the closest row
    const token = row.getAttribute('data-id');
    
    $.ajax({
        url: 'work-schedules/modules/work-schedules-api',
        type: 'POST',
        data: {
            action: 'delete',
            token: token
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchAllWorkSchedules();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
    
}

function updateWorkScheduleBreak(button){
    const form = document.getElementById("work_schedules_update_form");
    if(!form.checkValidity()){
        return;
    }
    const token = parseInt(button.getAttribute('data-token'), 10);
    const start_time = document.getElementById('update_startTime').value;
    const end_time = document.getElementById('update_endTime').value;
    const is_flex_time = document.getElementById('update_isFlextime').checked;
    const total_work_hrs = document.getElementById('update_totalWorkHours').value;
    const total_hrs_per_week = document.getElementById('update_totalHoursPerWeek').value;
    const currentBreaks = currentBreakSchedule[1].break_schedules_data; 
    const rows = document.getElementById('update_break_assignment_table_body').getElementsByTagName('tr');
    const selectedBreaks = getCreateBreaksValues(rows);
    const breakDifferences = findDifferences(currentBreaks, selectedBreaks);
    const work_schedule = {
        token: token,
        start_time: start_time,
        end_time: end_time,
        is_flex_time: is_flex_time,
        total_hrs_per_week: total_hrs_per_week,
        total_work_hrs: total_work_hrs,
    };

    // console.log(work_schedule);
    
    // console.log(breakDifferences);

    $.ajax({
        url: 'work-schedules/modules/work-schedules-api',
        type: 'POST',
        data: {
            action: 'update',
            token: token,
            work_schedule: work_schedule,
            break_schedules: breakDifferences
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchAllWorkSchedules();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}


let breakTypes;
function fetchBreakTypes(){
    $.ajax({
        url: 'work-schedules/modules/work-schedules-break-api',
        type: 'POST',
        data: {
            action: 'fetchBreakTypes',
        },
        success: function(response) {
            $('#fetch_break_types').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

let currentBreakSchedule;
function fetchWorkScheduleAndBreak(button){
    const row = button.closest('tr');  // Get the closest row
    const token = row.getAttribute('data-id');
    $.ajax({
        url: 'work-schedules/modules/work-schedules-break-api',
        type: 'POST',
        data: {
            action: 'fetchBreakSchedule',
            token: token
        },
        success: function(response) {
            $('#fetch_break_schedule').html(response);
            updateWorkScheduleData(currentBreakSchedule);
            populateWorkSchedulesBreak(currentBreakSchedule, token);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}


function deleteBreakSchedules(button){
    const row = button.closest('tr');  // Get the closest row
    const token = row.getAttribute('data-token');
    $.ajax({
        url: 'work-schedules/modules/work-schedules-break-api',
        type: 'POST',
        data: {
            action: 'deleteBreakSchedule',
            token: token
        },
        success: function(response) {
            $('#response-test').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}