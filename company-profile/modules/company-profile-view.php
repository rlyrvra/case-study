<?php

require_once __DIR__ . '/../CompanyProfileDao.php';

require_once __DIR__ . '/../../includes/Helper.php';
require_once __DIR__ . '/../../database/database.php';

try {
  $companyProfileDao = new CompanyProfileDao($pdo);
  $selectedCompanyInformation = new CompanyInformation();
  $selectedCompanyInformation->setId(1);
  $filterCriteria = [
    [
      "column" => "id",
      "operator" => "=",
      "value" => $selectedCompanyInformation->getId()
    ]
  ];
  $companyProfile = $companyProfileDao->fetchCompanyInformation([], $filterCriteria);
  if ($companyProfile === ActionResult::FAILURE) {
    die("Failed retrieving data.");
    return;
  }
} catch (Exception $e) {
  echo "Error: " . $e->getMessage();
  die();
}


?>
<!-- Scoped CSS for the company profile section -->
<style>
  /* Company Profile Section Styles */
  #company-profile-section {
    font-family: Arial, sans-serif;
    /* background-color: #f6fff4; */
    color: #2c3e50;
    padding: 0px;
  }
  /* Header area */
  #company-profile-section .header {
    margin-top: 1px;
  }
  #company-profile-section .text-box {
    border: 2px solid #16423C;
    padding: 20px;
    margin-top: 20px;
    border-radius: 10px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
  }
  /* Buttons */
  #company-profile-section .btn {
    background-color: #16423C;
    border-color: #16423C !important;
    color: white;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  #company-profile-section .btn:hover {
    background-color: #16423C;
    transform: translateY(-3px);
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
  }
  /* Cards */
  #company-profile-section .card {
    background-color: white;
    border: 1px solid #16423C;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    margin-bottom: 2rem;
  }
  #company-profile-section .card-header {
    background-color: #16423C;
    color: white;
    font-weight: bold;
    border-bottom: none;
    text-align: center;
    padding: 10px 15px;
  }
  #company-profile-section .card-footer {
    background-color: transparent;
    border-top: none;
    padding: 1rem;
  }
  /* Tab Navigation Styles */
  #company-profile-section .nav-tabs {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-bottom: 20px;
  }
  #company-profile-section .nav-tabs .nav-link {
    color: #2c3e50;
    padding: 10px 15px;
    border: 1px solid transparent;
    border-radius: 1px;
    transition: background-color 0.2s, color 0.2s;
  }
  #company-profile-section .nav-tabs .nav-link:hover {
    color: #76c776;
  }
  #company-profile-section .nav-tabs .nav-link.active {
    color: white;
    background-color: #16423C;
    border-color: #16423C;
  }
  /* Spacing for inputs and dynamic header inputs */
  #company-profile-section .tab-content .form-control {
    margin-bottom: 10px;
  }
  #company-profile-section .header-inputs {
    margin-bottom: 10px;
  }

  .nav-tabs:not(.nav-fill):not(.nav-justified) .nav-link, .nav-pills:not(.nav-fill):not(.nav-justified) .nav-link {
    width: fit-content;
  }

  .nav-tabs .nav-item .nav-link:not(.active) {
      background-color: #4173be05;
  }
  #company-profile-section .CodeMirror {
      height: 300px !important; /* Adjust the height as needed */
  }
  #company-profile-section .input-group-text {
    height: 100%; /* Matches input height */
    padding: 0.375rem 0.75rem; /* Adjust padding */
  }

  #company-profile-section .input-group-text i {
    font-size: 1.55rem; /* Adjust icon size */
  }
</style>

