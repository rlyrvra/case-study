<?php 
require_once __DIR__ . '/includes/security-headers.php'; 
require_once __DIR__ . '/includes/session.php'; 
require_once __DIR__ . '/includes/file-locations.php';
require_once __DIR__ . '/login-checker.php';


if($_SESSION['access_role'] === 'Staff' || $_SESSION['access_role'] === 'Supervisor'){
  if(
    (isset($_GET['m']) && $_GET['m'] === 'v') && (isset($_GET['token']))
  ){
    $mode = 'view';
    $token = $_GET['token'];
  }else{
    header("Location: ". $SMARTWAGE_LOCATION ."/smartWage-index.php?aR=true");
  }
}

$mode = '';
$token = '';
if(isset($_GET['m']) && $_GET['m'] === 'u'){
    $mode = 'update';
    $token = $_GET['token'];
}else if(isset($_GET['m']) && $_GET['m'] === 'v'){
    $mode = 'view';
    $token = $_GET['token'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>
.profile-header {
  display: flex;
  align-items: center;
  gap: 15px;
  margin-bottom: 20px;
}
.profile-header img {
  width: 50px;
  height: 50px;
  border-radius: 50%;
}
.form-container {
  background-color: #eaf7ea;
  border-radius: 0.4rem;
  border: 2px solid #16423C;
}
.form-container label {
  font-weight: 500;
}
.form-title {
  font-size: 1.5rem;
  font-weight: bold;
  margin-bottom: 20px;
  /* color: #fff; */
}
.form-label {
  font-weight: bold;
  /* color: #fff; */
}
</style>
<head>
<title> smartWage | Add Employee </title>
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
<script src="employees/modules/add-employee-ajax.js?v1.5"></script>
<!-- Scripts -->
<script src="employees/modules/add-employee-scripts.js?v1.10"></script>



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
</head>
<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
  <div class="layout-container">
    
    <?php require_once __DIR__ . '/sidebar.php' ?>
    <script>
      document.getElementById("employees-menu").classList.add("open");
      document.getElementById("add-employees-menu").classList.add("active");
    </script>

    <!-- Layout container -->
    <div class="layout-page">
    <?php require_once __DIR__ . '/user.php' ?>

      <!-- / Navbar -->
      <div class="content-wrapper">
        <div class="container-fluid">
          <div class="container-fluid pt-5 pb-5">
            <div class="container-fluid mb-3 d-flex align-items-center">
              <h1 class="display-1">Add Employee</h1>
            </div>

            <div class="container-fluid card pt-5 pb-5 mt-5 mb-5">
              <div class="row justify-content-center">
                <!-- Header -->
                <?php
                if(empty($mode)){
                  include_once __DIR__ . '/employees/modules/add-employee-header-add.php';
                }else if($mode === 'view'){
                  include_once __DIR__ . '/employees/modules/add-employee-header-view.php';
                }else if($mode === 'update'){
                  include_once __DIR__ . '/employees/modules/add-employee-header-update.php';
                }else{
                  include_once __DIR__ . '/employees/modules/add-employee-header-add.php';
                }
                ?>

              </div>
              <div class="row">
                <div class="col-12 d-flex justify-content-center flex-column flex-lg-row">
                  <ul class="col-12 col-lg-3 flex-column nav nav-pills pt-4 pb-4 flex-grow-1" role="tablist">
                    <li class="nav-item">
                      <button
                        type="button"
                        class="nav-link active"
                        role="tab"
                        id="personal_information_btn"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-pills-personal-information"
                        aria-controls="navs-pills-personal-information"
                        aria-selected="true"
                      >
                        Personal Information
                      </button>
                    </li>
                    <li class="nav-item">
                      <button
                        type="button"
                        class="nav-link <?php if(!isset($_GET['m'])) echo 'disabled'; ?>"
                        role="tab"
                        id="login_credential_btn"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-pills-login-credentials"
                        aria-controls="navs-pills-login-credentials"
                        aria-selected="false"
                      >
                        Login Credential
                      </button>
                    </li>
                    <li class="nav-item">
                      <button
                        type="button"
                        class="nav-link <?php if(!isset($_GET['m'])) echo 'disabled'; ?>"
                        role="tab"
                        id="contact_information_btn"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-pills-contact-information"
                        aria-controls="navs-pills-contact-information"
                        aria-selected="false"
                      >
                        Contact Information
                      </button>
                    </li>
                    <li class="nav-item">
                      <button
                        type="button"
                        class="nav-link <?php if(!isset($_GET['m'])) echo 'disabled'; ?>"
                        role="tab"
                        id="employment_information_btn"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-pills-employment-information"
                        aria-controls="navs-pills-employment-information"
                        aria-selected="false"
                      >
                        Employment Information
                      </button>
                    </li>
                    <li class="nav-item">
                      <button
                        type="button"
                        class="nav-link <?php if(!isset($_GET['m'])) echo 'disabled'; ?>"
                        role="tab"
                        id="pay_information_btn"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-pills-pay-information"
                        aria-controls="navs-pills-pay-information"
                        aria-selected="false"
                      >
                        Pay Information
                      </button>
                    </li>
                    <li class="nav-item">
                      <button
                        type="button"
                        class="nav-link <?php if(!isset($_GET['m'])) echo 'disabled'; ?>"
                        role="tab"
                        id="government_information_btn"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-pills-government-information"
                        aria-controls="navs-pills-government-information"
                        aria-selected="false"
                      >
                        Government Information
                      </button>
                    </li>
                  </ul>
                  <div class="col-12 col-lg-9  tab-content">
                    <?php 
                    if(empty($mode)){
                      include_once __DIR__ . '/employees/modules/add-employee-form-add.php';
                    }else if($mode === 'view'){
                      include_once __DIR__ . '/employees/modules/add-employee-form-view.php';
                    }else if($mode === 'update'){
                      include_once __DIR__ . '/employees/modules/add-employee-form-update.php';
                    }else{
                      include_once __DIR__ . '/employees/modules/add-employee-form-add.php';
                    }
                    ?>

                  </div>
                </div>
              </div>
            </div>
            
            <hr/>
            
            <div id="response-test">
            </div>
            

            
            <script>

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

<!-- Selectize -->
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
  integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer"
></script>


<?php include_once __DIR__ . '/employees/modules/add-employee-fetch-departments.php'; ?>
<?php include_once __DIR__ . '/employees/modules/add-employee-fetch-job-titles.php'; ?>
<?php include_once __DIR__ . '/employees/modules/add-employee-fetch-supervisors.php'; ?>
<?php include_once __DIR__ . '/employees/modules/add-employee-fetch-payroll-groups.php'; ?>
<script>
  $(document).ready(function() {
    populatePayrollGroupsSelect(document.getElementById("payrollGroup"));
  });
</script>
<script>

</script>


<script>
$(document).ready(function () {
  const REGEX_EMAIL = "([a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@" + "(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)";
  $("#department").selectize({
    persist: false,
    maxItems: 1,
    placeholder: 'Select a department',
    allowEmptyOption: true,
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
.selectize-control.selectize_department .selectize-input > div .description {
  opacity: 0.8;
}
.selectize-control.selectize_department .selectize-input > div .name + .description {
  margin-left: 5px;
}
.selectize-control.selectize_department .selectize-input > div .description:before {
  content: "<";
}
.selectize-control.selectize_department .selectize-input > div .description:after {
  content: ">";
}
.selectize-control.selectize_department .selectize-dropdown .caption {
  font-size: 12px;
  display: block;
  color: #a0a0a0;
}
</style>



<script>
$(document).ready(function () {
  const REGEX_EMAIL = "([a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@" + "(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)";
  $("#job-title").selectize({
    persist: false,
    maxItems: 1,
    placeholder: 'Select a job title',
    allowEmptyOption: true,
    valueField: "id",
    labelField: "description",
    searchField: ["title", "description"],
    options: jobTitles,
    render: {
      item: function (item, escape) {
          return (
          "<div>" +
          (item.title
              ? '<span class="name">' + escape(item.title) + "</span>"
              : "") +
          (item.description
              ? '<span class="description">' + escape(item.description) + "</span>"
              : "") +
          "</div>"
          );
      },
      option: function (item, escape) {
          var label = item.title || item.description;
          var caption = item.title ? item.description : null;
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
.selectize-control.selectize_job_title .selectize-input > div .description {
  opacity: 0.8;
}
.selectize-control.selectize_job_title .selectize-input > div .name + .description {
  margin-left: 5px;
}
.selectize-control.selectize_job_title .selectize-input > div .description:before {
  content: "<";
}
.selectize-control.selectize_job_title .selectize-input > div .description:after {
  content: ">";
}
.selectize-control.selectize_job_title .selectize-dropdown .caption {
  font-size: 12px;
  display: block;
  color: #a0a0a0;
}
</style>


<style>
.selectize-control.selectize_department .selectize-input > div .description {
  opacity: 0.8;
}
.selectize-control.selectize_department .selectize-input > div .name + .description {
  margin-left: 5px;
}
.selectize-control.selectize_department .selectize-input > div .description:before {
  content: "<";
}
.selectize-control.selectize_department .selectize-input > div .description:after {
  content: ">";
}
.selectize-control.selectize_department .selectize-dropdown .caption {
  font-size: 12px;
  display: block;
  color: #a0a0a0;
}
</style>



<script>
$(document).ready(function () {
  const REGEX_EMAIL = "([a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@" + "(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)";
  $("#supervisor").selectize({
    persist: false,
    maxItems: 1,
    placeholder: 'Select a supervisor',
    allowEmptyOption: true,
    valueField: "id",
    labelField: "full_name",
    searchField: ["full_name", "email_address"],
    options: supervisors,
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
.selectize-control.selectize_supervisors .selectize-input > div .description {
  opacity: 0.8;
}
.selectize-control.selectize_supervisors .selectize-input > div .name + .description {
  margin-left: 5px;
}
.selectize-control.selectize_supervisors .selectize-input > div .description:before {
  content: "<";
}
.selectize-control.selectize_supervisors .selectize-input > div .description:after {
  content: ">";
}
.selectize-control.selectize_supervisors .selectize-dropdown .caption {
  font-size: 12px;
  display: block;
  color: #a0a0a0;
}


</style>
</body>
</html>