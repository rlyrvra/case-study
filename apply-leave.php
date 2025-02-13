<?php 
require_once __DIR__ . '/includes/security-headers.php'; 
require_once __DIR__ . '/includes/session.php'; 
require_once __DIR__ . '/includes/file-locations.php';
require_once __DIR__ . '/login-checker.php';

if(isset($_GET['s']) && $_GET['s'] == true){
  include_once __DIR__ . '/sweet-alert-toasts/login/login-success.php';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>



</style>
<head>
<title> Apply Leave </title>
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

<!-- Ajax -->
<script src="leaves/apply-leave/modules/apply-leave-ajax.js?v1.7"></script>
<!-- Scripts -->
<script src="leaves/apply-leave/modules/apply-leave-scripts.js?v1.7"></script>

<!---Skeletons--->
<script src="requests/table-skeleton.js?v1.2"></script>
<!---Skeletons CSS-->
<link rel="stylesheet" href="requests/table-skeleton.css?v1.1" />

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
      document.getElementById("leaves-menu").classList.add("active");
      document.getElementById("leaves-menu").classList.add("open");
      document.getElementById("apply-leave-menu").classList.add("active");
    </script>

    <!-- Layout container -->
    <div class="layout-page">
    <?php require_once __DIR__ . '/user.php' ?>

      <!-- / Navbar -->
      <div class="content-wrapper">
        <div class="container-fluid">
          <div class="container-xxl card p-5 mt-5">
            <div class="container-fluid mb-3 d-flex align-items-center">
                <h1 class="text-center mb-4 mx-auto display-1">Apply Leave</h1>
            </div>
            <hr/>
            <div class="row">
              <!-- Form Section -->
              <div id="response-test"></div>
              <div class="col-md-4">
                  <div class="form-section border card p-4">
                      <h5 id="form_indicator">Apply for Leave Form</h5>
                      <form onsubmit="event.preventDefault()" id="apply_leave_form">
                          <div class="mb-3">
                              <label for="leaveType" class="form-label">Select Leave Type*</label>
                              <select class="form-select" id="leaveType" name="leaveType" required onchange="selectEmployeeLeaves();">
                              </select>
                          </div>
                          <div class="mb-3">
                              <label for="remainingBalance" class="form-label">Remaining Leave Balance:</label>
                              <input type="text" class="form-control" id="remainingBalance" name="remainingBalance" readonly value="0">
                          </div>
                          <div class="mb-3">
                              <label for="startDate" class="form-label">Start Date*</label>
                              <input type="date" class="form-control" id="startDate" name="startDate" required onchange="setEndDateMin(this)">
                          </div>
                          <div class="mb-3">
                              <label for="endDate" class="form-label">End Date*</label>
                              <input type="date" class="form-control" id="endDate" name="endDate" required onchange="calculateTotalNumberOfDays()" disabled>
                          </div>
                          <div class="form-check mb-3">
                              <input class="form-check-input" type="checkbox" id="isHalfday" data-bs-toggle="collapse" data-bs-target="#halfdayOptions">
                              <label class="form-check-label" for="isHalfday">Is Halfday</label>
                          </div>
                          <div class="collapse" id="halfdayOptions">
                            <div class="card card-body">
                              <label for="half_day_options" class="form-label">Work Hours:</label>
                              <select class="form-select" id="half_day_options" name="half_day_options">
                                <option value="" disabled selected>Select a cycle...</option>
                                <option value="First Half">First Half</option>
                                <option value="Second Half">Second Half</option>
                              </select>
                            </div>
                          </div>
                          <div class="mb-3">
                              <label for="totalDays" class="form-label">Total Number of Days:</label>
                              <input type="number" class="form-control" id="totalDays" name="totalDays" readonly>
                          </div>
                          <div class="mb-3">
                              <label for="reason" class="form-label">Reason:</label>
                              <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                          </div>
                          <div class="mb-3">
                              <label for="files" class="form-label">Attachments (jpg, png, pdf):</label>
                              <input type="file" class="form-control" id="files" name="files">
                          </div>
                          <button type="submit" class="btn btn-primary w-100" onclick="createLeaveRequest()">Apply for Leave</button>
                      </form>
                  </div>
              </div>
              <!-- Table Section -->
              <div class="col-md-8 p-4">
                  <div class="table-section">
                      <h5>My Leaves</h5>
                      <div class="container-fluid card pt-3 pb-3 mt-5 mb-5">
                          <?php require_once __DIR__ . '/leaves/apply-leave/modules/apply-leave-sorter.php' ?>
                          <div class="visually-hidden spinner-border spinner-border-lg text-primary text-center w-px-25 h-px-25" role="status" id="loadingSpinner"></div>
                      </div>
                      <div id="skeleton-apply-table" class="visually-hidden table-responsive text-no-wrap">
                      </div>
                      <div class="table-responsive" id="apply_leaves_table">
                      </div>
                  </div>
              </div>
            </div>
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


<?php require_once __DIR__ . '/leaves/apply-leave/modules/apply-leave-fetch-employee-leave-types.php' ?>
<script>
$(document).ready(function() {
  populateEmployeeLeaveTypesSelect(document.getElementById("leaveType"));
  fetchLeaveRequests();
});
</script>


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