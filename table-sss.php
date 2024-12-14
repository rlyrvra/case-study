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
      document.getElementById("sss-menu").classList.add("active");
    </script>

    <!-- Layout container -->
    <div class="layout-page">
    <?php require_once __DIR__ . '/user.php' ?>

      <!-- / Navbar -->

      <!-- Content -->
      <div class="content-wrapper">
        <div class="container-xxl pt-5 pb-5">
          <div class="container-fluid mb-3 d-flex align-items-center">
            <h1 class="display-1">SSS Table</h1>
          </div>

          <hr/>
          <div class="table-responsive no-wrap">
            <table id="sss-table" class="table table-hover">
            <thead>
                <tr>
                  <th>Compensation Monthly Salary Credit</th>
                  <th>MSC Regular SS</th>
                  <th>MSC WISP</th>
                  <th>MSC Total</th>
                  <th>AC Regular SS HR</th>
                  <th>AC Regular SS HE</th>
                  <th>AC Regular SS Total</th>
                  <th>AC EC HR</th>
                  <th>AC EC HE</th>
                  <th>AC EC Total</th>
                  <th>AC WISP ER</th>
                  <th>AC WISP EE</th>
                  <th>AC WISP Total</th>
                  <th>AC Total HR</th>
                  <th>AC Total HE</th>
                  <th>AC Total Total</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Below ₱1,250</td>
                  <td>₱4,000.00</td>
                  <td>-</td>
                  <td>₱4,000.00</td>
                  <td>₱380.00</td>
                  <td>₱180.00</td>
                  <td>₱560.00</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱390.00</td>
                  <td>₱180.00</td>
                  <td>₱570.00</td>
                </tr>
                <tr>
                  <td>₱4,250 - 4,749.99</td>
                  <td>₱4,500.00</td>
                  <td>-</td>
                  <td>₱4,500.00</td>
                  <td>₱427.50</td>
                  <td>₱202.50</td>
                  <td>₱630.00</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱437.50</td>
                  <td>₱202.50</td>
                  <td>₱640.00</td>
                </tr>
                <tr>
                  <td>₱4,750 - 5,249.99</td>
                  <td>₱5,000.00</td>
                  <td>-</td>
                  <td>₱5,000.00</td>
                  <td>₱475.00</td>
                  <td>₱225.00</td>
                  <td>₱700.00</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱485.00</td>
                  <td>₱225.00</td>
                  <td>₱710.00</td>
                </tr>
                <tr>
                  <td>₱5,250 - 5,749.99</td>
                  <td>₱5,500.00</td>
                  <td>-</td>
                  <td>₱5,500.00</td>
                  <td>₱522.50</td>
                  <td>₱247.50</td>
                  <td>₱770.00</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱532.50</td>
                  <td>₱247.50</td>
                  <td>₱780.00</td>
                </tr>
                <tr>
                  <td>₱5,750 - 6,249.99</td>
                  <td>₱6,000.00</td>
                  <td>-</td>
                  <td>₱6,000.00</td>
                  <td>₱570.00</td>
                  <td>₱270.00</td>
                  <td>₱840.00</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱580.00</td>
                  <td>₱270.00</td>
                  <td>₱850.00</td>
                </tr>
                <tr>
                  <td>₱6,250 - 6,749.99</td>
                  <td>₱6,500.00</td>
                  <td>-</td>
                  <td>₱6,500.00</td>
                  <td>₱617.50</td>
                  <td>₱292.50</td>
                  <td>₱910.00</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱627.50</td>
                  <td>₱292.50</td>
                  <td>₱920.00</td>
                </tr>
                <tr>
                  <td>₱6,750 - 7,249.99</td>
                  <td>₱7,000.00</td>
                  <td>-</td>
                  <td>₱7,000.00</td>
                  <td>₱665.00</td>
                  <td>₱315.00</td>
                  <td>₱980.00</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱675.00</td>
                  <td>₱315.00</td>
                  <td>₱990.00</td>
                </tr>
                <tr>
                  <td>₱7,250 - 7,749.99</td>
                  <td>₱7,500.00</td>
                  <td>-</td>
                  <td>₱7,500.00</td>
                  <td>₱712.50</td>
                  <td>₱337.50</td>
                  <td>₱1,050.00</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱722.50</td>
                  <td>₱337.50</td>
                  <td>₱1,060.00</td>
                </tr>
                <tr>
                  <td>₱7,750 - 8,249.99</td>
                  <td>₱8,000.00</td>
                  <td>-</td>
                  <td>₱8,000.00</td>
                  <td>₱760.00</td>
                  <td>₱360.00</td>
                  <td>₱1,120.00</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱770.00</td>
                  <td>₱360.00</td>
                  <td>₱1,130.00</td>
                </tr>
                <tr>
                  <td>₱8,250 - 8,749.99</td>
                  <td>₱8,500.00</td>
                  <td>-</td>
                  <td>₱8,500.00</td>
                  <td>₱807.50</td>
                  <td>₱382.50</td>
                  <td>₱1,190.00</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱817.50</td>
                  <td>₱382.50</td>
                  <td>₱1,200.00</td>
                </tr>
                <tr>
                  <td>₱8,750 - 9,249.99</td>
                  <td>₱9,000.00</td>
                  <td>-</td>
                  <td>₱9,000.00</td>
                  <td>₱855.00</td>
                  <td>₱405.00</td>
                  <td>₱1,260.00</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱865.00</td>
                  <td>₱405.00</td>
                  <td>₱1,270.00</td>
                </tr>
                <tr>
                  <td>₱9,250 - 9,749.99</td>
                  <td>₱9,500.00</td>
                  <td>-</td>
                  <td>₱9,500.00</td>
                  <td>₱902.50</td>
                  <td>₱427.50</td>
                  <td>₱1,330.00</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱912.50</td>
                  <td>₱427.50</td>
                  <td>₱1,340.00</td>
                </tr>
                <tr>
                  <td>₱9,750 - 10,249.99</td>
                  <td>₱10,000.00</td>
                  <td>-</td>
                  <td>₱10,000.00</td>
                  <td>₱950.00</td>
                  <td>₱450.00</td>
                  <td>₱1,400.00</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱960.00</td>
                  <td>₱450.00</td>
                  <td>₱1,410.00</td>
                </tr>
                <tr>
                  <td>₱10,250 - 10,749.99</td>
                  <td>₱10,500.00</td>
                  <td>-</td>
                  <td>₱10,500.00</td>
                  <td>₱997.50</td>
                  <td>₱472.50</td>
                  <td>₱1,470.00</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱1,007.50</td>
                  <td>₱472.50</td>
                  <td>₱1,480.00</td>
                </tr>
                <tr>
                  <td>₱10,750 - 11,249.99</td>
                  <td>₱11,000.00</td>
                  <td>-</td>
                  <td>₱11,000.00</td>
                  <td>₱1,045.00</td>
                  <td>₱495.00</td>
                  <td>₱1,540.00</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱1,055.00</td>
                  <td>₱495.00</td>
                  <td>₱1,550.00</td>
                </tr>
                <tr>
                  <td>₱11,250 - 11,749.99</td>
                  <td>₱11,500.00</td>
                  <td>-</td>
                  <td>₱11,500.00</td>
                  <td>₱1,092.50</td>
                  <td>₱517.50</td>
                  <td>₱1,610.00</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱1,102.50</td>
                  <td>₱517.50</td>
                  <td>₱1,620.00</td>
                </tr>
                <tr>
                  <td>₱11,750 - 12,249.99</td>
                  <td>₱12,000.00</td>
                  <td>-</td>
                  <td>₱12,000.00</td>
                  <td>₱1,140.00</td>
                  <td>₱540.00</td>
                  <td>₱1,680.00</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱1,150.00</td>
                  <td>₱540.00</td>
                  <td>₱1,690.00</td>
                </tr>
                <tr>
                  <td>₱12,250 - 12,749.99</td>
                  <td>₱12,500.00</td>
                  <td>-</td>
                  <td>₱12,500.00</td>
                  <td>₱1,187.50</td>
                  <td>₱562.50</td>
                  <td>₱1,750.00</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱1,197.50</td>
                  <td>₱562.50</td>
                  <td>₱1,760.00</td>
                </tr>
                <tr>
                  <td>₱12,750 - 13,249.99</td>
                  <td>₱13,000.00</td>
                  <td>-</td>
                  <td>₱13,000.00</td>
                  <td>₱1,235.00</td>
                  <td>₱585.00</td>
                  <td>₱1,820.00</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱1,245.00</td>
                  <td>₱585.00</td>
                  <td>₱1,830.00</td>
                </tr>
                <tr>
                  <td>₱13,250 - 13,749.99</td>
                  <td>₱13,500.00</td>
                  <td>-</td>
                  <td>₱13,500.00</td>
                  <td>₱1,282.50</td>
                  <td>₱607.50</td>
                  <td>₱1,890.00</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱1,292.50</td>
                  <td>₱607.50</td>
                  <td>₱1,900.00</td>
                </tr>
                <tr>
                  <td>₱13,750 - 14,249.99</td>
                  <td>₱14,000.00</td>
                  <td>-</td>
                  <td>₱14,000.00</td>
                  <td>₱1,330.00</td>
                  <td>₱630.00</td>
                  <td>₱1,960.00</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱1,340.00</td>
                  <td>₱630.00</td>
                  <td>₱1,970.00</td>
                </tr>
                <tr>
                  <td>₱14,250 - 14,749.99</td>
                  <td>₱14,500.00</td>
                  <td>-</td>
                  <td>₱14,500.00</td>
                  <td>₱1,377.50</td>
                  <td>₱652.50</td>
                  <td>₱2,030.00</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>₱10.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱1,387.50</td>
                  <td>₱652.50</td>
                  <td>₱2,040.00</td>
                </tr>
                <tr>
                  <td>₱14,750 - 15,249.99</td>
                  <td>₱15,000.00</td>
                  <td>-</td>
                  <td>₱15,000.00</td>
                  <td>₱1,425.00</td>
                  <td>₱675.00</td>
                  <td>₱2,100.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱1,455.00</td>
                  <td>₱675.00</td>
                  <td>₱2,130.00</td>
                </tr>
                <tr>
                  <td>₱15,250 - 15,749.99</td>
                  <td>₱15,500.00</td>
                  <td>-</td>
                  <td>₱15,500.00</td>
                  <td>₱1,472.50</td>
                  <td>₱697.50</td>
                  <td>₱2,170.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱1,502.50</td>
                  <td>₱697.50</td>
                  <td>₱2,200.00</td>
                </tr>
                <tr>
                  <td>₱15,750 - 16,249.99</td>
                  <td>₱16,000.00</td>
                  <td>-</td>
                  <td>₱16,000.00</td>
                  <td>₱1,520.00</td>
                  <td>₱720.00</td>
                  <td>₱2,240.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱1,550.00</td>
                  <td>₱720.00</td>
                  <td>₱2,270.00</td>
                </tr>
                <tr>
                  <td>₱16,250 - 16,749.99</td>
                  <td>₱16,500.00</td>
                  <td>-</td>
                  <td>₱16,500.00</td>
                  <td>₱1,567.50</td>
                  <td>₱742.50</td>
                  <td>₱2,310.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱1,597.50</td>
                  <td>₱742.50</td>
                  <td>₱2,340.00</td>
                </tr>
                <tr>
                  <td>₱16,750 - 17,249.99</td>
                  <td>₱17,000.00</td>
                  <td>-</td>
                  <td>₱17,000.00</td>
                  <td>₱1,615.00</td>
                  <td>₱765.00</td>
                  <td>₱2,380.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱1,645.00</td>
                  <td>₱765.00</td>
                  <td>₱2,410.00</td>
                </tr>
                <tr>
                  <td>₱17,250 - 17,749.99</td>
                  <td>₱17,500.00</td>
                  <td>-</td>
                  <td>₱17,500.00</td>
                  <td>₱1,662.50</td>
                  <td>₱787.50</td>
                  <td>₱2,450.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱1,692.50</td>
                  <td>₱787.50</td>
                  <td>₱2,480.00</td>
                </tr>
                <tr>
                  <td>₱17,750 - 18,249.99</td>
                  <td>₱18,000.00</td>
                  <td>-</td>
                  <td>₱18,000.00</td>
                  <td>₱1,710.00</td>
                  <td>₱810.00</td>
                  <td>₱2,520.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱1,740.00</td>
                  <td>₱810.00</td>
                  <td>₱2,550.00</td>
                </tr>
                <tr>
                  <td>₱18,250 - 18,749.99</td>
                  <td>₱18,500.00</td>
                  <td>-</td>
                  <td>₱18,500.00</td>
                  <td>₱1,757.50</td>
                  <td>₱832.50</td>
                  <td>₱2,590.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱1,787.50</td>
                  <td>₱832.50</td>
                  <td>₱2,620.00</td>
                </tr>
                <tr>
                  <td>₱18,750 - 19,249.99</td>
                  <td>₱19,000.00</td>
                  <td>-</td>
                  <td>₱19,000.00</td>
                  <td>₱1,805.00</td>
                  <td>₱855.00</td>
                  <td>₱2,660.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱1,835.00</td>
                  <td>₱855.00</td>
                  <td>₱2,690.00</td>
                </tr>
                <tr>
                  <td>₱19,250 - 19,749.99</td>
                  <td>₱19,500.00</td>
                  <td>-</td>
                  <td>₱19,500.00</td>
                  <td>₱1,852.50</td>
                  <td>₱877.50</td>
                  <td>₱2,730.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱1,882.50</td>
                  <td>₱877.50</td>
                  <td>₱2,760.00</td>
                </tr>
                <tr>
                  <td>₱19,750 - 20,249.99</td>
                  <td>₱20,000.00</td>
                  <td>-</td>
                  <td>₱20,000.00</td>
                  <td>₱1,900.00</td>
                  <td>₱900.00</td>
                  <td>₱2,800.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>-</td>
                  <td>-</td>
                  <td>₱1,930.00</td>
                  <td>₱900.00</td>
                  <td>₱2,830.00</td>
                </tr>
                <tr>
                  <td>₱20,250 - 20,749.99</td>
                  <td>₱20,000.00</td>
                  <td>₱500.00</td>
                  <td>₱20,500.00</td>
                  <td>₱1,900.00</td>
                  <td>₱900.00</td>
                  <td>₱2,800.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>₱47.50</td>
                  <td>₱22.50</td>
                  <td>₱70.00</td>
                  <td>₱1,977.50</td>
                  <td>₱922.50</td>
                  <td>₱2,900.00</td>
                </tr>
                <tr>
                  <td>₱20,750 - 21,249.99</td>
                  <td>₱20,000.00</td>
                  <td>₱1,000.00</td>
                  <td>₱21,000.00</td>
                  <td>₱1,900.00</td>
                  <td>₱900.00</td>
                  <td>₱2,800.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>₱95.00</td>
                  <td>₱45.00</td>
                  <td>₱140.00</td>
                  <td>₱2,025.00</td>
                  <td>₱945.00</td>
                  <td>₱2,970.00</td>
                </tr>
                <tr>
                  <td>₱21,250 - 21,749.99</td>
                  <td>₱20,000.00</td>
                  <td>₱1,500.00</td>
                  <td>₱21,500.00</td>
                  <td>₱1,900.00</td>
                  <td>₱900.00</td>
                  <td>₱2,800.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>₱142.50</td>
                  <td>₱67.50</td>
                  <td>₱210.00</td>
                  <td>₱2,072.50</td>
                  <td>₱967.50</td>
                  <td>₱3,040.00</td>
                </tr>
                <tr>
                  <td>₱21,750 - 22,249.99</td>
                  <td>₱20,000.00</td>
                  <td>₱2,000.00</td>
                  <td>₱22,000.00</td>
                  <td>₱1,900.00</td>
                  <td>₱900.00</td>
                  <td>₱2,800.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>₱190.00</td>
                  <td>₱90.00</td>
                  <td>₱280.00</td>
                  <td>₱2,120.00</td>
                  <td>₱990.00</td>
                  <td>₱3,110.00</td>
                </tr>
                <tr>
                  <td>₱22,250 - 22,749.99</td>
                  <td>₱20,000.00</td>
                  <td>₱2,500.00</td>
                  <td>₱22,500.00</td>
                  <td>₱1,900.00</td>
                  <td>₱900.00</td>
                  <td>₱2,800.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>₱237.50</td>
                  <td>₱112.50</td>
                  <td>₱350.00</td>
                  <td>₱2,167.50</td>
                  <td>₱1,012.50</td>
                  <td>₱3,180.00</td>
                </tr>
                <tr>
                  <td>₱22,750 - 23,249.99</td>
                  <td>₱20,000.00</td>
                  <td>₱3,000.00</td>
                  <td>₱23,000.00</td>
                  <td>₱1,900.00</td>
                  <td>₱900.00</td>
                  <td>₱2,800.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>₱285.00</td>
                  <td>₱135.00</td>
                  <td>₱420.00</td>
                  <td>₱2,215.00</td>
                  <td>₱1,035.00</td>
                  <td>₱3,250.00</td>
                </tr>
                <tr>
                  <td>₱23,250 - 23,749.99</td>
                  <td>₱20,000.00</td>
                  <td>₱3,500.00</td>
                  <td>₱23,500.00</td>
                  <td>₱1,900.00</td>
                  <td>₱900.00</td>
                  <td>₱2,800.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>₱332.50</td>
                  <td>₱157.50</td>
                  <td>₱490.00</td>
                  <td>₱2,262.50</td>
                  <td>₱1,057.50</td>
                  <td>₱3,320.00</td>
                </tr>
                <tr>
                  <td>₱23,750 - 24,249.99</td>
                  <td>₱20,000.00</td>
                  <td>₱4,000.00</td>
                  <td>₱24,000.00</td>
                  <td>₱1,900.00</td>
                  <td>₱900.00</td>
                  <td>₱2,800.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>₱380.00</td>
                  <td>₱180.00</td>
                  <td>₱560.00</td>
                  <td>₱2,310.00</td>
                  <td>₱1,080.00</td>
                  <td>₱3,390.00</td>
                </tr>
                <tr>
                  <td>₱24,250 - 24,749.99</td>
                  <td>₱20,000.00</td>
                  <td>₱4,500.00</td>
                  <td>₱24,500.00</td>
                  <td>₱1,900.00</td>
                  <td>₱900.00</td>
                  <td>₱2,800.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>₱427.50</td>
                  <td>₱202.50</td>
                  <td>₱630.00</td>
                  <td>₱2,357.50</td>
                  <td>₱1,102.50</td>
                  <td>₱3,460.00</td>
                </tr>
                <tr>
                  <td>₱24,750 - 25,249.99</td>
                  <td>₱20,000.00</td>
                  <td>₱5,000.00</td>
                  <td>₱25,000.00</td>
                  <td>₱1,900.00</td>
                  <td>₱900.00</td>
                  <td>₱2,800.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>₱475.00</td>
                  <td>₱225.00</td>
                  <td>₱700.00</td>
                  <td>₱2,405.00</td>
                  <td>₱1,125.00</td>
                  <td>₱3,530.00</td>
                </tr>
                <tr>
                  <td>₱25,250 - 25,749.99</td>
                  <td>₱20,000.00</td>
                  <td>₱5,500.00</td>
                  <td>₱25,500.00</td>
                  <td>₱1,900.00</td>
                  <td>₱900.00</td>
                  <td>₱2,800.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>₱522.50</td>
                  <td>₱247.50</td>
                  <td>₱770.00</td>
                  <td>₱2,452.50</td>
                  <td>₱1,147.50</td>
                  <td>₱3,600.00</td>
                </tr>
                <tr>
                  <td>₱25,750 - 26,249.99</td>
                  <td>₱20,000.00</td>
                  <td>₱6,000.00</td>
                  <td>₱26,000.00</td>
                  <td>₱1,900.00</td>
                  <td>₱900.00</td>
                  <td>₱2,800.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>₱570.00</td>
                  <td>₱270.00</td>
                  <td>₱840.00</td>
                  <td>₱2,500.00</td>
                  <td>₱1,170.00</td>
                  <td>₱3,670.00</td>
                </tr>
                <tr>
                  <td>₱26,250 - 26,749.99</td>
                  <td>₱20,000.00</td>
                  <td>₱6,500.00</td>
                  <td>₱26,500.00</td>
                  <td>₱1,900.00</td>
                  <td>₱900.00</td>
                  <td>₱2,800.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>₱617.50</td>
                  <td>₱292.50</td>
                  <td>₱910.00</td>
                  <td>₱2,547.50</td>
                  <td>₱1,192.50</td>
                  <td>₱3,740.00</td>
                </tr>
                <tr>
                  <td>₱26,750 - 27,249.99</td>
                  <td>₱20,000.00</td>
                  <td>₱7,000.00</td>
                  <td>₱27,000.00</td>
                  <td>₱1,900.00</td>
                  <td>₱900.00</td>
                  <td>₱2,800.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>₱665.00</td>
                  <td>₱315.00</td>
                  <td>₱980.00</td>
                  <td>₱2,595.00</td>
                  <td>₱1,215.00</td>
                  <td>₱3,810.00</td>
                </tr>
                <tr>
                  <td>₱27,250 - 27,749.99</td>
                  <td>₱20,000.00</td>
                  <td>₱7,500.00</td>
                  <td>₱27,500.00</td>
                  <td>₱1,900.00</td>
                  <td>₱900.00</td>
                  <td>₱2,800.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>₱712.50</td>
                  <td>₱337.50</td>
                  <td>₱1,050.00</td>
                  <td>₱2,642.50</td>
                  <td>₱1,237.50</td>
                  <td>₱3,880.00</td>
                </tr>
                <tr>
                  <td>₱27,750 - 28,249.99</td>
                  <td>₱20,000.00</td>
                  <td>₱8,000.00</td>
                  <td>₱28,000.00</td>
                  <td>₱1,900.00</td>
                  <td>₱900.00</td>
                  <td>₱2,800.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>₱760.00</td>
                  <td>₱360.00</td>
                  <td>₱1,120.00</td>
                  <td>₱2,690.00</td>
                  <td>₱1,260.00</td>
                  <td>₱3,950.00</td>
                </tr>
                <tr>
                  <td>₱28,250 - 28,749.99</td>
                  <td>₱20,000.00</td>
                  <td>₱8,500.00</td>
                  <td>₱28,500.00</td>
                  <td>₱1,900.00</td>
                  <td>₱900.00</td>
                  <td>₱2,800.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>₱807.50</td>
                  <td>₱382.50</td>
                  <td>₱1,190.00</td>
                  <td>₱2,737.50</td>
                  <td>₱1,282.50</td>
                  <td>₱4,020.00</td>
                </tr>
                <tr>
                  <td>₱28,750 - 29,249.99</td>
                  <td>₱20,000.00</td>
                  <td>₱9,000.00</td>
                  <td>₱29,000.00</td>
                  <td>₱1,900.00</td>
                  <td>₱900.00</td>
                  <td>₱2,800.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>₱855.00</td>
                  <td>₱405.00</td>
                  <td>₱1,260.00</td>
                  <td>₱2,785.00</td>
                  <td>₱1,305.00</td>
                  <td>₱4,090.00</td>
                </tr>
                <tr>
                  <td>₱29,250 - 29,749.99</td>
                  <td>₱20,000.00</td>
                  <td>₱9,500.00</td>
                  <td>₱29,500.00</td>
                  <td>₱1,900.00</td>
                  <td>₱900.00</td>
                  <td>₱2,800.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>₱902.50</td>
                  <td>₱427.50</td>
                  <td>₱1,330.00</td>
                  <td>₱2,832.50</td>
                  <td>₱1,327.50</td>
                  <td>₱4,160.00</td>
                </tr>
                <tr>
                  <td>₱29,750 - Over</td>
                  <td>₱20,000.00</td>
                  <td>₱10,000.00</td>
                  <td>₱30,000.00</td>
                  <td>₱1,900.00</td>
                  <td>₱900.00</td>
                  <td>₱2,800.00</td>
                  <td>₱30.00</td>
                  <td>-</td>
                  <td>₱30.00</td>
                  <td>₱950.00</td>
                  <td>₱450.00</td>
                  <td>₱1,400.00</td>
                  <td>₱2,880.00</td>
                  <td>₱1,350.00</td>
                  <td>₱4,230.00</td>
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
      $('#sss-table').DataTable({
          pageLength: 25
      });
  });
  

  
</script>
</body>
</html>