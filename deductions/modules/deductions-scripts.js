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

function missingFieldValues(fieldName){
    $('#add-deductions-modal').modal('hide');
    $('#update-deductions-modal').modal('hide');
    Swal.fire({
        title: 'Warning!',
        text: `The ${fieldName} is missing. Please fill it up and try again.`,
        icon: 'warning',
        confirmButtonText: 'OK'
    });
}

function showSuccessCreate() {
    $('#add-deductions-modal').modal('hide');
    Swal.fire({
        title: 'Success!',
        text: 'This deduction has been created successfully.',
        icon: 'success',
        timer: 2000,
        confirmButtonText: 'OK'
    });
}

function showSuccessUpdate() {
    $('#update-deductions-modal').modal('hide');
    Swal.fire({
        title: 'Success!',
        text: 'This deduction has been updated successfully.',
        icon: 'success',
        timer: 2000,
        confirmButtonText: 'OK'
    });
}

function showSuccessDeletion() {
    Swal.fire({
        title: 'Success!',
        text: 'This deduction has been deleted successfully.',
        icon: 'success',
        timer: 2000,
        confirmButtonText: 'OK'
    });
}


function updateDeductionsClick(button){

    const row = button.closest('tr');  // Get the closest row
    const deductionData = {
        token: row.getAttribute('data-id'),
        name: row.getAttribute('data-name'),
        amount: row.getAttribute('data-amount'),
        frequency: row.getAttribute('data-frequency'),
        description: row.getAttribute('data-description'),
        status: row.getAttribute('data-status')
    };

    const deductionName = $('#update_name');
    const deductionAmount = $('#update_amount');
    const deductionFrequency = $('#update_frequency');
    const deductionDesc = $('#update_description');
    const deductionStatus = $('#update_status');
    const btnUpdateDeduction = document.getElementById('update_deduction_btn');

    deductionName.val(deductionData.name);
    deductionAmount.val(deductionData.amount);
    deductionFrequency.val(deductionData.frequency);
    deductionDesc.val(deductionData.description);
    deductionStatus.val(deductionData.status);
    btnUpdateDeduction.setAttribute('data-token', deductionData.token);
    
}

function confirmDeleteDeductions(button) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to delete this deduction?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
        deleteDeduction(button);
        }
    });
}