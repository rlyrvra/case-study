function updateDateTime() {
    const now = moment();
    
    document.getElementById('time').innerText = now.format('hh:mm:ss A'); 
    document.getElementById('date').innerText = now.format('MMMM DD, YYYY'); 
}

function getFormattedDateTime() {
    return moment().format('YYYY-MM-DD HH:mm:ss'); // 2025-01-01 08:00:00
}

setInterval(updateDateTime, 1000);
updateDateTime();

let rfidOutput = document.getElementById("rfid-label");
let lastKeyPressTime = Date.now();

// Function to capture keypress and display RFID data
document.addEventListener("keydown", function(event) {

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
    if (key === "Enter" && rfidOutput.innerText.length > 5) {
        //console.log("RFID Card Read: " + rfidOutput.innerText + " Date: " + getFormattedDateTime());
        handleRFID(rfidOutput.innerText, getFormattedDateTime());
        
    
    }

});

function showResponse(status, message, record = null){
    if(status === 'success'){
        showRecord(record, status, message);
        return;
    }
    Swal.fire({
        title: status.charAt(0).toUpperCase() + status.slice(1) + "!",
        text: message,
        icon: status,
        confirmButtonText: 'OK'
    });
}


function showRecord(record, status, message) {
    let countdown = 10;
    let img;
    console.log(record);

    // Ensure 'record' is valid
    if (!Array.isArray(record) || record.length === 0 || !record[0]) {
        console.error("Error: Invalid record data", record);
        return;
    }

    // Ensure employee_profile_picture is a valid string before calling trim()
    if (!record[0].employee_profile_picture || typeof record[0].employee_profile_picture !== "string" || record[0].employee_profile_picture.trim() === "") {
        img = "<img src='https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&s=200' class='profile-pic'>";
    } else {
        img = `<img src='data:image/jpg;base64,${record[0].employee_profile_picture}' alt='Profile Picture' class='profile-pic' />`;
    }

    try {
        Swal.fire({
            title: '<h2 style="color: white;">User Information</h2>',
            html: `
            <div class="swal-popup">
                ${img}<br>
                <div class="user-info">
                    <div class="d-flex justify-content-between mb-2">
                        <span><i class='bx bx-id-card'></i> <strong>Code:</strong></span>
                        <span>${record[0].employee_code || 'N/A'}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span><i class='bx bx-time-five'></i> <strong>Check In:</strong></span>
                        <span>${formatTime(record[0].start_time || record[0].check_in_time) || 'N/A'}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span><i class='bx bx-exit'></i> <strong>Check Out:</strong></span>
                        <span>${formatTime(record[0].end_time || record[0].check_out_time) || 'N/A'}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span><i class='bx bx-info-circle'></i> <strong>Status:</strong></span>
                        <span>${status || 'N/A'}</span>
                    </div>

                    <p class="card-text mb-2" style="text-align: justify;">
                        <span><i class='bx bx-message-rounded-dots'></i> <strong>Message:</strong></span>
                        <span>${message || 'No message available'}</span>
                    </p>
                </div>
                
                <div class="countdown-container">
                    <svg width="120" height="120">
                        <circle cx="60" cy="60" r="55" fill="none" stroke="#444" stroke-width="8"></circle>
                        <circle cx="60" cy="60" r="55" fill="none" stroke="#00ffcc" stroke-width="8" class="countdown-circle"></circle>
                    </svg>
                    <div class="countdown-text" id="timer">${countdown}</div>
                </div>
            </div>
            `,
            showCancelButton: true,
            cancelButtonText: 'Close',
            showConfirmButton: false,
            didOpen: () => {
                const timerSpan = document.getElementById('timer');
                const circle = document.querySelector('.countdown-circle');

                // Ensure countdown-circle exists before modifying it
                if (circle) {
                    circle.style.strokeDasharray = "377 377";
                    circle.style.strokeDashoffset = "377"; // Start at full stroke
                }

                const interval = setInterval(() => {
                    countdown--;
                    timerSpan.textContent = countdown;

                    if (circle) {
                        let offset = (377 * countdown) / 10;
                        circle.style.strokeDashoffset = offset;
                    }

                    if (countdown <= 0) {
                        clearInterval(interval);
                        Swal.close();
                    }
                }, 1000);
            }
        });
    } catch (error) {
        console.error("Swal.fire error:", error);
    }
}


function formatTime(timeString) {
    if (!timeString) return 'N/A'; // Handle empty or null values

    let date = new Date(timeString); // Convert to Date object (UTC)
    if (isNaN(date.getTime())) return 'Invalid Time'; // Handle invalid date

    return date.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true });
}
