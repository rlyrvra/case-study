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
<title> Pag-IBIG Fund Table | smartWage </title>
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
      document.getElementById("pagibig-menu").classList.add("active");
    </script>

    <!-- Layout container -->
    <div class="layout-page">
    <?php require_once __DIR__ . '/user.php' ?>

      <!-- / Navbar -->

      <!-- Content -->
      <div class="content-wrapper">
        <div class="container-fluid pt-5 pb-5">
            <div class="container-fluid mb-3 d-flex align-items-center">
              <h1 class="display-1">Pag-IBIG Fund Table</h1>
            </div>

            <hr/>
            <div class="card-body">
        <div class="container mt-4 mb-4">
          <label for="entries" class="form-label">Show</label>
          <select id="entries" class="form-select w-auto d-inline-block">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="15">15</option>
          </select>
          <span>entries</span>
        </div>
        <div id="pagibig-table" class="table-responsive text-no-wrap">
          <table
            class="table table-hover table-striped table-bordered flex-fill"
            id="dataTable"
          >
            <thead>
                <tr>
                  <th>Fund Salary</th>
                  <th>Employee</th>
                  <th>Employer</th>
                  <th>Employee Maximum Contribution</th>
                  <th>Employer Maximum Contribution</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1,500 and Below</td>
                  <td>1.00%</td>
                  <td>2.00%</td>
                  <td>15</td>
                  <td>30</td>
                </tr>
                <tr>
                  <td>Over 1,500</td>
                  <td>2.00%</td>
                  <td>2.00%</td>
                  <td>200</td>
                  <td>200</td>
                </tr>
              </tbody>
            </table>
        </div>
      </div>
      <nav aria-label="Page navigation" class="d-flex justify-content-center">
      <ul class="pagination pagination-lg" id="pagination"></ul>
    </nav>

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
        let currentPage = 1;
        let rowsPerPage = parseInt($("#entries").val());
        const $tableRows = $("#dataTable tbody tr");

        function updateTable() {
          rowsPerPage = parseInt($("#entries").val());
          const totalRows = $tableRows.length;
          const totalPages = Math.ceil(totalRows / rowsPerPage);

          $("#pagination")
            .empty()
            .append(
              '<li class="page-item"><a class="page-link" href="#" id="prev"><span aria-hidden="true">&laquo;</span></a></li>'
            );
          let startPage = Math.max(1, currentPage - 1);
          let endPage = Math.min(startPage + 2, totalPages);

          for (let i = startPage; i <= endPage; i++) {
            $("#pagination").append(
              `<li class="page-item">
                <a href="#" class="page-link" data-page="${i}">${i}</a></li>`
            );
          }
          $("#pagination").append(
            '<li class="page-item "><a class="page-link" href="#" id="next"><span aria-hidden="true">&raquo;</span></a></li>'
          );

          showPage(currentPage);
        }

        function showPage(page) {
          currentPage = page;
          const start = (currentPage - 1) * rowsPerPage;
          const end = start + rowsPerPage;
          $tableRows.hide().slice(start, end).show();

          $("#pagination li").removeClass("active");
          $("#pagination li a[data-page='" + currentPage + "']")
            .parent()
            .addClass("active");
        }

        $("#entries").change(function () {
          currentPage = 1;
          updateTable();
        });

        $(document).on("click", "#pagination a", function (e) {
          e.preventDefault();
          const page = $(this).attr("data-page");
          if (page) {
            showPage(parseInt(page));
          } else if ($(this).attr("id") === "prev" && currentPage > 1) {
            showPage(currentPage - 1);
          } else if (
            $(this).attr("id") === "next" &&
            currentPage < Math.ceil($tableRows.length / rowsPerPage)
          ) {
            showPage(currentPage + 1);
          }
          updateTable();
        });

        updateTable();
      });
</script>
</body>
</html>