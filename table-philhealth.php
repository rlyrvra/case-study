<?php 
require_once __DIR__ . '/includes/security-headers.php'; 
require_once __DIR__ . '/includes/session.php'; 
require_once __DIR__ . '/includes/file-locations.php';
require_once __DIR__ . '/login-checker.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>



</style>
<head>
<title> PhilHealth </title>
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

<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Icons. Uncomment required icon fonts -->
<link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />
<link rel="icon" type="image/x-icon" href="img/logo-files/logo1.ico" />

<!-- Core CSS -->
<link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css" />
<link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
<link rel="stylesheet" href="assets/css/demo.css" />

<!-- Vendors CSS -->
<link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

<link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />

<!--JQuery DataTables CSS-->
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css"/>

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
      document.getElementById("settings-menu").classList.add("active");
      document.getElementById("settings-menu").classList.add("open");
      document.getElementById("government-tables-menu").classList.add("active");
      document.getElementById("government-tables-menu").classList.add("open");
      document.getElementById("philhealth-menu").classList.add("active");
    </script>

    <!-- Layout container -->
    <div class="layout-page">
    <?php require_once __DIR__ . '/user.php' ?>

      <!-- / Navbar -->

      <!-- Content -->
      <div class="content-wrapper">
        <div class="container-fluid pt-5 pb-5">
          <div class="container-fluid mb-3 d-flex align-items-center">
            <h1 class="display-1">PhilHealth Table</h1>
          </div>

          <hr/>
          <div class="table-responsive no-wrap">
            <table id="philhealth-table" class="table table-hover">
              <thead>
                <tr>
                  <th>Year</th>
                  <th>Monthly Basic Salary</th>
                  <th>Premium Rate</th>
                  <th>Monthly Premium Rate</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="disable">2019</td>
                  <td>₱10,000.00</td>
                  <td>2.75%</td>
                  <td>₱275.00</td>
                </tr>
                <tr>
                  <td>2019</td>
                  <td>₱1 0,000.01 to ₱49,999.99</td>
                  <td>2.75%</td>
                  <td>₱275.00 to ₱1 ,375.00</td>
                </tr>
                <tr>
                  <td>2019</td>
                  <td>₱50,000.00</td>
                  <td>2.75%</td>
                  <td>₱1 ,375.00</td>
                </tr>
                <tr>
                  <td>2020</td>
                  <td>₱10,000.00</td>
                  <td>3.00%</td>
                  <td>₱275.00</td>
                </tr>
                <tr>
                  <td>2020</td>
                  <td>₱10,000.01 to ₱59,999.99</td>
                  <td>3.00%</td>
                  <td>₱300.00 to ₱1 ,800.00</td>
                </tr>
                <tr>
                  <td>2020</td>
                  <td>₱60,000.00</td>
                  <td>3.00%</td>
                  <td>₱1 ,375.00</td>
                </tr>
                <tr>
                  <td>2021</td>
                  <td>₱10,000.00</td>
                  <td>3.50%</td>
                  <td>₱350.00</td>
                </tr>
                <tr>
                  <td>2021</td>
                  <td>₱1 0,000.01 to ₱69,999.99</td>
                  <td>3.50%</td>
                  <td>₱350.00 to ₱2,450.00</td>
                </tr>
                <tr>
                  <td>2021</td>
                  <td>₱70,000.00</td>
                  <td>3.50%</td>
                  <td>₱2,450.00</td>
                </tr>
                <tr>
                  <td>2022</td>
                  <td>₱10,000.00</td>
                  <td>4.00%</td>
                  <td>₱400.00</td>
                </tr>
                <tr>
                  <td>2022</td>
                  <td>₱10,000.01 to ₱79,999.99</td>
                  <td>4.00%</td>
                  <td>₱400.00 to ₱3,200.00</td>
                </tr>
                <tr>
                  <td>2022</td>
                  <td>₱80,000.00</td>
                  <td>4.00%</td>
                  <td>₱3,200.00</td>
                </tr>
                <tr>
                  <td>2023</td>
                  <td>₱10,000.00</td>
                  <td>4.50%</td>
                  <td>₱450.00</td>
                </tr>
                <tr>
                  <td>2023</td>
                  <td>₱10,000.01 to ₱89,999.99</td>
                  <td>4.50%</td>
                  <td>₱450.00 to ₱4,050.00</td>
                </tr>
                <tr>
                  <td>2023</td>
                  <td>₱90,000.00</td>
                  <td>4.50%</td>
                  <td>₱4,050.00</td>
                </tr>
                <tr>
                  <td>2024 to 2025</td>
                  <td>₱10,000.00</td>
                  <td>5.00%</td>
                  <td>₱500.00</td>
                </tr>
                <tr>
                  <td>2024 to 2025</td>
                  <td>₱10,000.01 to ₱99,999.99</td>
                  <td>5.00%</td>
                  <td>₱500.00 to ₱5,000.00</td>
                </tr>
                <tr>
                  <td>2024 to 2025</td>
                  <td>₱100,000.00</td>
                  <td>5.00%</td>
                  <td>₱5,000.00</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- /Content -->
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


<!--DataTables-->
<script src="https://cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>

<script>
  $(document).ready(function() {
      $('#philhealth-table').DataTable({
          pageLength: 25
      });
  });
  

  
</script>
</body>
</html>