<!-- Content wrapped in a dedicated container to avoid interfering with the sidebar -->
<!-- SimpleMDE for text editors -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<div id="company-profile-section" class="container my-5 p-5 card">
  <!-- Header Section -->
  <div class="row align-items-center header mb-5">
    <div class="col-md-6">
      <h1 id="companyName"><?php echo htmlspecialchars($companyProfile[0]['name']); ?></h1>
      <h5 id="date"><?php echo htmlspecialchars($companyProfile[0]['date_established']); ?></h5>
    </div>
    <div class="col-md-6 text-center">
      <?php 
            $absolutePath = $companyProfile[0]['img_location'];
            if(!$hosted) $documentRoot = 'C:\\xampp\\htdocs\\case-study\\';  
            if($hosted) $documentRoot = '\\home\\u227551606\\domains\\cs-devops.com\\public_html\\smartWage\\'; 
            $relativePath = str_replace($documentRoot, '', $absolutePath); // Convert to relative path
            $imageData = base64_encode(file_get_contents($absolutePath));
		        $src = 'data:image/jpg;base64,' . $imageData;
        ?>
      <img src="<?php echo $src; ?>" class="w-px-100 h-auto rounded-circle">
    </div>
  </div>

  <!-- Company Information Card -->
  <div class="card" style="min-height: 476.1px;">
    <div class="card-header display-6">Company Information</div>
    <!-- Tab Navigation for Company Information -->
    <div class="nav nav-tabs justify-content-center" id="companyTabs">
        <button class="nav-link active flex-grow-1 text-center" data-bs-toggle="tab" data-bs-target="#companyHistory" type="button">History</button>
        <button class="nav-link flex-grow-1 text-center" data-bs-toggle="tab" data-bs-target="#companyDetails" type="button">Details</button>
    </div>
    <div class="card-body">
      <!-- Tab Content -->
      <div class="tab-content">
        <div class="tab-pane fade show active" id="companyHistory">
          <div class="p-4 animated-card align-items-center justify-content-center h-100 w-100 flex-grow-1">
            <h3 class="text-center mb-3">Our History</h3>
            <textarea id="historyInput" style="visibility:hidden; height: 0; width: 0; display: none;"><?php echo htmlspecialchars($companyProfile[0]['history']); ?></textarea>
            <div id="historyValue"></div>
            <script>
              $(document).ready(function(){
                var simplemde = new SimpleMDE();
                simplemde.toTextArea();
                simplemde.value(document.getElementById("historyInput").value);
                document.getElementById("historyValue").innerHTML = simplemde.markdown(simplemde.value());
              });
            </script>
          </div>
        </div>
        <div class="tab-pane fade d-flex align-items-center justify-content-center h-100" id="companyDetails">
          <div class="p-4 row text-center w-100 flex-grow-1 d-flex align-items-center">
            <div class="col-md-3 mb-3">
              <i class="bx bx-briefcase fa-2x mb-2" style="color: #2d6a4f;"></i>
              <h5>Industry</h5>
              <p><?php echo htmlspecialchars($companyProfile[0]['industry']); ?></p>
            </div>

            <div class="col-md-3 mb-3">
              <i class="bx bx-building fa-2x mb-2" style="color: #2d6a4f;"></i>
              <h5>Business Type</h5>
              <p><?php echo htmlspecialchars($companyProfile[0]['business_type']); ?></p>
            </div>

            <div class="col-md-3 mb-3">
              <i class="bx bx-expand fa-2x mb-2" style="color: #2d6a4f;"></i>
              <h5>Size of Company</h5>
              <p><?php echo htmlspecialchars($companyProfile[0]['size']); ?></p>
            </div>

            <div class="col-md-3 mb-3">
              <i class="bx bx-group fa-2x mb-2" style="color: #2d6a4f;"></i>
              <h5>Employee Count</h5>
              <p><?php echo htmlspecialchars($companyProfile[0]['employee_count']); ?>+</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer text-center">
    </div>
  </div>

  <!-- Contact Information Card -->
  <div class="card">
    <div class="card-header display-6">Contact Information</div>
      <div class="card-body">
        <div class="p-4 row text-center">
          <div class="col-md-3 mb-3">
              <i class="bx bx-map fa-2x mb-2" style="color: #2d6a4f;"></i>
              <h5>Location</h5>
              <p><?php echo htmlspecialchars($companyProfile[0]['address']); ?></p>
          </div>
          <div class="col-md-3 mb-3">
              <i class="bx bx-phone fa-2x mb-2" style="color: #2d6a4f;"></i>
              <h5>Phone Number</h5>
              <p><?php echo htmlspecialchars($companyProfile[0]['phone']); ?></p>
          </div>
          <div class="col-md-3 mb-3">
              <i class="bx bx-envelope fa-2x mb-2" style="color: #2d6a4f;"></i>
              <h5>Email</h5>
              <p><?php echo htmlspecialchars($companyProfile[0]['email']); ?></p>
          </div>
          <div class="col-md-3 mb-3">
              <i class="bx bx-globe fa-2x mb-2" style="color: #2d6a4f;"></i>
              <h5>Website</h5>
              <p><?php echo htmlspecialchars($companyProfile[0]['website']); ?></p>
          </div>  
        </div>
      </div>
    <div class="card-footer text-center">
    </div>
  </div>

  <!-- Company Principles Card -->
  <div class="card">
    <div class="card-header display-6">Company Principles</div>
    <!-- Tab Navigation for Company Principles -->
    <div class="nav nav-tabs justify-content-center" role="tablist">
        <button class="nav-link active flex-grow-1 text-center" data-bs-toggle="tab" data-bs-target="#mission" type="button">Mission</button>
        <button class="nav-link flex-grow-1 text-center" data-bs-toggle="tab" data-bs-target="#vision" type="button">Vision</button>
        <button class="nav-link flex-grow-1 text-center" data-bs-toggle="tab" data-bs-target="#values" type="button">Values</button>
    </div>
    <div class="card-body">
      <!-- Tab Content -->
      <div class="tab-content">
        <!-- Mission Tab -->
        <div class="tab-pane fade show active" id="mission">
          <div class="p-4 animated-card align-items-center justify-content-center h-100 w-100 flex-grow-1">
            <h3 class="text-center mb-3">Our Mission</h3>
            <textarea id="missionInput" style="visibility:hidden; height: 0; width: 0; display: none;"><?php echo htmlspecialchars($companyProfile[0]['mission']); ?></textarea>
            <div id="missionValue"></div>
            <script>
              $(document).ready(function(){
                var simplemde = new SimpleMDE();
                simplemde.toTextArea();
                simplemde.value(document.getElementById("missionInput").value);
                document.getElementById("missionValue").innerHTML = simplemde.markdown(simplemde.value());
              });
            </script>
          </div>
        </div>
        <!-- Vision Tab -->
        <div class="tab-pane fade" id="vision">
          <div class="p-4 animated-card align-items-center justify-content-center h-100 w-100 flex-grow-1">
            <h3 class="text-center mb-3">Our Vision</h3>
            <textarea id="visionInput" style="visibility:hidden; height: 0; width: 0; display: none;"><?php echo htmlspecialchars($companyProfile[0]['vision']); ?></textarea>
            <div id="visionValue"></div>
            <script>
              $(document).ready(function(){
                var simplemde = new SimpleMDE();
                simplemde.toTextArea();
                simplemde.value(document.getElementById("visionInput").value);
                document.getElementById("visionValue").innerHTML = simplemde.markdown(simplemde.value());
              });
            </script>
          </div>
        </div>
        <!-- Values Tab -->
        <div class="tab-pane fade" id="values">
          <div class="p-4 animated-card align-items-center justify-content-center h-100 w-100 flex-grow-1">
            <h3 class="text-center mb-3">Our Values</h3>
            <textarea id="valuesInput" style="visibility:hidden; height: 0; width: 0; display: none;"><?php echo htmlspecialchars($companyProfile[0]['company_values']); ?></textarea>
            <div id="valuesValue"></div>
            <script>
              $(document).ready(function(){
                var simplemde = new SimpleMDE();
                simplemde.toTextArea();
                simplemde.value(document.getElementById("valuesInput").value);
                document.getElementById("valuesValue").innerHTML = simplemde.markdown(simplemde.value());
              });
            </script>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer text-center">
    </div>
  </div>

  <!-- Compliance and Policies Card -->
  <div class="card">
    <div class="card-header display-6">Compliance and Policies</div>
    <!-- Tab Navigation for Compliance and Policies -->
    <div class="nav nav-tabs justify-content-center" role="tablist">
        <button class="nav-link active flex-grow-1 text-center" data-bs-toggle="tab" data-bs-target="#complianceHistory" type="button">HR Policies Overview</button>
        <button class="nav-link flex-grow-1 text-center" data-bs-toggle="tab" data-bs-target="#complianceDetails" type="button">Compliance Requirements</button>
        <button class="nav-link flex-grow-1 text-center" data-bs-toggle="tab" data-bs-target="#complianceNotes" type="button">Important Notes</button>
    </div>
    <div class="card-body">
      <!-- Tab Content -->
      <div class="tab-content">
        <!-- Compliance Tab -->
        <div class="tab-pane fade show active" id="complianceHistory">
          <div class="p-4 animated-card align-items-center justify-content-center h-100 w-100 flex-grow-1">
            <h3 class="text-center mb-3">HR Policies</h3>
            <textarea id="policiesInput" style="visibility:hidden; height: 0; width: 0; display: none;"><?php echo htmlspecialchars($companyProfile[0]['policies']); ?></textarea>
            <div id="policiesValue"></div>
            <script>
              $(document).ready(function(){
                var simplemde = new SimpleMDE();
                simplemde.toTextArea();
                simplemde.value(document.getElementById("policiesInput").value);
                document.getElementById("policiesValue").innerHTML = simplemde.markdown(simplemde.value());
              });
            </script>
          </div>
        </div>
        <div class="tab-pane fade" id="complianceDetails">
          <div class="p-4 animated-card align-items-center justify-content-center h-100 w-100 flex-grow-1">
            <h3 class="text-center mb-3">Compliance and Legal</h3>
            <textarea id="complianceInput" style="visibility:hidden; height: 0; width: 0; display: none;"><?php echo htmlspecialchars($companyProfile[0]['compliance']); ?></textarea>
            <div id="complianceValue"></div>
            <script>
              $(document).ready(function(){
                var simplemde = new SimpleMDE();
                simplemde.toTextArea();
                simplemde.value(document.getElementById("complianceInput").value);
                document.getElementById("complianceValue").innerHTML = simplemde.markdown(simplemde.value());
              });
            </script>
          </div>
        </div>
        <div class="tab-pane fade" id="complianceNotes">
          <div class="p-4 animated-card align-items-center justify-content-center h-100 w-100 flex-grow-1">
            <h3 class="text-center mb-3">Important Notes</h3>
            <textarea id="notesInput" style="visibility:hidden; height: 0; width: 0; display: none;"><?php echo htmlspecialchars($companyProfile[0]['notes']); ?></textarea>
            <div id="notesValue"></div>
            <script>
              $(document).ready(function(){
                var simplemde = new SimpleMDE();
                simplemde.toTextArea();
                simplemde.value(document.getElementById("notesInput").value);
                document.getElementById("notesValue").innerHTML = simplemde.markdown(simplemde.value());
              });
            </script>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer text-center">
    </div>
  </div>
</div>
