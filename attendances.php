<?php require_once __DIR__ . '/includes/header.php'; ?>




<title>RFID Reader Example</title>
<link rel="icon" type="image/x-icon" href="img/logo-files/logo1.ico" />

<style>
@import url('https://fonts.googleapis.com/css2?family=Medula+One&family=Onest:wght@100..900&display=swap');
body{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    background-color: #D6EFD8;
}
/* ----------- NAV BAR ------------ */
.sidebar-nav { min-width: 200px; }
.navbar-toggler { margin-left: auto; }
.full-width-btn-group{
    width: 100%;
    background-color: #FFFFFF;
}
nav .btn{
    font-family: "Medula One";
    font-size: 1.5rem !important;
    transition: border-color 0.3s ease; /* Smooth transition for border color */
    border: 2px solid transparent; /* Black border on hover */
}
@media (max-width: 576px) {
    .navbar .btn {
        font-size: 0.5rem;
    }
}
.navbar{
    margin: 0;
    padding: 0;
}
.navbar .btn:hover {
    border-color: black;
}
#navbarNav .active{
    border-color: black;
}
/* ----------- /NAV BAR ------------ */
#rfid-output {
    font-size: 1.5em;
    margin-top: 20px;
}
</style>




<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <!-- Use d-flex for mobile and d-lg-flex-row for horizontal layout on large screens -->
      <div class="d-flex flex-column flex-lg-row w-100 justify-content-between">
        <button type="button" id="smartWageBtn" class="btn flex-fill mb-2 mb-lg-0" onclick="window.location.href='login.php'">smartWAGE</button>
        <button type="button" id="attendanceBtn" class="active btn flex-fill mb-2 mb-lg-0" onclick="window.location.href='attendance.php'">Attendance</button>
        <button type="button" id="aboutUsBtn" class="btn flex-fill mb-2 mb-lg-0" onclick="window.location.href='index.php#aboutUs'">About Us</button>
        <button type="button" id="principlesBtn" class="btn flex-fill mb-2 mb-lg-0" onclick="window.location.href='index.php#principles'">Principles</button>
        <button type="button" id="complianceBtn" class="btn flex-fill mb-2 mb-lg-0" onclick="window.location.href='index.php#compliance'">Compliance & Policies</button>
        <button type="button" id="contactBtn" class="btn flex-fill" onclick="">Contact</button>
      </div>
    </div>
  </div>
</nav>

<h1>RFID Card Reader</h1>
<p>Tap your RFID card to the reader below:</p>

<div id="rfid-output"></div>





<script>
let rfidOutput = document.getElementById("rfid-output");
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
    if (key === "Enter" && rfidOutput.innerText.length > 0) {
    console.log("RFID Card Read: " + rfidOutput.innerText);
    // Clear the output for next scan
    rfidOutput.innerText = "";
    }
});

</script>