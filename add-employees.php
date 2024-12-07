<?php 
require_once __DIR__ . '/includes/security-headers.php'; 
require_once __DIR__ . '/includes/session.php'; 
require_once __DIR__ . '/includes/file-locations.php';
require_once __DIR__ . '/login-checker.php';


if($_SESSION['access_role'] !== 'Admin' && $_SESSION['access_role'] !== 'Manager'){
  header("Location: ". $SMARTWAGE_LOCATION ."/smartWage-index.php?aR=true");
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
  border-radius: 5px;
  border: 2px solid #16423C;
}
.form-container label {
  font-weight: 500;
}
.form-title {
  font-size: 1.5rem;
  font-weight: bold;
  margin-bottom: 20px;
}
.form-label {
  font-weight: bold;
}
</style>
<head>
<title> Add Employees </title>
<!-- font-awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Selectize -->
<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
  integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer"
/>

<!-- Ajax -->
<!-- <script src="departments/modules/departments-ajax.js?v1.2"></script> -->
<!-- Scripts -->
<script src="employees/modules/add-employee-scripts.js?v1.2"></script>




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
              <h1 class="display-1">Employees</h1>
            </div>

            <div class="divider text-start">
              <div class="divider-text">
                
              </div>
            </div>

            <div class="container-fluid card pt-5 pb-5 mt-5 mb-5">
              <div class="row justify-content-center">
                <!-- Header -->
                <div class="profile-header col-auto">
                  <img src="https://via.placeholder.com/50" alt="Profile Picture">
                  <div>
                    <h5 class="display-5">Employee’s Name</h5>
                    <p class="mb-0">Department</p>
                    <p class="mb-0">Job Title</p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 d-flex justify-content-center flex-column flex-lg-row">
                  <ul class="col-3 menu-vertical nav nav-pills pt-4 pb-4" role="tablist">
                    <li class="nav-item">
                      <button
                        type="button"
                        class="nav-link active"
                        role="tab"
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
                        class="nav-link"
                        role="tab"
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
                        class="nav-link"
                        role="tab"
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
                        class="nav-link"
                        role="tab"
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
                        class="nav-link"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-pills-contact-information"
                        aria-controls="navs-pills-contact-information"
                        aria-selected="false"
                      >
                        Salary Information
                      </button>
                    </li>
                    <li class="nav-item">
                      <button
                        type="button"
                        class="nav-link"
                        role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#navs-pills-contact-information"
                        aria-controls="navs-pills-contact-information"
                        aria-selected="false"
                      >
                        Government Information
                      </button>
                    </li>
                  </ul>
                  <div class="col-9 tab-content flex-fill">
                    <div class="tab-pane fade show active" id="navs-pills-personal-information" role="tabpanel">
                      <!-- Form -->
                      <div class="form-container p-4">
                        <h3 class="form-title">Personal Information: (1/5)</h3>
                        <form onsubmit="event.preventDefault()" id="personal_information">
                          <div class="row mb-3">
                            <div class="col-md-4">
                              <label for="firstName" class="form-label">First Name*</label>
                              <input type="text" class="form-control" id="firstName" placeholder="First Name" required>
                            </div>
                            <div class="col-md-4">
                              <label for="middleName" class="form-label">Middle Name</label>
                              <input type="text" class="form-control" id="middleName" placeholder="Middle Name" required>
                            </div>
                            <div class="col-md-4">
                              <label for="lastName" class="form-label">Last Name*</label>
                              <input type="text" class="form-control" id="lastName" placeholder="Last Name" required>
                            </div>
                          </div>
                          <div class="row mb-3">
                            <div class="col-md-4">
                              <label for="dob" class="form-label">Date of Birth*</label>
                              <input type="date" class="form-control" id="dob" required>
                            </div>
                            <div class="col-md-4">
                              <label for="gender" class="form-label">Gender*</label>
                              <select id="gender" class="form-select" require>
                                <option selected disabled>Choose...</option>
                                <option>Male</option>
                                <option>Female</option>
                                <option>Other</option>
                              </select>
                            </div>
                            <div class="col-md-4">
                              <label for="maritalStatus" class="form-label">Marital Status*</label>
                              <select id="maritalStatus" class="form-select" require>
                                <option selected disabled>Choose...</option>
                                <option>Single</option>
                                <option>Married</option>
                                <option>Divorced</option>
                              </select>
                            </div>
                          </div>
                          <div class="row mb-3">
                            <div class="col-md-6">
                              <label for="nationality" class="form-label">Nationality*</label>
                              <input type="text" class="form-control" id="nationality" placeholder="Nationality" required>
                            </div>
                            <div class="col-md-6">
                              <label for="religion" class="form-label">Religion</label>
                              <input type="text" class="form-control" id="religion" placeholder="Religion">
                            </div>
                          </div>
                          <div class="row mb-3">
                            <div class="col-md-12">
                              <label for="profilePicture" class="form-label">Profile Picture</label>
                              <input type="file" class="form-control" id="profilePicture" accept=".jpg">
                            </div>
                          </div>
                          <div class="row mb-3">
                            <div class="col-md-12 justify-content-end d-flex">
                              <button type="submit" class="btn btn-primary" id="personal_info_submit" onclick="nextForm(2)">Submit</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="navs-pills-login-credentials" role="tabpanel">
                      <div class="form-container p-4">
                        <h3 class="form-title">Login Credentials:</h3>
                        <form onsubmit="event.preventDefault()" id="login_credentials">
                          <div class="mb-3">
                            <label for="username" class="form-label">Username*:</label>
                            <input type="text" class="form-control" id="username" placeholder="Enter your username" required>
                          </div>
                          <div class="mb-3">
                            <label for="password" class="form-label">Password*:</label>
                            <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                          </div>
                          <div class="row mb-3">
                            <div class="col-md-12 justify-content-end d-flex">
                              <button type="submit" class="btn btn-primary" id="login_credentials_submit" onclick="nextForm(3)">Submit</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="navs-pills-contact-information" role="tabpanel">
                      <div class="form-container p-4">
                        <h3 class="form-title">Contact Information:</h3>
                        <form onsubmit="event.preventDefault()" id="contact_information">
                          <div class="row mb-3">
                            <div class="col-md-6">
                              <label for="phone" class="form-label">Phone Number*</label>
                              <input type="text" class="form-control" id="phone" placeholder="Enter phone number" required>
                            </div>
                            <div class="col-md-6">
                              <label for="email" class="form-label">Email Address*</label>
                              <input type="email" class="form-control" id="email" placeholder="Enter email address" required>
                            </div>
                          </div>
                          <div class="mb-3">
                            <label for="address" class="form-label">Address*</label>
                            <textarea class="form-control" id="address" placeholder="Enter address" required></textarea>
                          </div>

                          <h3 class="form-title">Emergency Contact Information:</h3>
                          <div class="row mb-3">
                            <div class="col-md-6">
                              <label for="emergency-name" class="form-label">Name*</label>
                              <input type="text" class="form-control" id="emergency-name" placeholder="Enter name" required>
                            </div>
                            <div class="col-md-6">
                              <label for="relationship" class="form-label">Relationship*</label>
                              <input type="text" class="form-control" id="relationship" placeholder="Enter relationship" required>
                            </div>
                          </div>
                          <div class="row mb-3">
                            <div class="col-md-6">
                              <label for="emergency-phone" class="form-label">Phone Number*</label>
                              <input type="text" class="form-control" id="emergency-phone" placeholder="Enter phone number" required>
                            </div>
                            <div class="col-md-6">
                              <label for="emergency-email" class="form-label">Email Address</label>
                              <input type="email" class="form-control" id="emergency-email" placeholder="Enter email address">
                            </div>
                          </div>
                          <div class="mb-3">
                            <label for="emergency-address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="emergency-address" placeholder="Enter address">
                          </div>
                          <div class="row mb-3">
                            <div class="col-md-12 justify-content-end d-flex">
                              <button type="submit" class="btn btn-primary" id="contact_information_submit" onclick="nextForm(4)">Submit</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="navs-pills-employment-information" role="tabpanel">
                      <div class="form-container p-4">
                        <h3 class="form-title">Employment Information:</h3>
                        <form onsubmit="event.preventDefault()" id="employment_information">
                          <div class="row mb-3">
                            <div class="col-md-6">
                              <label for="rfid" class="form-label">RFID Tag*</label>
                              <input type="text" class="form-control" id="rfid" placeholder="Enter RFID Tag" required>
                            </div>
                            <div class="col-md-6">
                              <label for="employee-code" class="form-label">Employee Code*</label>
                              <input type="text" class="form-control" id="employee-code" placeholder="Enter Employee Code" readonly>
                            </div>
                          </div>
                          <div class="row mb-3">
                            <div class="col-md-4">
                              <label for="job-title" class="form-label">Job Title*</label>
                              <select class="form-select selectize_job_title" id="job-title" name="job-title">
                              </select>
                            </div>
                            <div class="col-md-4">
                              <label for="department" class="form-label">Department*</label>
                              <select class="form-select selectize_department" id="department" name="departments">
                              </select>
                            </div>
                            <div class="col-md-4">
                              <label for="employment-type" class="form-label">Employment Type*</label>
                              <select class="form-select" id="employment-type" required>
                                <option selected disabled>Select Type</option>
                                <option>Regular / Permanent</option>
                                <option>Casual</option>
                                <option>Contractual</option>
                                <option>Project-Based</option>
                                <option>Seasonal</option>
                                <option>Fixed-Term</option>
                                <option>Probationary</option>
                                <option>Part-Time</option>
                                <option>Self-Employment</option>
                                <option>Freelance</option>
                                <option>Internship</option>
                                <option>Consultancy</option>
                                <option>Apprenticeship</option>
                                <option>Traineeship</option>
                                <option>Gig</option>
                              </select>
                            </div>
                          </div>
                          <div class="row mb-3">
                            <div class="col-md-6">
                              <label for="date-of-hire" class="form-label">Date of Hire*</label>
                              <input type="date" class="form-control" id="date-of-hire" required>
                            </div>
                            <div class="col-md-6">
                              <label for="supervisor" class="form-label">Supervisor</label>
                              <select class="form-select selectize_supervisors" id="supervisor">
                              </select>
                            </div>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Role*</label>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="role" id="role-staff" value="Staff" checked>
                              <label class="form-check-label" for="role-staff">Staff</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="role" id="role-supervisor" value="Supervisor">
                              <label class="form-check-label" for="role-supervisor">Supervisor</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="role" id="role-manager" value="Manager">
                              <label class="form-check-label" for="role-manager">Manager</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="role" id="role-admin" value="Admin">
                              <label class="form-check-label" for="role-admin">Admin</label>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="divider text-start">
              <div class="divider-text">
                
              </div>
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


</body>
</html>