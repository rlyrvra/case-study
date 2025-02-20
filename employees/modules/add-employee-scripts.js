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


function calculatePayroll(basicSalary) {
    
    // Assumptions
    const hoursPerDay = 8;
    const daysPerWeek = 6;
    const weeksPerYear = 52;
    const daysPerYear = weeksPerYear * daysPerWeek;
    
    // Annually (basic salary for the year)
    const annually = basicSalary * 12;
    
    // Weekly (annual salary divided by 52 weeks)
    const weekly = annually / weeksPerYear;
    
    // Monthly (provided directly as input)
    const monthly = basicSalary;
    
    // Daily (annual salary divided by total days in a year)
    const daily = annually / daysPerYear;
    
    // Semi-Monthly (typically 24 pay periods in a year)
    const semiMonthly = annually / 24;
    
    // Hourly (annual salary divided by total hours worked in a year)
    const hourly = annually / (hoursPerDay * daysPerYear);
    
    // Bi-Weekly (2 weeks of work)
    const biWeekly = weekly * 2;
    
    // Per-Minute (hourly divided by 60 minutes)
    const perMinute = hourly / 60;
    
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

$(document).ready(function() {
    // Maximum file size in bytes (2 MB = 2 * 1024 * 1024 = 2097152 bytes)
    const MAX_FILE_SIZE = 2 * 1024 * 1024;  // 2 MB
    const fileInput = document.getElementById('profilePicture');
    fileInput.addEventListener('change', function(event) {
        

        // Check if a file is selected
        if (fileInput.files.length === 0) {
            return;
        }

        const file = fileInput.files[0];
        const VALID_EXTENSIONS = ['.jpg', '.jpeg'];  // Allowed file extensions

        // Check the file extension
        const fileExtension = file.name.toLowerCase().split('.').pop();
        if (!VALID_EXTENSIONS.includes(`.${fileExtension}`)) {
            showInvalidProfilePicture();
            fileInput.value = '';  // Reset file input field
        }

        // Check the file size
        if (file.size > MAX_FILE_SIZE) {
            showProfilePictureSizeExceed();
            fileInput.value = '';
        }
    });
});
let rfidOutput = document.getElementById("rfid-label");
let rfidText = document.getElementById("rfid");
let rfidShow = document.getElementById("rfid-label-output");
$(document).ready(function () {
    rfidText = document.getElementById("rfid");
    rfidOutput = document.getElementById("rfid-label");
    rfidShow = document.getElementById("rfid-label-output");
});

let lastKeyPressTime = Date.now();
let rfidScanning = false;

// Function to capture keypress and display RFID data
document.addEventListener("keydown", function(event) {

    if(!rfidScanning){
        return;
    }
    if(rfidOutput.innerText === 'XXXXXXXXXXXX'){
        rfidOutput.innerText = ""; // Clear the output
    }

    let key = event.key;

    // Function to reset the output every 5 seconds
    function resetOutput() {
        let currentTime = Date.now();
        // If 5 seconds have passed since the last key press, clear the output
        if (currentTime - lastKeyPressTime >= 50) {
            rfidOutput.innerText = ""; // Clear the output
        }
    }

    // Set a timer to call resetOutput every second (to check inactivity)
    setInterval(resetOutput, 50);

    // Check if the key pressed is part of the RFID card number
    if (key.length === 1) {
    // Display the pressed key (card data)
    rfidOutput.innerText += key;
    lastKeyPressTime = Date.now();
    }

    // Optionally clear output when Enter is pressed (card is fully read)
    if (key === "Enter" && rfidOutput.innerText.length > 0) {
        console.log("RFID Card Read: " + rfidOutput.innerText);
        rfidText.value = rfidOutput.innerText;
        rfidShow.innerText = rfidOutput.innerText;
        
        
    
    }

});

function confirmRFID(){
    $('#rfid_modal').modal('hide');
    Swal.fire({
        title: 'Success!',
        text: 'This RFID has been successfully captured.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
    rfidScanning = false;
    rfidOutput.innerText = "XXXXXXXXXXXX";
    rfidShow.innerText = "XXXXXXXXXXXX";
}

function turnOnScanning(){
    rfidScanning = true;
}

function closeRFIDModal() {
    $('#rfid_modal').modal('hide');
    rfidScanning = false;
    rfidOutput.innerText = "XXXXXXXXXXXX";
}


function showInvalidProfilePicture(){
    Swal.fire({
        title: 'Error!',
        text: 'This is not a supported profile picture.',
        icon: 'error',
        confirmButtonText: 'OK'
    });
}

function showProfilePictureSizeExceed(){
    Swal.fire({
        title: 'Warning!',
        text: 'Profile Picture size exceeds the maximum limit of 2 MB.',
        icon: 'warning',
        confirmButtonText: 'OK'
    });
}


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


