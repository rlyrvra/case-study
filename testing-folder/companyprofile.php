<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Company Profile</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f6fff4; /* Light green background */
      color: #2c3e50; /* Dark text for better readability */
    }
    .header {
      margin-top: 20px;
      margin-bottom: 30px;
    }
    .text-box {
      border: 2px solid #98d899; /* Light green border */
      padding: 20px;
      margin-top: 20px;
      border-radius: 10px;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    }
    .text-box img {
      width: 100%;
      height: auto;
      border-radius: 8px;
    }
    .btn {
      background-color: #98d899; /* Light green */
      color: white;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .btn:hover {
      background-color: #76c776;
      transform: translateY(-3px);
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }
    .card {
      background-color: white;
      border: 1px solid #98d899;
      box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
      border-radius: 8px;
      margin-bottom: 2rem;
    }
    .card-header {
      background-color: #98d899;
      color: white;
      font-weight: bold;
      border-bottom: none;
      text-align: center;
    }
    /* Ensure that active tab content is centered */
    .tab-content > .active {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }
    .nav-tabs .nav-link {
      color: #2c3e50;
    }
    .nav-tabs .nav-link:hover {
      color: #76c776;
    }
    .nav-tabs .nav-link.active {
      color: white;
      background-color: #98d899;
      border-color: #98d899;
    }
  </style>
</head>
<body>
  <div class="container my-5">

    <!-- Edit Details Form -->
    <div class="card my-4">
      <div class="card-header text-center">Edit Company Details</div>
      <div class="card-body">
        <!-- Header -->
        <div class="mb-3">
          <label for="editCompanyName" class="form-label">Company Name</label>
          <input type="text" class="form-control" id="editCompanyName" value="Company Name" />
        </div>
        <div class="mb-3">
          <label for="editCompanyDate" class="form-label">Date</label>
          <input type="text" class="form-control" id="editCompanyDate" value="October 19, 2000" />
        </div>
        <!-- Company Information -->
        <div class="mb-3">
          <label for="editCompanyHistory" class="form-label">Company History</label>
          <textarea class="form-control" id="editCompanyHistory" rows="3">Sample Industry
Sample Industry
Sample Industry</textarea>
        </div>
        <div class="mb-3">
          <label for="editCompanyDetails" class="form-label">Company Details</label>
          <textarea class="form-control" id="editCompanyDetails" rows="3">Details content goes here...</textarea>
        </div>
        <!-- Contact Information -->
        <div class="mb-3">
          <label for="editAddress" class="form-label">Address</label>
          <input type="text" class="form-control" id="editAddress" value="Address content..." />
        </div>
        <div class="mb-3">
          <label for="editPhone" class="form-label">Phone Number</label>
          <input type="text" class="form-control" id="editPhone" value="Phone content..." />
        </div>
        <div class="mb-3">
          <label for="editEmail" class="form-label">Email</label>
          <input type="text" class="form-control" id="editEmail" value="Email content..." />
        </div>
        <div class="mb-3">
          <label for="editWebsite" class="form-label">Website</label>
          <input type="text" class="form-control" id="editWebsite" value="Website content..." />
        </div>
        <!-- Company Principles -->
        <div class="mb-3">
          <label for="editMission" class="form-label">Mission</label>
          <input type="text" class="form-control" id="editMission" value="Mission content..." />
        </div>
        <div class="mb-3">
          <label for="editVision" class="form-label">Vision</label>
          <input type="text" class="form-control" id="editVision" value="Vision content..." />
        </div>
        <div class="mb-3">
          <label for="editValues" class="form-label">Values</label>
          <input type="text" class="form-control" id="editValues" value="Values content..." />
        </div>
        <!-- Compliance and Policies -->
        <div class="mb-3">
          <label for="editPoliciesOverview" class="form-label">HR Policies Overview</label>
          <textarea class="form-control" id="editPoliciesOverview" rows="3">HR Policies Overview content...</textarea>
        </div>
        <div class="mb-3">
          <label for="editPoliciesCompliance" class="form-label">Compliance Requirements</label>
          <textarea class="form-control" id="editPoliciesCompliance" rows="3">Compliance Requirements content...</textarea>
        </div>
        <div class="mb-3">
          <label for="editPoliciesNotes" class="form-label">Important Notes</label>
          <textarea class="form-control" id="editPoliciesNotes" rows="3">Important Notes content...</textarea>
        </div>
      </div>
    </div>

    <!-- Header Section -->
    <div class="row align-items-center header">
      <!-- Company Name & Date -->
      <div class="col-md-6 text-start">
        <h1 id="companyNameDisplay">Company Name</h1>
        <p id="companyDateDisplay" class="text-muted">October 19, 2000</p>
      </div>
      <!-- Image Section -->
      <div class="col-md-6 text-end">
        <div class="text-box">
          <img src="your-image-url.jpg" alt="Image here." />
        </div>
      </div>
    </div>

    <!-- Company Information Card -->
    <div class="card my-4">
      <div class="card-header text-center">Company Information</div>
      <div class="card-body">
        <div class="nav nav-tabs justify-content-center mb-3" id="companyInfoTab" role="tablist">
          <button class="nav-link active" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab" aria-controls="history" aria-selected="true">History</button>
          <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab" aria-controls="details" aria-selected="false">Details</button>
        </div>
        <div class="tab-content text-center" id="companyInfoTabContent">
          <div class="tab-pane fade show active" id="history" role="tabpanel" aria-labelledby="history-tab">
            <div id="companyHistoryDisplay">
              Sample Industry<br>
              Sample Industry<br>
              Sample Industry<br>
            </div>
          </div>
          <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
            <div id="companyDetailsDisplay">
              Details content goes here...
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Contact Information Card -->
    <div class="card my-4">
      <div class="card-header text-center">Contact Information</div>
      <div class="card-body">
        <div class="nav nav-tabs justify-content-center mb-3" id="contactInfoTab" role="tablist">
          <button class="nav-link active" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="address" aria-selected="true">Address</button>
          <button class="nav-link" id="phone-tab" data-bs-toggle="tab" data-bs-target="#phone" type="button" role="tab" aria-controls="phone" aria-selected="false">Phone Number</button>
          <button class="nav-link" id="email-tab" data-bs-toggle="tab" data-bs-target="#email" type="button" role="tab" aria-controls="email" aria-selected="false">Email</button>
          <button class="nav-link" id="website-tab" data-bs-toggle="tab" data-bs-target="#website" type="button" role="tab" aria-controls="website" aria-selected="false">Website</button>
        </div>
        <div class="tab-content text-center" id="contactInfoTabContent">
          <div class="tab-pane fade show active" id="address" role="tabpanel" aria-labelledby="address-tab">
            <div id="addressDisplay">
              Address content...
            </div>
          </div>
          <div class="tab-pane fade" id="phone" role="tabpanel" aria-labelledby="phone-tab">
            <div id="phoneDisplay">
              Phone content...
            </div>
          </div>
          <div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="email-tab">
            <div id="emailDisplay">
              Email content...
            </div>
          </div>
          <div class="tab-pane fade" id="website" role="tabpanel" aria-labelledby="website-tab">
            <div id="websiteDisplay">
              Website content...
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Company Principles Card -->
    <div class="card my-4">
      <div class="card-header text-center">Company Principles</div>
      <div class="card-body">
        <div class="nav nav-tabs justify-content-center mb-3" id="principlesTab" role="tablist">
          <button class="nav-link active" id="mission-tab" data-bs-toggle="tab" data-bs-target="#mission" type="button" role="tab" aria-controls="mission" aria-selected="true">Mission</button>
          <button class="nav-link" id="vision-tab" data-bs-toggle="tab" data-bs-target="#vision" type="button" role="tab" aria-controls="vision" aria-selected="false">Vision</button>
          <button class="nav-link" id="values-tab" data-bs-toggle="tab" data-bs-target="#values" type="button" role="tab" aria-controls="values" aria-selected="false">Values</button>
        </div>
        <div class="tab-content text-center" id="principlesTabContent">
          <div class="tab-pane fade show active" id="mission" role="tabpanel" aria-labelledby="mission-tab">
            <div id="missionDisplay">
              Mission content...
            </div>
          </div>
          <div class="tab-pane fade" id="vision" role="tabpanel" aria-labelledby="vision-tab">
            <div id="visionDisplay">
              Vision content...
            </div>
          </div>
          <div class="tab-pane fade" id="values" role="tabpanel" aria-labelledby="values-tab">
            <div id="valuesDisplay">
              Values content...
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Compliance and Policies Card -->
    <div class="card my-4">
      <div class="card-header text-center">Compliance and Policies</div>
      <div class="card-body">
        <div class="nav nav-tabs justify-content-center mb-3" id="policiesTab" role="tablist">
          <button class="nav-link active" id="policies-overview-tab" data-bs-toggle="tab" data-bs-target="#policies-overview" type="button" role="tab" aria-controls="policies-overview" aria-selected="true">HR Policies Overview</button>
          <button class="nav-link" id="policies-compliance-tab" data-bs-toggle="tab" data-bs-target="#policies-compliance" type="button" role="tab" aria-controls="policies-compliance" aria-selected="false">Compliance Requirements</button>
          <button class="nav-link" id="policies-notes-tab" data-bs-toggle="tab" data-bs-target="#policies-notes" type="button" role="tab" aria-controls="policies-notes" aria-selected="false">Important Notes</button>
        </div>
        <div class="tab-content text-center" id="policiesTabContent">
          <div class="tab-pane fade show active" id="policies-overview" role="tabpanel" aria-labelledby="policies-overview-tab">
            <div id="policiesOverviewDisplay">
              HR Policies Overview content...
            </div>
          </div>
          <div class="tab-pane fade" id="policies-compliance" role="tabpanel" aria-labelledby="policies-compliance-tab">
            <div id="policiesComplianceDisplay">
              Compliance Requirements content...
            </div>
          </div>
          <div class="tab-pane fade" id="policies-notes" role="tabpanel" aria-labelledby="policies-notes-tab">
            <div id="policiesNotesDisplay">
              Important Notes content...
            </div>
          </div>
        </div>
      </div>
    </div>

  </div> <!-- End Container -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // A helper function that listens for input events on an edit field
    // and updates a display element (replacing newlines with <br> tags)
    function updateDisplay(editId, displayId) {
      const editElem = document.getElementById(editId);
      const displayElem = document.getElementById(displayId);
      if (editElem && displayElem) {
        editElem.addEventListener("input", function () {
          displayElem.innerHTML = this.value.replace(/\n/g, "<br>");
        });
      }
    }
    // Header
    updateDisplay("editCompanyName", "companyNameDisplay");
    updateDisplay("editCompanyDate", "companyDateDisplay");
    // Company Information
    updateDisplay("editCompanyHistory", "companyHistoryDisplay");
    updateDisplay("editCompanyDetails", "companyDetailsDisplay");
    // Contact Information
    updateDisplay("editAddress", "addressDisplay");
    updateDisplay("editPhone", "phoneDisplay");
    updateDisplay("editEmail", "emailDisplay");
    updateDisplay("editWebsite", "websiteDisplay");
    // Company Principles
    updateDisplay("editMission", "missionDisplay");
    updateDisplay("editVision", "visionDisplay");
    updateDisplay("editValues", "valuesDisplay");
    // Compliance and Policies
    updateDisplay("editPoliciesOverview", "policiesOverviewDisplay");
    updateDisplay("editPoliciesCompliance", "policiesComplianceDisplay");
    updateDisplay("editPoliciesNotes", "policiesNotesDisplay");
  </script>
</body>
</html>
