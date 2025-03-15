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
        return;
    }
    if(button.getAttribute('data-form') === "login_credentials"){
        if(!validatePassword()) return;
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

function getRandomValue(datalistId) {
    let options = document.querySelectorAll(`#${datalistId} option`);
    if (options.length === 0) return "";  // Return empty if no options exist
    let randomIndex = Math.floor(Math.random() * options.length);
    return options[randomIndex].value;
}

function fillContactInfo() {
    document.getElementById("phone").value = getRandomValue("phone-options");
    document.getElementById("email").value = getRandomValue("email-options");
    document.getElementById("address").value = getRandomValue("address-options");

    document.getElementById("emergency-name").value = getRandomValue("emergency-name-options");
    document.getElementById("relationship").value = getRandomValue("relationship-options");
    document.getElementById("emergency-phone").value = getRandomValue("emergency-phone-options");
    document.getElementById("emergency-email").value = getRandomValue("emergency-email-options");
    document.getElementById("emergency-address").value = getRandomValue("emergency-address-options");
}

function validatePassword() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("confirmPassword").value;
    var errorDiv = document.getElementById("confirmPassError");

    if (password !== confirmPassword) {
        errorDiv.style.display = "block";
        return false;
    } else {
        errorDiv.style.display = "none";
        return true;
    }
}

function togglePassword(fieldId) {
    let field = document.getElementById(fieldId);
    let button = field.nextElementSibling.querySelector("i");
    if (field.type === "password") {
        field.type = "text";
        button.classList.remove("bx-show");
        button.classList.add("bx-hide");
    } else {
        field.type = "password";
        button.classList.remove("bx-hide");
        button.classList.add("bx-show");
    }
}

function validateConfirmPassword() {
    let password = document.getElementById("password").value;
    let confirmPassword = document.getElementById("confirmPassword").value;
    let errorDiv = document.getElementById("confirmPassError");

    if (confirmPassword !== password) {
        errorDiv.style.display = "block";
        document.getElementById("confirmPassword").setCustomValidity("Passwords do not match.");
    } else {
        errorDiv.style.display = "none";
        document.getElementById("confirmPassword").setCustomValidity("");
    }
}

function disableSupervisor(){
    let supervisor = $('#supervisor')[0].selectize;
    supervisor.clear(); 
    supervisor.disable(); 
}

function enableSupervisor(){
    let supervisor = $('#supervisor')[0].selectize;
    supervisor.clear(); 
    supervisor.enable(); 
}

function changeSupervisorValue(role){
    console.log(role);
    if(role !== "Staff"){
        console.log("disable");
        disableSupervisor();
    }else{
        console.log("enable");
        enableSupervisor();
    }
}


function calculatePayroll(basicSalary) {
    if (isNaN(basicSalary) || basicSalary <= 0) {
        return { error: "Invalid basic salary input" };
    }

    // Convert to a number in case of string input
    basicSalary = Number(basicSalary);

    // Assumptions
    const hoursPerDay = 8;
    const daysPerWeek = 6;
    const weeksPerYear = 52;
    const daysPerYear = weeksPerYear * daysPerWeek;
    const payPeriodsPerYear = 24; // Semi-Monthly payroll

    // Payroll computations
    const annually = basicSalary * 12;
    const weekly = annually / weeksPerYear;
    const monthly = basicSalary;
    const daily = annually / daysPerYear;
    const semiMonthly = annually / payPeriodsPerYear;
    const hourly = annually / (hoursPerDay * daysPerYear);
    const biWeekly = weekly * 2;
    const perMinute = hourly / 60;

    // Return rounded results
    return {
        annually: annually.toFixed(2),
        weekly: weekly.toFixed(2),
        monthly: monthly.toFixed(2),
        daily: daily.toFixed(2),
        semiMonthly: semiMonthly.toFixed(2),
        hourly: hourly.toFixed(2),
        biWeekly: biWeekly.toFixed(2),
        perMinute: perMinute.toFixed(4) // More precision for per-minute rates
    };
}


function samplePayroll(){
    hourlyRate = document.getElementById("hourlyRate").value;
    const payrollSample = calculatePayroll(hourlyRate);
    document.getElementById("annual").value = payrollSample.annually || '';
    document.getElementById("weekly").value = payrollSample.weekly || '';
    document.getElementById("monthly").value = payrollSample.monthly || '';
    document.getElementById("daily").value = payrollSample.daily || '';
    document.getElementById("semiMonthly").value = payrollSample.semiMonthly || '';
    document.getElementById("hour").value = payrollSample.hourly || '';
    document.getElementById("biWeekly").value = payrollSample.biWeekly || '';
    document.getElementById("perMinute").value = payrollSample.perMinute || '';
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


    document.querySelectorAll('#employment_information input[name="role"]').forEach((radio) => {
        radio.addEventListener("change", function () {
            changeSupervisorValue(this.value);
        });
    });
});

$(document).ready(function() {
    // Maximum file size in bytes (2 MB = 2 * 1024 * 1024 = 2097152 bytes)
    const MAX_FILE_SIZE = 2 * 1024 * 1024;  // 2 MB
    const fileInput = document.getElementById('profilePicture');
    if(!fileInput) return;
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


function showWarningIncompleteForm() {
    Swal.fire({
        title: 'Warning',
        text: 'Please fill up the details in the form.',
        icon: 'warning',
        confirmButtonText: 'OK'
    });
}

