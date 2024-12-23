<?php require_once __DIR__ . '/includes/security-headers.php'; ?>
<?php require_once __DIR__ . '/includes/session.php'; ?>
<?php require_once __DIR__ . '/includes/file-locations.php' ?>

<?php
require_once __DIR__ . '/login-checker.php';

if(isset($_GET['s']) && $_GET['s'] == true){
  include_once __DIR__ . '/sweet-alert-toasts/login/login-success.php';
}

if(isset($_GET['aR']) && $_GET['aR'] == true){
  include_once __DIR__ . '/sweet-alert-toasts/login/login-access-role-insufficient.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<style>



</style>
<head>
<title> Dashboard </title>
<link rel="icon" type="image/x-icon" href="img/logo-files/logo1.ico" />
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
      document.getElementById("dashboard-menu").classList.add("active");
    </script>

    <!-- Layout container -->
    <div class="layout-page">
    <?php require_once __DIR__ . '/user.php' ?>
    <style>
      .container {
      max-width: 900px;
      margin: 0 auto;
      }
      .line{
          border-bottom: black 1px solid;
      }
      table .content{
      width: 100%;
      border-collapse: collapse; /* Ensures cells share borders */
      border-spacing: 0; /* Removes extra spacing between cells */
      } 
      .controls {
      margin-bottom: 20px;
      text-align: left;
      justify-content: space-between;
      display: flex;
      align-items: center;
        }
        .align{
          align-self: center;
        }
      .pagination {
      display: flex;
      justify-content: space-between;
      margin-top: 20px;
      }
      button:disabled {
      background-color: #ccc;
      cursor: not-allowed;
      }
      .dropdown-item.selected {
      font-weight: bold;
      color: #4CAF50;
      }
      .dropdown-divider {
      margin: 0;
      }
      .space{
          padding: 10px;
      }
      </style>
      <!-- / Navbar -->
      <div class="content-wrapper">
        <div class="container-fluid">
            
          




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
          <script>
//Row Count Control
let rowCount = 0; // Track row numbers
const itemsPerPage = document.getElementById("entries-per-page").value; // Number of rows per page
let currentPage = 1; // Current page
const tableData = []; // Array to store all rows for pagination

//Dropdown Selection Highlight
const dropdownItems = document.querySelectorAll('.dropdown-item');
const dropdownButton = document.getElementById('dropdownMenuButton');

              const selectedOptions = {
              group1: null,
              group2: null
              };
              dropdownItems.forEach(item => {
              item.addEventListener('click', (e) => {
              e.preventDefault();
        
              const group = item.getAttribute('data-group');
              const value = item.getAttribute('data-value');

            // Deselect previously selected option in the same group
              dropdownItems.forEach(option => {
              if (option.getAttribute('data-group') === group) {
              option.classList.remove('selected');
              }
            });

            // Select the clicked option
              item.classList.add('selected');
              selectedOptions[group] = value;

            // Update dropdown button text
              const selectedText = Object.values(selectedOptions)
              .filter(val => val)
              .map(val => val.replace('option', 'Option '))
              .join(', ');
        
             });
            });
            
// Function to render the current page
function renderPage() {
  const tableBody = document.querySelector("#dynamicTable tbody");
  // tableBody.innerHTML = ""; // Clear existing rows

  // Calculate start and end indices for the current page
  const startIndex = (currentPage - 1) * itemsPerPage;
  const endIndex = Math.min(startIndex + itemsPerPage, tableData.length);

  // Add rows for the current page
  const rows = tableData.slice(startIndex, endIndex);
  rows.forEach((row) => {
    const newRow = document.createElement("tr");
    newRow.innerHTML = row;
    tableBody.appendChild(newRow);
  });

  // Update pagination controls
  document.getElementById("paginationInfo").textContent = `${currentPage}`;
  // .textContent = `Page ${currentPage} of ${Math.ceil(
  //   tableData.length / itemsPerPage
  // )}`;
  document.getElementById("prevPageBtn").disabled = currentPage === 1;
  document.getElementById("nextPageBtn").disabled =
    currentPage === Math.ceil(tableData.length / itemsPerPage);

  // Update pagination controls
  const currentEntriesCount = endIndex - startIndex; // Current rows displayed
  const totalEntriesCount = tableData.length; // Total rows in the dataset

  // Update the pagination info to show current and total entries
  document.getElementById(
    "entry-info"
  ).textContent = `Showing ${currentEntriesCount} of ${totalEntriesCount} entries`;
}

// Function to handle form submission and add rows dynamically
document
  .getElementById("rowInputForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent form submission

    rowCount++; // Increment row count
    const col1 = document.getElementById("col2").value;
    const col2 = document.getElementById("col3").value;
    const col3 =
      document.querySelector("input[name='yesNoOption']:checked")?.value || "";
    const col4 = document.getElementById("col5").value;
    const col5 =
      document.querySelector("input[name='ActiveInactive']:checked")?.value ||
      "";

    // Create row HTML
    const newRowHTML = `
  <td>${rowCount}</td>
  <td>${col1}</td>
  <td>${col2}</td>
  <td>${col3}</td>
  <td>${col4}</td>
  <td>${col5}</td>
  <td>
    <button class="btn btn-primary btn-sm">Edit</button>
    <button class="btn btn-danger btn-sm">Delete</button>
  </td>
`;

    // Add the row HTML to the tableData array
    tableData.push(newRowHTML);

    // Close the modal and reset the form
    $("#inputModal").modal("hide");
    document.getElementById("rowInputForm").reset();

    // Render the current page
    renderPage();
  });
// Initial render
renderPage();
        $(document).ready(function() {
            $('#myTable').DataTable({
   
                });
            });
            

            
          </script>
</body>
</html>