<?php 
require_once __DIR__ . '/company-profile/CompanyProfile.php';
require_once __DIR__. '/database/database.php';
require_once __DIR__ . '/includes/header.php'; 

?>
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>smartWage Landing Page</title>
    <link rel="icon" type="image/x-icon" href="img/logo-files/logo1.ico" />

    <script src="https://kit.fontawesome.com/e82c3ed260.js" crossorigin="anonymous"></script>
    <!-- SimpleMDE for text editors -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Medula+One&family=Onest:wght@100..900&display=swap');
        body{
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
        .indexContainer{
            scroll-snap-type: y mandatory;
            overflow-y: scroll;
            height: 100vh;
            scroll-behavior: smooth;
        }
        .indexSections{
            scroll-snap-align: start;
        }
        .one{
            background-color: #CADDCB;
        }
        .two{
            background-color: red;
        }
        .three{
            background-color: blue;
        }
        #top{
            position: relative;
            overflow: hidden; 
        }
        #top img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }
        #top::before{
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4); /* Black overlay with 40% opacity */
            z-index: 1;
        }
        #aboutUs .section h1{
            font-family: "Medula One";
            font-size: 10vh;
        }
        #aboutUs .inside{
            height: 100%;

        }
        .history .col-sm h1{
            font-family: "Medula One" !important;
            border-left: 10px solid black !important;
        }
        .history .col-sm p{
            text-align: justify;
        }
        .inside .row{
            background-color: #CADDCB;
            padding: 3vh;
        }
    </style>
</head>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" 
    data-bs-toggle="collapse" 
    data-bs-target="#navbarNav" 
    aria-controls="navbarNav" 
    aria-expanded="false"
    aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <!-- Use d-flex for mobile and d-lg-flex-row for horizontal layout on large screens -->
      <div class="d-flex flex-column flex-lg-row w-100 justify-content-between">
        <button type="button" id="smartWageBtn" class="btn flex-fill mb-2 mb-lg-0" onclick="window.location.href='login.php'">smartWAGE</button>
        <button type="button" id="attendanceBtn" class="btn flex-fill mb-2 mb-lg-0" onclick="window.location.href='attendances.php'">Attendance</button>
        <button type="button" id="aboutUsBtn" class="btn flex-fill mb-2 mb-lg-0" onclick="scrollToSection('aboutUs')">About Us</button>
        <button type="button" id="principlesBtn" class="btn flex-fill mb-2 mb-lg-0" onclick="scrollToSection('principles')">Principles</button>
        <button type="button" id="complianceBtn" class="btn flex-fill mb-2 mb-lg-0" onclick="scrollToSection('compliance')">Compliance & Policies</button>
        <button type="button" id="contactBtn" class="btn flex-fill" onclick="">Contact</button>
      </div>
    </div>
  </div>
</nav>
<div class="indexContainer">
    <section class="indexSections h-100" id="top">
        <img src="img/wallpaperSample2.jpg" alt="wallpaper">
        
    </section>
    <section class="indexSections d-flex justify-content-center h-100" id="aboutUs">
        <div class="container inside p-5">
            <div class="row mt-2">
                <div class="section container mt-4">
                    <h1> About Us </h1>
                </div>
            </div>
            <div class="row history">
                <div class="col-sm">
                    <h1 class="display-1 ps-2"> History </h1>
                    <?php 
                    $companyProfile = new CompanyProfile($pdo);
                    $results = $companyProfile->fetchCompanyInformation();
                    // Loop through the results and extract the history column
                    foreach ($results as $row) {
                        if (isset($row['history'])) {
                            $companyLocation[] = $row['location'];
                            $companyIndustry[] = $row['industry'];
                            $companyBusinessType[] = $row['business_type'];
                            $companySize[] = $row['size'];
                            $companyInfo[] = $row['history']; // Collect the history column values
                            
                        }
                    }
                    ?>
                    
                    <div id="preview"></div>
                    <textarea id="markdownInput" style="visibility:hidden; height: 0; width: 0; display: none;"><?php echo htmlspecialchars($companyInfo[0]); ?></textarea>
                    <h1 class="display-1 ps-2"> Details </h1>
                    <p><i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($companyLocation[0]); ?></p>
                    <p><i class="fa-solid fa-industry"></i> <?php echo htmlspecialchars($companyIndustry[0]); ?></p>
                    <p><i class="fa-solid fa-building"></i> <?php echo htmlspecialchars($companyBusinessType[0]); ?></p>
                    <p><i class="fa-solid fa-users"></i> Over <?php echo htmlspecialchars($companySize[0]); ?> employees</p>
                </div>
                <div class="col-sm p-2" >
                    <img src="img/wallpaperSample2.jpg" alt="wallpaper" style="max-width: 60vh; max-height: 70vh;">
                </div>
                <script>
                    var simplemde = new SimpleMDE();
                    simplemde.toTextArea();
                    simplemde.value(document.getElementById("markdownInput").value);
                    document.getElementById("preview").innerHTML = simplemde.markdown(simplemde.value());
                </script>
            </div>
        </div>
    </section>
    <section class="two indexSections h-100" id="principles">

    </section>
    
    <section class="three indexSections h-100" id="compliance">

    </section>
</div>

<script>
// Select the section to observe
const sections = document.querySelectorAll('.indexSections');
const buttons = ["smartWageBtn", "aboutUsBtn", "principlesBtn", "complianceBtn", "contactBtn"];
// Create an Intersection Observer
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (!entry.isIntersecting) {
            return;
        }
        buttons.forEach(button => {
            document.getElementById(button).classList.remove("active");
        });
        switch(entry.target.id){
            case 'aboutUs': document.getElementById("aboutUsBtn").classList.add("active"); break;
            case 'principles': document.getElementById("principlesBtn").classList.add("active"); break;
            case 'compliance': document.getElementById("complianceBtn").classList.add("active"); break;
        }
        console.log('User is in section with ID: ' + entry.target.id);
    });
}, {
    root: null, // Use the viewport as the container
    threshold: 0.2 // Trigger when 10% of the section is in view
});

// Observe each section
sections.forEach(section => observer.observe(section));
</script>

<script>
    function scrollToSection(id) {
        document.getElementById(id).scrollIntoView({ behavior: "smooth" });
        // Collapse the navbar after click
        const navbarCollapse = document.getElementById('navbarNav');
        const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
            toggle: false // Ensures collapse does not auto-toggle
        });
        bsCollapse.hide(); // Manually collapse the navbar
    }
</script>


<script>
// // JavaScript to snap fully to each section on scroll
// const container = document.querySelector('.indexContainer');

// container.addEventListener('wheel', (event) => {
//     event.preventDefault();
//     if (event.deltaY > 0) {
//         container.scrollBy({ top: window.innerHeight, behavior: 'smooth' });
//     } else {
//         container.scrollBy({ top: -window.innerHeight, behavior: 'smooth' });
//     }
// });
</script>
</html>