<?php require_once __DIR__ . '/includes/security-headers.php'; ?>
<?php require_once __DIR__ . '/includes/session.php'; ?>
<?php require_once __DIR__ . '/includes/file-locations.php' ?>

<?php
require_once __DIR__ . '/login-checker.php';

if($_SESSION['access_role'] !== 'Admin' && $_SESSION['access_role'] !== 'Manager'){
  header("Location: ". $SMARTWAGE_LOCATION ."/smartWage-index.php?aR=true");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>



</style>
<head>
<title> Dashboard </title>
<!-- font-awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
  href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
  rel="stylesheet"
/>

<!-- Icons. Uncomment required icon fonts -->
<link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />

<!-- Core CSS -->
<link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="assets/css/demo.css" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

<link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />

<!-- Page CSS -->

<!-- Helpers -->
<script src="assets/vendor/js/helpers.js"></script>

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="assets/js/config.js"></script>

<!-- font-awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
  <div class="layout-container">
    
    <?php require_once __DIR__ . '/sidebar.php' ?>
    <script>
      document.getElementById("dashboard-menu").classList.add("active");
    </script>

    <!-- Layout container -->
    <div class="layout-page">
    <?php require_once __DIR__ . '/user.php' ?>

      <!-- / Navbar -->
      <div class="content-wrapper">
        <div class="container-fluid">
        <style>
            .card-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(45%, 1fr));
            gap: 20px;
            }

            .card {
            height: fit-content;
            width: fit-content;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: left;
            }
            .titles{
                display: flex;
            }
            .card-content{
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(45%, 1sfr));
            padding: 10px;
            gap: 5%;
            }
            .card-title {
            position: relative;
            font-size: 13px;
            margin-bottom: 10px;
            margin: 2px;
            }
            .secondary-title{
                display: flex;
            }
            .subcard-title{
            position: relative;
            width: 76px ;
            display: flex;
            font-size: 13px;
            margin-bottom: 10px;
            margin: 2px; 
            }
            .avatar-bg{
                background-color: rgba(0, 0, 0, 0.1);
                border-radius: 50%;
                height: 100px;
                width: 100px;
            }   
            .header-card{
                display: flex;
                justify-content: space-evenly ;
            }
            .card-divider{
                padding-top: 2%;
                border-bottom: 1px solid black;
            }
            .content-card-title{
                width: 150px;
            }
            .card-description {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 20px;
            }

            .card-buttons {
            display: flex;
            float: inline-end;
            gap: 10px;
            justify-content: right;
            }

            .card-buttons button {
            height: fit-content;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            }

            .card-buttons button:hover {
            background-color: #0056b3;
            }

            .pagination {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            }

            button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
            }
           </style>
          <div class="container-xxl">
              <div class="container">
                  <div class="controls d-flex justify-content-between mb-3 mt-3"> <!--Entries Per Page Text-->
                    <label for="entries-per-page">Show:</label>
                    <select id="entries-per-page">
                      <option value="4">4</option>
                      <option value="8">8</option>
                      <option value="12">12</option>
                    </select>
                    <label for="entries-per-page">Entries</label>  
                    <div class="dropdown sort">
                      <button
                        class="btn btn-default dropdown-toggle"
                        type="button"
                        data-toggle="dropdown"
                      >
                        Sort By <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu">
                        <li><a tabindex="-1" href="#">Name</a></li>
                        <li><a tabindex="-1" href="#">Date Created</a></li>
                        <li><a tabindex="-1" href="#">Date Modified</a></li>
                        <li><h5 class="dropdown-header line"></h5></li>
                        <li><a tabindex="-1" href="#">Ascending</a></li>
                        <li><a tabindex="-1" href="#">Descending</a></li>
                      </ul>
                    </div>  
                    <div class="dropdown filter">
                      <button
                        class="btn btn-default dropdown-toggle"
                        type="button"
                        data-toggle="dropdown"
                      >
                        Filter Department <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu">
                        <li><a tabindex="-1" href="#">Name</a></li>
                        <li><a tabindex="-1" href="#">Date Created</a></li>
                        <li><a tabindex="-1" href="#">Date Modified</a></li>
                        <li><h5 class="dropdown-header line"></h5></li>
                        <li><a tabindex="-1" href="#">Ascending</a></li>
                        <li><a tabindex="-1" href="#">Descending</a></li>
                      </ul>
                    </div>  
                    <div class="search ">
                      <label for="search">Search</label>
                      <input type="text" id="Search" />
                    </div>
                  
                  </div>
              
                  <div id="card-container" class="card-list">
                    <!-- Cards will be dynamically loaded here -->
                  </div>
              
                  <div class="pagination">
                    <button id="prev-page" disabled>&lt; Previous</button>
                    <span id="current-page">Page 1</span>
                    <button id="next-page">Next &gt;</button>
                  </div>
                </div>

                <script>
                  const cardContainer = document.getElementById('card-container');
                  const itemsPerPageSelect = document.getElementById('entries-per-page');
                  const prevPageButton = document.getElementById('prev-page');
                  const nextPageButton = document.getElementById('next-page');
                  const currentPageSpan = document.getElementById('current-page');

                  let cards = [];
                  for (let i = 1; i <= 50; i++) {
                    cards.push({ title: `Card ${i}`, description: `This is the description for card ${i}.` });
                  }

                  let currentPage = 1;
                  let itemsPerPage = parseInt(itemsPerPageSelect.value);

                  function renderCards() {
                    cardContainer.innerHTML = '';
                    const start = (currentPage - 1) * itemsPerPage;
                    const end = start + itemsPerPage;
                    const visibleCards = cards.slice(start, end);

                    visibleCards.forEach(card => {
                      const cardElement = document.createElement('div');
                      cardElement.className = 'card';
                      cardElement.innerHTML = `
                      <div class="header-card">
                        <div class="avatar avatar-online avatar-bg">
                              <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                          </div>
                          <div >
                              <input type="text" id="fname" placeholder="Name" class="card-title" disabled>
                              <div class="secondary-title">
                              <input type="text" id="fname" placeholder="Job Title:" class="subcard-title" disabled>
                              <input type="text" id="fname" placeholder="Role:" class="subcard-title" disabled>
                              </div>
                              <input type="text" id="fname" placeholder="Department" class="card-title" disabled>
                          </div>
                        <div class="card-buttons">
                          <button class="edit-button">Action</button>
                        </div>
                      </div>
                      <p class="card-divider"></p>
                      <div class="titles">
                      <div class="card-content">
                        <input type="text" id="fname" placeholder="Job Title:" class="content-card-title" disabled>
                          <input type="text" id="fname" placeholder="Role:" class="content-card-title" disabled>
                      </div> 
                      <div class="card-content">
                        <input type="text" id="fname" placeholder="Job Title:" class="content-card-title" disabled>
                          <input type="text" id="fname" placeholder="Role:" class="content-card-title" disabled>
                      </div> 
                      </div>
                      
                      `;
                      cardContainer.appendChild(cardElement);
                    });

                    currentPageSpan.textContent = `Page ${currentPage}`;
                    prevPageButton.disabled = currentPage === 1;
                    nextPageButton.disabled = end >= cards.length;
                  }

                  itemsPerPageSelect.addEventListener('change', () => {
                    itemsPerPage = parseInt(itemsPerPageSelect.value);
                    currentPage = 1; // Reset to the first page
                    renderCards();
                  });

                  prevPageButton.addEventListener('click', () => {
                    if (currentPage > 1) {
                      currentPage--;
                      renderCards();
                    }
                  });

                  nextPageButton.addEventListener('click', () => {
                    if (currentPage * itemsPerPage < cards.length) {
                      currentPage++;
                      renderCards();
                    }
                  });

                  // Initial render
                  renderCards();
                </script>
            </div>
        </div>
      </div>
      <?php require_once __DIR__ . '/footer.php' ?>
      <div class="content-backdrop fade"></div>
    </div>
    <!-- / Layout page -->
  </div>
  <!-- Overlay -->
  <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->



<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="assets/vendor/libs/jquery/jquery.js"></script>
<script src="assets/vendor/libs/popper/popper.js"></script>
<script src="assets/vendor/js/bootstrap.js"></script>
<script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

<script src="assets/vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->
<script src="assets/js/main.js"></script>

<!-- Page JS -->
<script src="assets/js/dashboards-analytics.js"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
</body>
</html>