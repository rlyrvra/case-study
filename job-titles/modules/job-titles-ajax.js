function fetchAllJobTitles(page = 1) {
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
        loadSkeletonView(7, ['Job Title', 'Department', 'Description', 'Status', 'Created At', 'Updated At'] , numberEntries, document.getElementById("skeleton-jobs-table"));
        document.getElementById('skeleton-jobs-table').classList.remove("visually-hidden");
        document.getElementById('job-titles-table').classList.add("visually-hidden");
        skeletonLoaded = true;
    }else{
        document.getElementById('skeleton-jobs-table').classList.remove("visually-hidden");
        document.getElementById('job-titles-table').classList.add("visually-hidden");
    }

        
    $.ajax({
        url: 'job-titles/modules/job-titles-api',
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
            document.getElementById('skeleton-jobs-table').classList.add("visually-hidden");
            document.getElementById('job-titles-table').classList.remove("visually-hidden");
            $('#job-titles-table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function createJobTitle() {
    const jobTitleName = document.getElementById('create_jobtitle_title').value;
    const jobTitleDepartmentName = document.getElementById('create_jobtitle_department_name').value;
    const jobTitleDescription = document.getElementById('create_jobtitle_description').value;
    const jobTitleStatus = document.getElementById('create_jobtitle_status').value;

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
        url: 'job-titles/modules/job-titles-api',
        method: 'POST',
        data: {
            action: 'create',
            job_title: jobTitleData
        },
        success: function(response) {
            fetchAllJobTitles();
            showCreatedSuccessAlert();
            document.getElementById('create_job_title_form').reset();
        },
        error(xhr, status, error) {
            console.error("Error creating job titles:", error);
        }
    });
}

function updateJobTitle(button){
    var token = button.getAttribute('data-token');;
    const jobTitleName = document.getElementById('update_jobtitle_title').value;
    const jobTitleDepartmentName = document.getElementById('update_jobtitle_department_name').value;
    const jobTitleDescription = document.getElementById('update_jobtitle_description').value;
    const jobTitleStatus = document.getElementById('update_jobtitle_status').value;

    console.log(`MD5 ID: ${token}, 
        Job Title Name: ${jobTitleName}, 
        Job Title Department Name: ${jobTitleDepartmentName}, 
        Job Title Description: ${jobTitleDescription}, 
        Job Title Status: ${jobTitleStatus}`);

    $.ajax({
        url: 'job-titles/modules/job-titles-api',
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
            //$('#job-titles-table').html(response);
            showSuccessUpdateAlert();
            fetchAllJobTitles();
            
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
        url: 'job-titles/modules/job-titles-api',
        type: 'POST',
        data: {
            action: 'delete',
            md5_id: jobTitleData.token
        },
        success: function(response) {
            //('#job-titles-table').html(response);
            fetchAllSort();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
    
}