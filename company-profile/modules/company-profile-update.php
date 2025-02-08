<!-- Scoped CSS for the company profile section -->
<style>
  /* Company Profile Section Styles */
  #company-profile-section {
    font-family: Arial, sans-serif;
    background-color: #f6fff4;
    color: #2c3e50;
    padding: 0px;
  }
  /* Header area */
  #company-profile-section .header {
    margin-top: 1px;
  }
  #company-profile-section .text-box {
    border: 2px solid #98d899;
    padding: 20px;
    margin-top: 20px;
    border-radius: 10px;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
  }
  /* Buttons */
  #company-profile-section .btn {
    background-color: #98d899;
    color: white;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }
  #company-profile-section .btn:hover {
    background-color: #76c776;
    transform: translateY(-3px);
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
  }
  /* Cards */
  #company-profile-section .card {
    background-color: white;
    border: 1px solid #98d899;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    margin-bottom: 2rem;
  }
  #company-profile-section .card-header {
    background-color: #98d899;
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
    background-color: #98d899;
    border-color: #98d899;
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
</style>

<!-- Content wrapped in a dedicated container to avoid interfering with the sidebar -->
<div id="company-profile-section" class="container my-5">
  <!-- Header Section -->
  <div class="row align-items-center header">
    <div class="col-md-6">
      <input class="form-control" list="datalistOptions" id="companyName" placeholder="Enter Company Name..." />
      <datalist id="datalistOptions">
        <option value="San Francisco"></option>
        <option value="New York"></option>
        <option value="Seattle"></option>
        <option value="Los Angeles"></option>
        <option value="Chicago"></option>
      </datalist>
      <input class="form-control form-control-sm mt-2" type="text" placeholder="October 19, 2000" />
    </div>
    <div class="col-md-6 text-center">
      <div class="text-box mx-auto" style="max-width: 300px;">
        <input type="file" class="form-control" />
      </div>
    </div>
  </div>
  <!-- Search Button -->
  <div class="row mb-4">
    <div class="col text-start">
      <button type="button" class="btn btn-success">Search</button>
    </div>
  </div>

  <!-- Company Information Card -->
  <div class="card">
    <div class="card-header">Company Information</div>
    <div class="card-body">
      <!-- Tab Navigation for Company Information -->
      <div class="nav nav-tabs justify-content-center" id="companyTabs">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#companyHistory" type="button">History</button>
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#companyDetails" type="button">Details</button>
      </div>
      <!-- Tab Content -->
      <div class="tab-content">
        <div class="tab-pane fade show active" id="companyHistory">
          <input type="text" class="form-control" placeholder="Enter Industry" />
          <input type="text" class="form-control" placeholder="Enter Business Type" />
          <input type="text" class="form-control" placeholder="Size Of Company" />
          <input type="text" class="form-control" placeholder="Enter Industry" />
        </div>
        <div class="tab-pane fade" id="companyDetails">
          <input type="text" class="form-control" placeholder="Company Details" />
        </div>
      </div>
    </div>
    <div class="card-footer text-center">
      <button type="button" class="btn btn-success">Upload</button>
    </div>
  </div>

  <!-- Contact Information Card -->
  <div class="card">
    <div class="card-header">Contact Information</div>
    <div class="card-body">
      <!-- Tab Navigation for Contact Information -->
      <ul class="nav nav-tabs justify-content-center" id="contactTabs">
        <li class="nav-item">
          <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#address" type="button">Address</button>
        </li>
        <li class="nav-item">
          <button class="nav-link" data-bs-toggle="tab" data-bs-target="#phone" type="button">Phone Number</button>
        </li>
        <li class="nav-item">
          <button class="nav-link" data-bs-toggle="tab" data-bs-target="#email" type="button">Email</button>
        </li>
        <li class="nav-item">
          <button class="nav-link" data-bs-toggle="tab" data-bs-target="#website" type="button">Website</button>
        </li>
      </ul>
      <!-- Tab Content -->
      <div class="tab-content">
        <div class="tab-pane fade show active" id="address">
          <input type="text" class="form-control" placeholder="Address" />
        </div>
        <div class="tab-pane fade" id="phone">
          <input type="text" class="form-control" placeholder="Phone Number" />
        </div>
        <div class="tab-pane fade" id="email">
          <input type="email" class="form-control" placeholder="Enter your email..." aria-describedby="emailHelp" />
        </div>
        <div class="tab-pane fade" id="website">
          <input type="text" class="form-control" placeholder="Website" />
        </div>
      </div>
    </div>
    <div class="card-footer text-center">
      <button type="button" class="btn btn-success">Upload</button>
    </div>
  </div>

  <!-- Company Principles Card -->
  <div class="card">
    <div class="card-header">Company Principles</div>
    <div class="card-body">
      <!-- Tab Navigation for Company Principles -->
      <div class="nav nav-tabs justify-content-center" role="tablist">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#mission" type="button">Mission</button>
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#vision" type="button">Vision</button>
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#values" type="button">Values</button>
      </div>
      <!-- Tab Content -->
      <div class="tab-content">
        <!-- Mission Tab -->
        <div class="tab-pane fade show active" id="mission">
          <div class="header-inputs">
            <input type="text" class="form-control" placeholder="Mission" />
          </div>
          <button type="button" class="btn btn-secondary btn-add-header d-block mx-auto" data-placeholder="Mission">Add Header</button>
        </div>
        <!-- Vision Tab -->
        <div class="tab-pane fade" id="vision">
          <div class="header-inputs">
            <input type="text" class="form-control" placeholder="Vision" />
          </div>
          <button type="button" class="btn btn-secondary btn-add-header d-block mx-auto" data-placeholder="Vision">Add Header</button>
        </div>
        <!-- Values Tab -->
        <div class="tab-pane fade" id="values">
          <div class="header-inputs">
            <input type="text" class="form-control" placeholder="Values" />
          </div>
          <button type="button" class="btn btn-secondary btn-add-header d-block mx-auto" data-placeholder="Values">Add Header</button>
        </div>
      </div>
    </div>
    <div class="card-footer text-center">
      <button type="button" class="btn btn-success">Upload</button>
    </div>
  </div>

  <!-- Compliance and Policies Card -->
  <div class="card">
    <div class="card-header">Compliance and Policies</div>
    <div class="card-body">
      <!-- Tab Navigation for Compliance and Policies -->
      <div class="nav nav-tabs justify-content-center" role="tablist">
        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#complianceHistory" type="button">HR Policies Overview</button>
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#complianceDetails" type="button">Compliance Requirements</button>
        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#complianceNotes" type="button">Important Notes</button>
      </div>
      <!-- Tab Content -->
      <div class="tab-content">
        <div class="tab-pane fade show active" id="complianceHistory">
          <div class="header-inputs">
            <input type="text" class="form-control" placeholder="HR Policies Overview" />
          </div>
          <button type="button" class="btn btn-secondary btn-add-header d-block mx-auto" data-placeholder="HR Policies Overview">Add Header</button>
        </div>
        <div class="tab-pane fade" id="complianceDetails">
          <div class="header-inputs">
            <input type="text" class="form-control" placeholder="Compliance Requirements" />
          </div>
          <button type="button" class="btn btn-secondary btn-add-header d-block mx-auto" data-placeholder="Compliance Requirements">Add Header</button>
        </div>
        <div class="tab-pane fade" id="complianceNotes">
          <div class="header-inputs">
            <input type="text" class="form-control" placeholder="Important Notes" />
          </div>
          <button type="button" class="btn btn-secondary btn-add-header d-block mx-auto" data-placeholder="Important Notes">Add Header</button>
        </div>
      </div>
    </div>
    <div class="card-footer text-center">
      <button type="button" class="btn btn-success">Upload</button>
    </div>
  </div>
</div>

  <!-- Footer -->
  <footer class="content-footer footer bg-footer-theme mt-3">
    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
        <div class="mb-2 mb-md-0">

<!-- Custom Script for Dynamic Input Addition (scoped to the company profile section) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("#company-profile-section .btn-add-header").forEach(function (btn) {
      btn.addEventListener("click", function () {
        var placeholder = btn.getAttribute("data-placeholder") || "Enter text";
        var input = document.createElement("input");
        input.type = "text";
        input.className = "form-control mb-2";
        input.placeholder = placeholder;
        var container = btn.parentElement.querySelector(".header-inputs");
        if (!container) {
          container = document.createElement("div");
          container.className = "header-inputs";
          btn.parentElement.insertBefore(container, btn);
        }
        container.appendChild(input);
      });
    });
  });
</script>
