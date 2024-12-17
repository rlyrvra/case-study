var buttons;
var forms;
var maxPageForm = 0;
$(document).ready(function (){
    buttons = [
    document.getElementById("personal_information_btn"),
    document.getElementById("login_credential_btn"),
    document.getElementById("contact_information_btn"),
    document.getElementById("employment_information_btn"),
    document.getElementById("pay_information_btn"),
    document.getElementById("government_information_btn")
];
});

$(document).ready(function (){
    forms = [
    document.getElementById("navs-pills-personal-information"),
    document.getElementById("navs-pills-login-credentials"),
    document.getElementById("navs-pills-contact-information"),
    document.getElementById("navs-pills-employment-information"),
    document.getElementById("navs-pills-pay-information"),
    document.getElementById("navs-pills-government-information")
    
];
});


function nextForm(page = 1, button){
    
    const form = document.getElementById(button.getAttribute('data-form'));
    if(!form.checkValidity()){
        showWarningIncompleteForm();
        return;
    }
    page = page - 1;

    if(page > maxPageForm){
        maxPageForm = page;
        for(i = 0; i < maxPageForm + 1; i++){
            buttons[i].classList.remove("disabled");
        }
    }
    


    buttons.forEach(button => {
        button.classList.remove("active");
        button.setAttribute("aria-selected", "false");
    });

    forms.forEach(form => {
        form.classList.remove("show", "active");
    });

    
    
    buttons[page].classList.add("active");
    buttons[page].setAttribute("aria-selected", "true");
    forms[page].classList.add("show", "active");
    
}

function showWarningIncompleteForm() {
    Swal.fire({
        title: 'Warning',
        text: 'Please fill up the details in the form.',
        icon: 'warning',
        timer: 2000,
        confirmButtonText: 'OK'
    });
}


function calculatePayroll(hourlyRate) {
    
    // Assumptions
    const hoursPerDay = 8;
    const daysPerWeek = 6;
    const weeksPerYear = 52;
    const daysPerYear = weeksPerYear * daysPerWeek;
    
    // Annually
    const annually = hourlyRate * hoursPerDay * daysPerYear;
    
    // Weekly
    const weekly = hourlyRate * hoursPerDay * daysPerWeek;
    
    // Monthly (anually / 12)
    const monthly = anually / 12;
    
    // Daily
    const daily = hourlyRate * hoursPerDay;
    
    // Semi-Monthly (typically 24 pay periods in a year)
    const semiMonthly = annually / 24;
    
    // Hourly (provided directly as input)
    const hourly = hourlyRate;
    
    // Bi-Weekly (2 weeks of work)
    const biWeekly = weekly * 2;
    
    // Per-Minute (since 1 hour = 60 minutes)
    const perMinute = hourlyRate / 60;
    
    return {
        annually,
        weekly,
        monthly,
        daily,
        semiMonthly,
        hourly,
        biWeekly,
        perMinute
    };
}

function samplePayroll(){
    hourlyRate = document.getElementById("hourlyRate").value;
    const payrollSample = calculatePayroll(hourlyRate);
    document.getElementById("annual").value = payrollSample.annually;
    document.getElementById("weekly").value = payrollSample.weekly;
    document.getElementById("monthly").value = payrollSample.monthly;
    document.getElementById("daily").value = payrollSample.daily;
    document.getElementById("semiMonthly").value = payrollSample.semiMonthly;
    document.getElementById("hour").value = payrollSample.hourly;
    document.getElementById("biWeekly").value = payrollSample.biWeekly;
    document.getElementById("perMinute").value = payrollSample.perMinute;
}

function previewImage(event) {
    const file = event.target.files[0];
    const reader = new FileReader();
    
    reader.onload = function() {
        const imgElement = document.getElementById('profileImage');
        imgElement.src = reader.result;
    };
    
    if (file) {
        reader.readAsDataURL(file);
    }
}

$(document).ready(function() {
    const dateOfBirth = document.getElementById('dob');
    // Function to disable past dates based on the selected date
    const today = new Date();
    let pastToday = new Date();
    pastToday.setFullYear(pastToday.getFullYear() - 300); // Subtract 300 years
    const formattedDate = today.toISOString().split('T')[0];
    let pastformattedDate = pastToday.toISOString().split('T')[0]; // Format as 'YYYY-MM-DD'
    dateOfBirth.addEventListener('focus', function() {
        dateOfBirth.setAttribute('max', formattedDate);
        dateOfBirth.setAttribute('min', pastformattedDate);
    });

    const dateInput = document.getElementById("dob");

    dateInput.addEventListener("input", function () {
        const minDate = new Date(this.min);
        const maxDate = new Date(this.max);
        const currentDate = new Date(this.value);

        if (currentDate < minDate || currentDate > maxDate) {
            alert(`Please select a date between ${pastformattedDate} and ${formattedDate}.`);
            this.value = ""; // Clear invalid input
        }
    });
});

function failedCreateUpdateTryAgain(){
    Swal.fire({
        title: 'Error!',
        text: 'An error has occured. Please try again.',
        icon: 'error',
        confirmButtonText: 'OK'
    });
}


function failedUpdateTryAgain(token){
    Swal.fire({
        title: 'Error!',
        text: 'An error has occured. Please try again.',
        icon: 'error',
        confirmButtonText: 'OK'
    }).then((result) => {
        if(result.isConfirmed){
            window.location.href = "add-employee?m=v&token=" + token;
        }
    });
}

function missingFieldValues(fieldName){
    Swal.fire({
        title: 'Warning!',
        text: `The ${fieldName} is missing. Please fill it up and try again.`,
        icon: 'warning',
        confirmButtonText: 'OK'
    });
}

function showSuccessUpdate(token) {
    Swal.fire({
        title: 'Success!',
        text: 'This employee has updated successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then((result) => {
        if(result.isConfirmed){
            window.location.href = SMARTWAGE_LOCATION + "/add-employee?m=v&token=" + token;
        }
    });
}

function showSuccessCreate() {
    Swal.fire({
        title: 'Success!',
        text: 'This employee has been created successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then((result) => {
        if(result.isConfirmed){
            window.location.href = SMARTWAGE_LOCATION + "/manage-employee";
        }
    });
}

