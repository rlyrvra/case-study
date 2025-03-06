<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Lobster&display=swap" rel="stylesheet">
    
    <title>smartWage - Attendance</title>
    <link rel="icon" type="image/x-icon" href="img/logo-files/logo1.ico" />

    
    <script src="https://kit.fontawesome.com/e82c3ed260.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #ffffff;
        color: #2f4f4f;
    }

    /* Sticky Navigation Bar */
    .navbar {
        position: sticky;
        top: 0;
        z-index: 1000;
        background-color: #052a06;
        padding: 10px 20px;
    }

    .navbar a {
        color: white;
        text-decoration: none;
        margin-right: 100px;
    }

    .nav-link:hover{
        color: rgba(88, 232, 119, 1) !important;
        background: rgba(88, 232, 119, 0.1) !important;
        border-radius: 10px;
    }
    .navbar-nav{
        --bs-nav-link-hover-color:rgba(88, 232, 119, 1) !important;
    }

    

    .hero {
        background: url('img/ezgif.com-animated-gif-maker.gif') no-repeat center center/cover;
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 50px 20px;
        height: 100vh;
        position: relative;
    }

    .hero::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
    }

    .hero-text {
        max-width: 50%;
        z-index: 2;
    }

    .hero h1 {
        font-size: 3rem;
        font-weight: 700;
        line-height: 1.2;
    }

    .hero p {
        font-size: 1.2rem;
        margin-bottom: 20px;
    }

    .hero img {
        max-width: 40%;
        border-radius: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }

    .btn-primary {
        background-color: #052a06;
        border: none;
    }

    .btn-primary:hover {
        background-color: #052a06;
    }

    .about-us, .principles, .compliance {
        padding: 60px 20px;
    }

    .about-us {
        padding: 60px 0;
        background-color: #dbe1dc;
    }

    .about-us h2 {
    font-size: 2.5rem;
    margin-bottom: 20px;
    font-weight: bold;
    }

    .about-us p {
    font-size: 1.2rem;
    color: #666;
    margin-bottom: 40px;
    }

    .about-us .card {
    border: none;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s, box-shadow 0.3s;
    }

    .about-us .card:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
    }

    .about-us .card img {
    border-radius: 10px;
    max-height: 150px;
    object-fit: cover;
    }

    .about-us .card h5 {
    font-size: 1.4rem;
    font-weight: bold;
    margin: 15px 0;
    }

    .about-us .card p {
    font-size: 1rem;
    color: #555;
    }

    @media (max-width: 768px) {
    .about-us .card {
        margin-bottom: 20px;
    }
    }



        

    .slide-in {
        transform: translateX(100%);
        opacity: 0;
        transition: transform 1s ease, opacity 1s ease;
    }




    .principles {
        background-color: #f1f8f5;
    }

    .compliance {
        background-color: #e8f5e9;
    }

    h2, h3, h4 {
        color: #052a06;
    }

    .card {
        border: none;
        transition: transform 0.2s ease, opacity 0.3s ease, background-color 0.3s;
        opacity: 0;
        transform: translateY(50px);
    }

    .btn-light {
        --bs-btn-color: #631212;
        --bs-btn-bg: #052a06;
        --bs-btn-border-color: #f8f9fa;
        --bs-btn-hover-color: #212529;
        --bs-btn-hover-bg: #d3d4d5;
        --bs-btn-hover-border-color: #c6c7c8;
        --bs-btn-focus-shadow-rgb: 211, 212, 213;
        --bs-btn-active-color: #000;
        --bs-btn-active-bg: #c6c7c8;
        --bs-btn-active-border-color: #babbbc;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        --bs-btn-disabled-color: #000;
        --bs-btn-disabled-bg: #f8f9fa;
        --bs-btn-disabled-border-color: #f8f9fa;
    }
    .card.visible {
        opacity: 1;
        transform: translateY(0);
    }

    .card:hover {
        background-color: #d7ffd9;
        transform: scale(1.05);
    }

    footer {
        background-color: #052a06;
        color: white;
        padding: 40px 20px;
        text-align: center;
    }

    footer a {
        color: #a5d6a7;
        text-decoration: none;
    }

    footer a:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .hero {
            flex-direction: column;
            text-align: center;
        }

        .hero-text {
            max-width: 100%;
        }

        .hero img {
            max-width: 100%;
            margin-top: 20px;
        }

        .hero h1 {
            font-size: 2.5rem;
        }

        .hero p {
            font-size: 1rem;
        }
    }

    #contact-links {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 20px;
    }

    #contact-links a {
        color: #052a06;
        font-size: 1.5rem;
    }

    #contact-links a:hover {
        color: #2d6a4f;
    }

    .header {
        display: flex;
        justify-content: flex-end;
        padding: 10px;
        background-color: #f3f3f3; /* Example background */
    }

    .login-button {
        padding: 10px 20px;
        background-color: #052a06;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .login-button:hover {
    background-color: #052a06;
    }

    .animated-card {
        transform: translateX(-50px);
        opacity: 0;
        transition: all 0.8s ease-in-out;
    }

    .animated-card.visible {
        transform: translateX(0);
        opacity: 1;
    }

    body {
        height: 100vh;
    }

    #time {
        font-size: 64px;
        font-weight: bold;
    }
    .color{
        background-color: grey;
        border-radius: 5px;
    }
    .flex{
        display: flex;
    }


    .swal2-popup {
        border-radius: 20px;
        padding: 30px;
        background: linear-gradient(180deg, #58e877, #052a06);
        color: white;
    }
    .profile-pic {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
        border: 4px solid white;
    }
    .user-info {
        text-align: center;
        font-size: 18px;
        font-weight: bold;
    }
    .countdown-container {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 20px auto;
    }
    .countdown-circle {
        stroke-dasharray: 377 377;
        stroke-dashoffset: 377;
        transition: stroke-dashoffset 1s linear;
    }
    .countdown-text {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 22px;
        font-weight: bold;
    }

    </style>
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Sticky Navigation Bar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index#smart">Smart Wage</a></li>
                    <li class="nav-item"><a class="nav-link" href="index#about">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="index#principles">Principles</a></li>
                    <li class="nav-item"><a class="nav-link" href="index#compliance">Compliance</a></li>
                    <li class="nav-item"><a class="nav-link" href="index#contact-us">Contact</a></li>
                </ul>
            </div>
        </div>
        <button class="login-button" onclick="window.location.href='login.php'">Log In</button>
    </nav>

    <!-- Main Content -->
    <div class="container color p-3 text-white text-center">
        <p id="time"></p>
        <h5 id="date"></h5>
    </div>
    <br>
    
    <div id="response-test"></div>
    <div class="container pt-3 flex-grow-1">
        <div class="row d-flex">
            <!-- Left Side: Image and Buttons -->
            <div class="col-3 d-flex flex-column h-100">
                <span class="display-1 text-center visually-hidden" id="rfid-label"></span>
                
                <div class="mb-2 d-flex justify-content-center">
                    <div class="btn-group">
                        <input class="btn-check" type="radio" name="type" id="type-attendance" value="Attendance" checked>
                        <label class="btn btn-outline-primary" for="type-attendance">Attendance</label>
                        <input class="btn-check" type="radio" name="type" id="type-break" value="Break">
                        <label class="btn btn-outline-primary" for="type-break">Break</label>
                    </div>
                </div>

                <!-- Image section -->
                <img src="img/tap.webp" alt="tap-your-rfid" class="w-100 object-fit-cover mb-2">
            </div>

            <!-- Right Side: Tables -->
            <div class="col-9">
                <!-- Attendance Table -->
                <div id="attendance-table"></div>

                <!-- Break Table -->
                <div id="break-table"></div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center mt-auto py-3">
        <p>&copy; 2025 Smart Wage | Designed with Sneats Bootstrap Template</p>
        <div>
            <a href="#">Privacy Policy</a> | <a href="#">Terms of Use</a>
        </div>
    </footer>


<script src="assets/vendor/libs/jquery/jquery.js"></script>
<script src="requests/attendance/attendance-rfid-scripts.js?v1.2.1"></script>
<script src="requests/attendance/attendance-rfid-ajax.js?v1.2.1"></script>

</body>
</html>
