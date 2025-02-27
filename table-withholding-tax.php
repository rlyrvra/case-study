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
<title> Withholding Tax | smartWage </title>
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
      document.getElementById("withholding-tax-menu").classList.add("active");
    </script>

    <!-- Layout container -->
    <div class="layout-page">
    <?php require_once __DIR__ . '/user.php' ?>

      <!-- / Navbar -->

      <!-- Content -->
      <div class="content-wrapper">
        <div class="container-fluid pt-5 pb-5">
          <div class="container-fluid mb-3 d-flex align-items-center">
            <h1 class="display-1">Withholding Tax Table</h1>
          </div>

          <hr/>
          <select id="Taxdrop" class="form-select" multiple="">
              <option value="daily" selected>Daily</option>
              <option value="weekly">Weekly</option>
              <option value="semiMonthly">Semi-Monthly</option>
              <option value="monthly">Monthly</option>
          </select>
          <div class="card-body">
            <table id="withholding-tax-table" class="table table-bordered table-hover table-striped">
              <thead>
                  <tr>
                    <th>Daily</th>
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    <th>5</th>
                    <th>6</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Compensation Range</td>
                    <td>₱685 and Below</td>
                    <td>₱685 - ₱1,095</td>
                    <td>₱1,095 - ₱2,191</td>
                    <td>₱2,191 - ₱5,478</td>
                    <td>₱5,479 - ₱21,917</td>
                    <td>₱21,918 and Above</td>
                  </tr>
                  <tr>
                  <td>Prescribed Withholding Tax</td>
                  <td>0.00</td>
                  <td>0.00 + 15% over ₱685</td>
                  <td>₱61.65 + 20% over ₱1,096</td>
                  <td>₱280.85 + 25% over ₱2,192</td>
                  <td>₱1,102.60 + 30% over ₱5,479</td>
                  <td>₱6,034.30 + 35% over ₱21,918</td>
                  </tr>
                  </tbody>
            </table>
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
    $(document).ready(function () {
    // Function to clear the table body
    function clearTable() {
      $('#withholding-tax-table tbody').empty(); // Clear all rows in tbody
    }

    // Function to replace the header
    function replaceHeader(headers) {
      const headerRow = headers.map(header => `<th>${header}</th>`).join('');
      $('#withholding-tax-table thead').html(`<tr>${headerRow}</tr>`);
    }

    // Function to replace the content of the table
    function replaceContent(dataset) {
      clearTable(); // Clear existing content
      dataset.forEach(data => {
        const row = `
          <tr>
            <td>${data.text}</td>
            <td>${data.one}</td>
            <td>${data.two}</td>
            <td>${data.three}</td>
            <td>${data.four}</td>
            <td>${data.five}</td>
            <td>${data.six}</td>
          </tr>
        `;
        $('#withholding-tax-table tbody').append(row);
      });
    }
    // Handle dropdown action
    $('#Taxdrop').change(function () {
      const selectedValues = $(this).val();
      if (selectedValues.length > 1) {
        // Keep only the last selected value
        $(this).val(selectedValues.slice(-1));
      }
      const selectedActionArray = $(this).val();
      const selectedAction = Array.isArray(selectedActionArray) ? selectedActionArray.join(', ') : selectedActionArray;
      console.log(selectedAction);
      const daily = {
        headers: ['Daily', '1', '2', '3', '4', '5', '6'],
        data: [
          {
            text: 'Compensation Range',
            one: '₱685 and Below',
            two: '₱685 - ₱1,095',
            three: '₱1,095 - ₱2,191',
            four: '₱2,191 - ₱5,478',
            five: '₱5,479 - ₱21,917',
            six: '₱21,918 and Above'
          },
          {
            text: 'Prescribed Withholding Tax',
            one: '0.00',
            two: '0.00 + 15% over ₱685',
            three: '₱61.65 + 20% over ₱1,096',
            four: '₱280.85 + 25% over ₱2,192',
            five: '₱1,102.60 + 30% over ₱5,479',
            six: '₱6,034.30 + 35% over ₱21,918'
          }
        ]
      };

      const weekly = {
        headers: ['Weekly', '1', '2', '3', '4', '5', '6'],
        data: [
          {
            text: 'Compensation Range',
            one: '₱4,808 and below',
            two: '₱4,808 - ₱7,691',
            three: '₱7,692 - ₱15,384',
            four: '₱15,385 - ₱38,461',
            five: '₱38,462 - ₱153,845',
            six: '₱153,846 and Above'
          },
          {
            text: 'Prescribed Withholding Tax',
            one: '0.00',
            two: '0.00 + 15% over ₱4,808',
            three: '₱432.60 +20% over ₱7,692',
            four: '₱1,971.20 +25% over ₱15,385',
            five: '₱7,740.45 +30% over ₱38,462',
            six: '₱42,355.65 +35% over ₱153,846'
          }
        ]
      };
      const semiMonthly = {
        headers: ['Semi-Monthly', '1', '2', '3', '4', '5', '6'],
        data: [
          {
            text: 'Compensation Range',
            one: '₱10,417 and below',
            two: '₱10,417 - ₱16,666',
            three: '₱16,667 - ₱33,332',
            four: '₱33,333 - ₱83,332',
            five: '₱83,333 - ₱333,332',
            six: '₱333,333 and above'
          },
          {
            text: 'Prescribed Withholding Tax',
            one: '0.00',
            two: '0.00 + 15% over ₱10,417',
            three: '₱937.50 +20% over ₱16,667',
            four: '₱4,270.70 +25% over ₱33,333',
            five: '₱16,770.70 +30% over ₱83,333',
            six: '₱91,770.70 +35% over ₱333,333'
          }
        ]
      };
      const monthly = {
        headers: ['Monthly', '1', '2', '3', '4', '5', '6'],
        data: [
          {
              text: 'Compensation Range',
            one: '₱20,833 and below',
            two: '₱20,833 - ₱33,332',
            three: '₱33,333 - ₱66,666',
            four: '₱66,667 - ₱166,666',
            five: '₱166,667 - ₱666,666',
            six: '₱666,667 and Above'
          },
          {
            text: 'Prescribed Withholding Tax',
            one: '0.00',
            two: '0.00 + 15% over ₱20,833',
            three: '₱1,875.00 +20% over ₱33,333',
            four: '₱8,541.80 +25% over ₱66,667',
            five: '₱33,541.80 +30% over ₱166,667',
            six: '₱183,541.80 +35% over ₱666,667'
          }
        ]
      };

      if (selectedAction === 'none') {
        clearTable();
        replaceHeader(['Daily', '1', '2', '3', '4', '5', '6']); // Reset headers to default
      } else if (selectedAction === 'daily') {
        replaceHeader(daily.headers);
        replaceContent(daily.data);
      } else if (selectedAction === 'weekly') {
        replaceHeader(weekly.headers);
        replaceContent(weekly.data);
      }
      else if (selectedAction === 'semiMonthly') {
        replaceHeader(semiMonthly.headers);
        replaceContent(semiMonthly.data);
      }
      else if (selectedAction === 'monthly') {
        replaceHeader(monthly.headers);
        replaceContent(monthly.data);
      }
    });
  });          
</script>
</body>
</html>