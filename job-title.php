<?php 
require_once __DIR__ . '/includes/security-headers.php'; 
require_once __DIR__ . '/includes/session.php'; 
require_once __DIR__ . '/includes/file-locations.php';
require_once __DIR__ . '/login-checker.php';


if($_SESSION['access_role'] !== 'Admin'){
  header("Location: ". $SMARTWAGE_LOCATION ."/smartWage-index.php?aR=true");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>



</style>
<head>
<title> smartWage | Job Titles </title>
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
<script src="job-titles/modules/job-titles-ajax.js?v1.3"></script>
<!-- Scripts -->
<script src="job-titles/modules/job-titles-scripts.js?v1.3"></script>
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
</head>
<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
  <div class="layout-container">
    
    <?php require_once __DIR__ . '/sidebar.php' ?>
    <script>
      document.getElementById("job-titles-menu").classList.add("active");
    </script>
    <?php require_once __DIR__ . '/job-titles/modules/job-title-modals-add-form.php' ?>
    <?php require_once __DIR__ . '/job-titles/modules/job-title-modals-update-form.php' ?>
    <!-- Layout container -->
    <div class="layout-page">
      <?php require_once __DIR__ . '/user.php' ?>

      <!-- / Navbar -->
      <div class="content-wrapper">
        <div class="container-fluid pt-5 pb-5">
          <div class="container-fluid mb-3 d-flex align-items-center">
              <h1 class="display-1">Job Title</h1>
              <button type="button" class="btn btn-success btn-xl ms-auto" data-bs-toggle="modal" data-bs-target="#add_job_titles_modal">
                <i class="bx bx-plus bx-lg"></i>Add Job Titles
              </button>
              
            </div>

            <!-- <div class="divider text-start">
              <div class="divider-text">
                
              </div>
            </div> -->
            

            <div class="container-fluid card pt-3 pb-3 mt-5 mb-5">
              <?php require_once __DIR__ . '/job-titles/modules/job-titles-sorter.php' ?>
              <div class="spinner-border spinner-border-lg text-primary text-center w-px-25 h-px-25" role="status" id="loadingSpinner"></div>
            </div>

            <!-- <div class="divider text-start">
              <div class="divider-text">
                
              </div>
            </div> -->
            

            <div class="container-fluid card pt-5 pb-3 mt-5">
              <div class="card-header">
                <h5>List of Job Titles
              </div>
              <div class="card-body">
                <div id="skeleton-jobs-table" class="visually-hidden table-responsive text-no-wrap"></div>
                <div id="job-titles-table" class="table-responsive text-no-wrap">
                  <div class="visually-hidden container-fluid spinner-border spinner-border-lg d-flex align-items-center justify-content-center w-px-700 h-px-700" role="status"></div>
                </div>
              </div>
            </div>

            

            
            <script>
              $(document).ready(function () {
                fetchAllJobTitles();
              });
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

<?php include_once __DIR__ . '/job-titles/modules/job-titles-fetch-departments.php'; ?>
<script>
$(document).ready(function () {
  populateDepartmentSelect(document.getElementById("create_jobtitle_department_name"));
});

$(document).ready(function () {
  populateDepartmentSelect(document.getElementById("update_jobtitle_department_name"));
});
</script>


<script>
$(document).ready(function () {
  const REGEX_EMAIL = "([a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@" + "(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)";
  $("#create_jobtitle_department_name").selectize({
    persist: false,
    maxItems: 1,
    valueField: "id",
    labelField: "description",
    searchField: ["name", "description"],
    options: departments,
    render: {
      item: function (item, escape) {
          return (
          "<div>" +
          (item.name
              ? '<span class="name">' + escape(item.name) + "</span>"
              : "") +
          (item.description
              ? '<span class="description">' + escape(item.description) + "</span>"
              : "") +
          "</div>"
          );
      },
      option: function (item, escape) {
          var label = item.name || item.description;
          var caption = item.name ? item.description : null;
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
.selectize-control.add_department .selectize-input > div .description {
  opacity: 0.8;
}
.selectize-control.add_department .selectize-input > div .name + .description {
  margin-left: 5px;
}
.selectize-control.add_department .selectize-input > div .description:before {
  content: "<";
}
.selectize-control.add_department .selectize-input > div .description:after {
  content: ">";
}
.selectize-control.add_department .selectize-dropdown .caption {
  font-size: 12px;
  display: block;
  color: #a0a0a0;
}
</style>


<script>
$(document).ready(function () {
  const REGEX_EMAIL = "([a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@" + "(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)";
  $("#update_jobtitle_department_name").selectize({
    persist: false,
    maxItems: 1,
    valueField: "id",
    labelField: "description",
    searchField: ["name", "description"],
    options: departments,
    render: {
      item: function (item, escape) {
          return (
          "<div>" +
          (item.name
              ? '<span class="name">' + escape(item.name) + "</span>"
              : "") +
          (item.description
              ? '<span class="description">' + escape(item.description) + "</span>"
              : "") +
          "</div>"
          );
      },
      option: function (item, escape) {
          var label = item.name || item.description;
          var caption = item.name ? item.description : null;
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
.selectize-control.update_department .selectize-input > div .description {
  opacity: 0.8;
}
.selectize-control.update_department .selectize-input > div .name + .description {
  margin-left: 5px;
}
.selectize-control.update_department .selectize-input > div .description:before {
  content: "<";
}
.selectize-control.update_department .selectize-input > div .description:after {
  content: ">";
}
.selectize-control.update_department .selectize-dropdown .caption {
  font-size: 12px;
  display: block;
  color: #a0a0a0;
}
</style>

</body>
</html>