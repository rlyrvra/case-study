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
            fetchAllPayrollGroups(result.value);
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

function showFrequencyOptions(selectElement, form) {
    // Get the selected option
    var selectedOption = selectElement.options[selectElement.selectedIndex];
    
    // Get the data-target attribute value
    var dataTarget = selectedOption.getAttribute('data-target');
    
    // Example: Show the corresponding container
    if (dataTarget) {
        // Hide all containers first (optional)
        form.querySelectorAll('.frequency-container').forEach(function(container) {
            container.classList.add("visually-hidden");
            container.querySelectorAll('.form-select').forEach(childTarget =>{
                childTarget.required = false;
                childTarget.value = '';
            });
        });
        
        // Show the selected container
        var targetContainer = document.getElementById(dataTarget);
        if (targetContainer) {
            targetContainer.classList.remove("visually-hidden");
            targetContainer.querySelectorAll('.form-select').forEach(childTarget =>{
                childTarget.required = true;
            });
        }
    }
}

function calculateSecondPay(form){
    const semiFirst = parseInt(form.querySelector("#semi_monthly_first_cutoff").value, 10);
    const semiSecond = form.querySelector("#semi_monthly_second_cutoff");
    semiSecond.value = semiFirst + 15;
}

function calculateSecondPayUpdate(form){
    const semiFirst = parseInt(form.querySelector("#update_semi_monthly_first_cutoff").value, 10);
    const semiSecond = form.querySelector("#update_semi_monthly_second_cutoff");
    semiSecond.value = semiFirst + 15;
}

function clickCardEvent(card, event){
    // Prevent modal from opening if the clicked element are buttons
    if (event.target.closest('.btn')) {
        return;
    }

    const button = card.querySelector('[onclick="updatePayrollGroupClick(this)"]');
    if(!button){
        return;
    }
    $('#update-payrollGroups-modal').modal('show');
    updatePayrollGroupClick(button);
}


function updatePayrollGroupClick(button){
    const row = button.closest('tr');
    const payrollGroupData = {
        token: row.getAttribute('data-id'),
        name: row.getAttribute('data-name'),
        payroll_frequency: row.getAttribute('data-payfreq'),
        day_of_weekly_cutoff: row.getAttribute('data-weekly-cutoff'),
        day_of_biweekly_cutoff: row.getAttribute('data-biweekly-cutoff'),
        semi_monthly_first_cutoff: row.getAttribute('data-semimonthly-first-cutoff'),
        semi_monthly_second_cutoff: row.getAttribute('data-semimonthly-second-cutoff'),
        payday_offset: row.getAttribute('data-payday-offset'),
        payday_adjustment: row.getAttribute('data-payday-adjustment'),
        status: row.getAttribute('data-status')
    };
    
    const nameInput = $('#update_name');
    
    // Set the value of the input field with ID 'update_name' to the name from payrollGroupData
    nameInput.val(payrollGroupData.name);
    
    // You can continue by setting other fields similarly
    const payrollFrequencyInput = $('#update_pay_frequency');
    payrollFrequencyInput.val(payrollGroupData.payroll_frequency);

    showFrequencyOptions(document.getElementById('update_pay_frequency'), document.getElementById('update_payrollGroups_form'));
    
    const weeklyCutoffInput = $('#update_weekly_payday');
    weeklyCutoffInput.val(payrollGroupData.day_of_weekly_cutoff);
    
    const biweeklyCutoffInput = $('#update_bi_weekly_payday');
    biweeklyCutoffInput.val(payrollGroupData.day_of_biweekly_cutoff);
    
    const semiMonthlyFirstCutoffInput = $('#update_semi_monthly_first_cutoff');
    semiMonthlyFirstCutoffInput.val(payrollGroupData.semi_monthly_first_cutoff);
    
    const semiMonthlySecondCutoffInput = $('#update_semi_monthly_second_cutoff');
    semiMonthlySecondCutoffInput.val(payrollGroupData.semi_monthly_second_cutoff);
    
    const paydayOffsetInput = $('#update_payday_offset');
    paydayOffsetInput.val(payrollGroupData.payday_offset);
    
    const paydayAdjustmentInput = $('#update_payment_adjustment');
    paydayAdjustmentInput.val(payrollGroupData.payday_adjustment);
    
    const statusInput = $('#update_status');
    statusInput.val(payrollGroupData.status);

    const updateButton = document.getElementById('update_payrollGroup_button');
    updateButton.setAttribute('data-token', payrollGroupData.token);


}

function showSuccessCreate() {
    $('#add-payrollGroups-modal').modal('hide');
    Swal.fire({
        title: 'Success!',
        text: 'This payroll group has been created successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
}

function showSuccessDeletion() {
    $('#add-payrollGroups-modal').modal('hide');
    Swal.fire({
        title: 'Success!',
        text: 'This payroll group has been deleted successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
}

function showSuccessUpdate() {
    $('#update-payrollGroups-modal').modal('hide');
    Swal.fire({
        title: 'Success!',
        text: 'This payroll group has been updated successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
}


function confirmDeletePayrollGroup(button) {
    $('#add-payrollGroups-modal').modal('hide');
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to delete this payroll group?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
        deletePayrollGroup(button);
        }
    });
}

function showValidationError(errorMessages) {
    $('#update-payrollGroups-modal').modal('hide');
    $('#add-payrollGroups-modal').modal('hide');

    let formattedMessages = '';

    if (Array.isArray(errorMessages)) {
        formattedMessages = errorMessages.join('<br>'); // Format as a list
    } else if (typeof errorMessages === 'object') {
        formattedMessages = Object.values(errorMessages).flat().join('<br>'); // Flatten object values
    } else {
        formattedMessages = errorMessages; // Assume it's already a string
    }

    Swal.fire({
        title: 'Warning!',
        html:  formattedMessages,
        icon: 'warning',
        confirmButtonText: 'OK'
    });
}


function showError(message) {
    Swal.fire({
        title: 'Error!',
        text: message,
        icon: 'error',
        confirmButtonText: 'OK'
    });
}

function showFatalError(message) {
    Swal.fire({
        title: 'Fatal Error!',
        html: `${message} <br> Please contact the system administrator.`,
        icon: 'error',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            location.reload();
        }
    });
}