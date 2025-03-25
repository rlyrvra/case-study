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
<title> Work Schedules | smartWage </title>
<link rel="icon" type="image/x-icon" href="img/logo-files/logo1.ico" />
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
<script src="work-schedules/modules/work-schedules-ajax.js?v1.24"></script>
<!-- Scripts -->
<script src="work-schedules/modules/work-schedules-scripts.js?v1.27"></script>
<!-- Ajax -->
<script src="work-schedules/modules/work-schedules-break-ajax.js?v1.2"></script>
<!-- Scripts -->
<script src="work-schedules/modules/work-schedules-break-scripts.js?v1.3"></script>

<!---Skeletons--->
<script src="requests/table-skeleton.js?v1.2"></script>
<!---Skeletons CSS-->
<link rel="stylesheet" href="requests/table-skeleton.css?v1.1" />




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
<style>
  .swal2-container {
    z-index: 1100 !important; /* Higher than Bootstrap's modal */
}
</style>
</head>
<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
  <div class="layout-container">
    
    <?php require_once __DIR__ . '/sidebar.php' ?>
    <script>
      document.getElementById("attendance-menu").classList.add("open");
      document.getElementById("work-schedules-menu").classList.add("active");
    </script>
    <?php require_once __DIR__ . '/work-schedules/modules/work-schedules-modal-add-form.php' ?>
    <?php require_once __DIR__ . '/work-schedules/modules/work-schedules-modal-update-form.php' ?>
    <?php require_once __DIR__ . '/work-schedules/modules/work-schedules-modal-breaks.php' ?>
    <!-- Layout container -->
    <div class="layout-page">
    <?php require_once __DIR__ . '/user.php' ?>

      <!-- / Navbar -->
      <div class="content-wrapper">
        <div class="container-fluid pt-5 pb-5">
            <div id="response-test"></div>
            <div class="container-fluid mb-3 d-flex justify-content-between flex-column flex-lg-row">
              <h1 class="display-1">Work Schedules</h1>
              <button type="button" class="btn btn-success btn-xl" data-bs-toggle="modal" data-bs-target="#add_work_schedules" onclick="fetchBreakTypes()">
                <i class="bx bx-plus bx-lg"></i>Add Work Schedule
              </button>
            </div>

            <div class="container-fluid pt-2 mb-3 d-flex justify-content-between flex-column flex-lg-row">
              <h1 class="display-2">Breaks</h1>
              <button type="button" class="btn btn-success btn-xl" data-bs-toggle="modal" data-bs-target="#add_breaks">
                <i class="bx bx-plus bx-lg"></i>Add Break Types
              </button>

            </div>

            



            <div class="container-fluid card pt-3 pb-3 mt-5 mb-5">
              <?php require_once __DIR__ . '/work-schedules/modules/work-schedules-sorter.php' ?>
              <div class="visually-hidden spinner-border spinner-border-lg text-primary text-center w-px-25 h-px-25" role="status" id="loadingSpinner"></div>
            </div>

 

            <div class="container-fluid card pt-5 pb-3 mt-5">
              <div class="card-header">
                <h5>List of Work Schedules
              </div>
              <div class="card-body">
              <div id="skeleton-workSchedule-table" class="visually-hidden table-responsive text-no-wrap"></div>
                <div id="work-schedules-table" class="table-responsive text-no-wrap">
                  <div class="container-fluid spinner-border spinner-border-lg d-flex align-items-center justify-content-center w-px-700 h-px-700" role="status"></div>
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

<script>
$(document).ready(function(){
  fetchAllWorkSchedules();
  populateEmployeeSelect(document.getElementById("select_employee"));
  fetchBreakTypes();
});
</script>

<div id="fetch_break_types">

</div>
<div id="fetch_break_schedule">

</div>


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

<?php include_once __DIR__ . '/work-schedules/modules/work-schedules-fetch-employees.php'; ?>

<script>
$(document).ready(function () {
  const REGEX_EMAIL = "([a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@" + "(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)";
  $("#select_employee").selectize({
    persist: false,
    maxItems: 1,
    placeholder: 'Select an employee',
    allowEmptyOption: false,
    valueField: "id",
    labelField: "full_name",
    searchField: ["full_name", "email_address"],
    options: employees,
    render: {
      item: function (item, escape) {
          return (
          "<div>" +
          (item.full_name
              ? '<span class="name">' + escape(item.full_name) + "</span>"
              : "") +
          (item.email_address
              ? '<span class="description">' + escape(item.email_address) + "</span>"
              : "") +
          "</div>"
          );
      },
      option: function (item, escape) {
          var label = item.full_name || item.email_address;
          var caption = item.full_name ? item.email_address : null;
          return (
          "<div>" +
          '<span class="label">' +
          escape(label) +
          "</span>" +
          (caption
              ? '<span class="caption">' + escape(caption) + "</span>"
              : "") +
          "</div>"
          );
      },
    },
    createFilter: function (input) {
      var match, regex;

      // email@address.com
      regex = new RegExp("^" + REGEX_EMAIL + "$", "i");
      match = input.match(regex);
      if (match) return !this.options.hasOwnProperty(match[0]);

      // name <email@address.com>
      regex = new RegExp("^([^<]*)<" + REGEX_EMAIL + ">$", "i");
      match = input.match(regex);
      if (match) return !this.options.hasOwnProperty(match[2]);

      return false;
    },
    create: function (input) {
      if (new RegExp("^" + REGEX_EMAIL + "$", "i").test(input)) {
          return { email: input };
      }
      var match = input.match(
          new RegExp("^([^<]*)<" + REGEX_EMAIL + ">$", "i")
      );
      if (match) {
          return {
          email: match[2],
          name: $.trim(match[1]),
          };
      }
      alert("Invalid email address.");
      return false;
    },
  });
});
</script>

<style>
.selectize-control.selectize_employees .selectize-input > div .description {
  opacity: 0.8;
}
.selectize-control.selectize_employees .selectize-input > div .name + .description {
  margin-left: 5px;
}
.selectize-control.selectize_employees .selectize-input > div .description:before {
  content: "<";
}
.selectize-control.selectize_employees .selectize-input > div .description:after {
  content: ">";
}
.selectize-control.selectize_employees .selectize-dropdown .caption {
  font-size: 12px;
  display: block;
  color: #a0a0a0;
}
</style>
</body>
</html>