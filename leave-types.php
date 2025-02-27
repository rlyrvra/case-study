<?php 
require_once __DIR__ . '/includes/security-headers.php'; 
require_once __DIR__ . '/includes/session.php'; 
require_once __DIR__ . '/includes/file-locations.php';
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
<title> Leave Types | smartWage </title>
<!-- font-awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Selectize CSS -->
<link
  rel="stylesheet"
  href="assets/vendor/css/selectize.bootstrap5.css"
/>

<!-- Ajax -->
<script src="leaves/modules/leave-types-ajax.js?v1.6"></script>
<script src="leaves/modules/assign-leaves-ajax.js?v1.4"></script>
<!-- Scripts -->
<script src="leaves/modules/leave-types-scripts.js?v1.4"></script>
<script src="leaves/modules/assign-leaves-scripts.js?v1.5"></script>
<!---Skeletons--->
<script src="requests/table-skeleton.js?v1.2"></script>
<!---Skeletons CSS-->
<link rel="stylesheet" href="requests/table-skeleton.css?v1.1" />



<meta name="viewport" content="width=device-width, initial-scale=1">

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
      document.getElementById("leaves-menu").classList.add("open");
      document.getElementById("leave-types-menu").classList.add("active");
    </script>
    <?php require_once __DIR__ . '/leaves/modules/leave-types-modals-update-form.php' ?>
    <?php require_once __DIR__ . '/leaves/modules/leave-types-modals-add-form.php' ?>
    <div id="assign-leaves">
      <?php require_once __DIR__ . '/leaves/modules/assign-leaves-modals-assign-form.php' ?>
    </div>
    <!-- Layout container -->
    <div class="layout-page">
    <?php require_once __DIR__ . '/user.php' ?>

      <!-- / Navbar -->
      <div class="content-wrapper">
        <div class="container-fluid pt-5 pb-5">
          <div id="response-test"></div>

          <div class="container-fluid mb-3 d-flex justify-content-between flex-column flex-lg-row">
              <h1 class="display-1">Assign Leaves</h1>
              <button type="button" class="btn btn-success btn-xl" data-bs-toggle="modal" data-bs-target="#assign_leave_types_modal">
                <i class="bx bx-label bx-lg"></i>Assign Leave Types
              </button>

          </div>

          <div class="container-fluid pt-2 mb-3 d-flex justify-content-between flex-column flex-lg-row">
              <h1 class="display-1">Leave Types</h1>
              <button type="button" class="btn btn-success btn-xl" data-bs-toggle="modal" data-bs-target="#add_leave_types_modal">
                <i class="bx bx-plus bx-lg"></i>Add Leave Types
              </button>

          </div>



          <div class="container-fluid card pt-3 pb-3 mt-5 mb-5">
              <?php require_once __DIR__ . '/leaves/modules/leave-types-sorter.php' ?>
              <div class="visually-hidden spinner-border spinner-border-lg text-primary text-center w-px-25 h-px-25" role="status" id="loadingSpinner"></div>
          </div>

   

          <div class="container-fluid card pt-5 pb-3 mt-5">
            <div class="card-header">
              <h5>List of Leave Types</h5>
            </div>
            <div class="card-body">
              <div id="skeleton-leaves-table" class="visually-hidden table-responsive text-no-wrap"></div>
              <div id="leave-types-table" class="table-responsive text-no-wrap">
                <div class="visually-hidden spinner-border spinner-border-lg text-primary text-center w-px-700 h-px-700" role="status"></div>
              </div>
            </div>
          </div>

 

          <script>
              fetchAllLeaveTypes();
          </script>

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

<!-- Selectize -->
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
  integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer"
></script>

</body>
</html>