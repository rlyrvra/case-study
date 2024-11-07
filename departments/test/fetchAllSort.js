function fetchAllSort(page = 1){
    var numberEntries = $("#entries").val();
    var sortByColumn = $("#sortBy").val();
    console.log(getMaxPageValue());
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
    console.log(page);
    if(sortByColumn == null) return;
    var sortOrderBy = $("#orderBy").val();
    if(sortOrderBy == null) return;
    var filterStatus = $("#status").val();
    var dateColumn = $("#dateColumn").val();
    var startDate, endDate;
    if(dateColumn !== "none"){
        startDate = $("#dateStart").val();
        endDate = $("#dateEnd").val();
    }
    var search = $("#searchText").val();
    console.log("Search Text:", search);
    console.log("Start Date:", startDate);
    console.log("End Date:", endDate);
    $.ajax({
        url: 'apiTest.php',
        type: 'POST',
        data: {
            action: 'fetchAllSort',
            page: page,
            numberEntries: numberEntries,
            sort_by: sortByColumn,
            sort_order: sortOrderBy,
            filter_status: filterStatus,
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

function deleteDepartment(token){
    
    $.ajax({
        url: 'apiTest.php',
        type: 'POST',
        data: {
            action: 'delete',
            md5_id: token
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

function updateDepartmentClick(token){
    let updateOverlay = $("#updateOverlay");
    updateOverlay.innerHTML = '';
    console.log(token);
    
    $.ajax({
        url: 'apiTest.php',
        type: 'POST',
        data: {
            action: 'updateClick',
            md5_id: token
        },
        success: function(response) {
            $('#updateOverlay').html(response);
            fetchAllSort();

            const formContainer = document.getElementById('formContainer');
            const overlay = document.getElementById('overlay');
            
            formContainer.style.display = 'block';
            overlay.style.display = 'block';
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
    var departmentDescription = $("#departmentHeadId").val();
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
    const formContainer = document.getElementById('formContainer');
    const overlay = document.getElementById('overlay');

    formContainer.style.display = 'none';
    overlay.style.display = 'none';
}