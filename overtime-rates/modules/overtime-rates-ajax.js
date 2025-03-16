function fetchAllOvertimeRates() {

    const department = document.getElementById("selectize_department_sorter").value;
    const jobTitle = document.getElementById("selectize_jobTitle_sorter").value;
    const employee = document.getElementById("selectize_employee_sorter").value;
    let overElement = document.getElementById("overtime_rates_table");
    let overId = overElement ? overElement.getAttribute('data-token') : null;
    //console.log(`${overId} ,${department}, ${jobTitle}, ${employee}`);
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


    // var loadingSpinner = document.getElementById("loadingSpinner");
    // loadingSpinner.classList.remove("visually-hidden");


    // if(!skeletonLoaded){
    //     loadSkeletonView(7, ['Name', 'DEPARTMENT HEAD', 'DESCRIPTION', 'STATUS', 'Created At', 'Updated At'] , numberEntries, document.getElementById("skeleton-departments-table"));
    //     document.getElementById('skeleton-departments-table').classList.remove("visually-hidden");
    //     document.getElementById('departments-table').classList.add("visually-hidden");
    //     skeletonLoaded = true;
    // }else{
    //     document.getElementById('skeleton-departments-table').classList.remove("visually-hidden");
    //     document.getElementById('departments-table').classList.add("visually-hidden");
    // }

    
    
    $.ajax({
        url: 'overtime-rates/modules/overtime-rates-api',
        type: 'POST',
        data: {
            action: 'fetchAll',
            overtime_rates_assignment_id: overId,
            department_id: department,
            job_title_id: jobTitle,
            employee_id: employee

        },
        success: function(response) {
            // loadingSpinner.classList.add("visually-hidden");
            // document.getElementById('skeleton-departments-table').classList.add("visually-hidden");
            // document.getElementById('departments-table').classList.remove("visually-hidden");
            $('#overtime-rates-table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}


function assignRates(){
    const department = document.getElementById("selectize_department_sorter").value;
    const jobTitle = document.getElementById("selectize_jobTitle_sorter").value;
    const employee = document.getElementById("selectize_employee_sorter").value;
    let overElement = document.getElementById("overtime_rates_table_body");
    let overId = overElement ? parseInt(overElement.getAttribute('data-token'), 10) : null;
    const rows = document.getElementById('overtime_rates_table_body')?.getElementsByTagName('tr') || [];
    const rates = getRatesValues(rows);
    console.log(`${overId} ,${department}, ${jobTitle}, ${employee}`);
    console.log(rates);
    $.ajax({
        url: 'overtime-rates/modules/overtime-rates-api',
        type: 'POST',
        data: {
            action: 'assign',
            overtime_rates_assignment_id: overId,
            department_id: department,
            job_title_id: jobTitle,
            employee_id: employee,
            rates: rates
        },
        success: function(response) {
            // loadingSpinner.classList.add("visually-hidden");
            // document.getElementById('skeleton-departments-table').classList.add("visually-hidden");
            // document.getElementById('departments-table').classList.remove("visually-hidden");
            $('#response-test').html(response);
            fetchAllOvertimeRates();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}