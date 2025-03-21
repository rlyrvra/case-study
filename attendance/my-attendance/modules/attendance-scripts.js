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

function fetchPage(){
    Swal.fire({
        title: 'Enter a Number',
        input: 'number',
        inputAttributes: {
            min: 1,
            max: getMaxPageValue(),
            step: 1
        },
        showCancelButton: true,
        confirmButtonText: 'Submit',
        cancelButtonText: 'Cancel',
        preConfirm: (value) => {
            if (!value || isNaN(value)) {
                Swal.showValidationMessage('Please enter a valid number');
            }
            return value;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            fetchAllMyAttendance(result.value);
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

function getSortByColumn(){
    var sortBy = selectedOptions.sort_by;
    return sortBy;
}

function getOrderBy(){
    var orderBy = selectedOptions.order_by;
    return orderBy;
}

function getByDate(){
    var byDate = selectedOptions.by_date;
    return byDate;
}

function getViewMode() {
    let selected = document.querySelector('input[name="view"]:checked');
    return selected ? selected.value : '';
}

function getByRecordsYear(){
    var byYear;
    if(selectedOptions.by_record === null){
        return byYear;
    }
    byYear = selectedOptions.by_record.split(" ")[1];
    return byYear;
}

function getByRecordsMonth(){
    var byMonth;
    if(selectedOptions.by_record === null){
        return byMonth;
    }
    byMonth = selectedOptions.by_record.split(" ")[0];
    return byMonth;
}

function getPayPeriodById(id) {
    return payPeriodsRecords.find(record => record.id == id);
}