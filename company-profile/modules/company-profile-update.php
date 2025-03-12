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
  <div class="row align-items-center header">
    <div class="col-md-6">
      <input class="form-control" list="datalistOptions" id="companyName" placeholder="Enter Company Name..." style="min-height: 75px; font-size: 2.0rem;" />
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
      <img src="img/logo-files/logo.png" class="w-px-100 h-auto rounded-circle">
      <div class="text-box mx-auto" style="max-height: 100px; max-width: 300px;">
        <input type="file" class="form-control" />
      </div>
    </div>
  </div>
  <!-- Search Button -->
  <div class="row mb-4">
    <div class="col text-start">
      <button type="button" class="btn btn-success">Update</button>
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
          <textarea id="historyEditor" placeholder="History"></textarea>
          <p id="historyCharCount">0/200 characters</p>

          <!-- SimpleMDE JavaScript -->
          <script>
              const historyMaxChars = 200;

              // Initialize SimpleMDE for History Editor
              var historySimpleMde = new SimpleMDE({ 
                  element: document.getElementById("historyEditor"),
                  toolbar: [
                      "bold", "italic", "|",
                      "quote", 
                      {
                          name: "clear",
                          action: function customFunction(editor){
                              editor.value(""); // Clear the editor content
                          },
                          className: "fa fa-eraser", // Icon for the button
                          title: "Clear Editor",
                      }, "|",
                      "preview", "side-by-side", "fullscreen"
                  ]
              });

              // Update character count and enforce limit
              historySimpleMde.codemirror.on("change", function() {
                  let historyContent = historySimpleMde.value();
                  let historyCharCount = historyContent.length;

                  // Check if the character limit is exceeded
                  if (historyCharCount > historyMaxChars) {
                      // Trim content to maxChars if limit exceeded
                      historySimpleMde.value(historyContent.substring(0, historyMaxChars));
                      historyCharCount = historyMaxChars;
                  }

                  // Update character count display
                  document.getElementById("historyCharCount").innerText = `${historyCharCount}/${historyMaxChars} characters`;
              });
          </script>
        </div>
        <div class="tab-pane fade" id="companyDetails">
          <div class="input-group">
            <span class="input-group-text d-flex align-items-center">
              <i class='bx bx-briefcase'></i>
            </span>
            <input type="text" class="form-control" placeholder="Enter Industry" />
          </div>

          <div class="input-group mt-2">
            <span class="input-group-text d-flex align-items-center">
              <i class='bx bx-building'></i>
            </span>
            <input type="text" class="form-control" placeholder="Enter Business Type" />
          </div>

          <div class="input-group mt-2">
            <span class="input-group-text d-flex align-items-center">
              <i class='bx bx-expand'></i>
            </span>
            <input type="text" class="form-control" placeholder="Size Of Company" />
          </div>

          <div class="input-group mt-2">
            <span class="input-group-text d-flex align-items-center">
              <i class='bx bx-group'></i>
            </span>
            <input type="text" class="form-control" placeholder="Enter Employee Count" />
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer text-center">
      <button type="button" class="btn btn-success">Update</button>
    </div>
  </div>

  <!-- Contact Information Card -->
  <div class="card">
    <div class="card-header display-6">Contact Information</div>
    <!-- Tab Navigation for Contact Information -->
    <ul class="nav nav-tabs d-flex w-100" id="contactTabs">
        <li class="nav-item flex-grow-1">
            <button class="nav-link active w-100 text-center" data-bs-toggle="tab" data-bs-target="#address" type="button">Address</button>
        </li>
        <li class="nav-item flex-grow-1">
            <button class="nav-link w-100 text-center" data-bs-toggle="tab" data-bs-target="#phone" type="button">Phone Number</button>
        </li>
        <li class="nav-item flex-grow-1">
            <button class="nav-link w-100 text-center" data-bs-toggle="tab" data-bs-target="#email" type="button">Email</button>
        </li>
        <li class="nav-item flex-grow-1">
            <button class="nav-link w-100 text-center" data-bs-toggle="tab" data-bs-target="#website" type="button">Website</button>
        </li>
    </ul>
    <div class="card-body">
      <!-- Tab Content -->
      <div class="tab-content">
        <div class="tab-pane fade show active" id="address">
          <div class="input-group">
            <span class="input-group-text"><i class='bx bx-map'></i></span>
            <input type="text" class="form-control" placeholder="Address" />
          </div>
        </div>

        <div class="tab-pane fade" id="phone">
          <div class="input-group">
            <span class="input-group-text"><i class='bx bx-phone'></i></span>
            <input type="number" class="form-control" placeholder="Phone Number" />
          </div>
        </div>

        <div class="tab-pane fade" id="email">
          <div class="input-group">
            <span class="input-group-text"><i class='bx bx-envelope'></i></span>
            <input type="email" class="form-control" placeholder="Enter your email..." aria-describedby="emailHelp" />
          </div>
        </div>

        <div class="tab-pane fade" id="website">
          <div class="input-group">
            <span class="input-group-text"><i class='bx bx-globe'></i></span>
            <input type="text" class="form-control" placeholder="Website" />
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer text-center">
      <button type="button" class="btn btn-success">Update</button>
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
          <div class="header-inputs">
            <textarea id="missionEditor" placeholder="Mission"></textarea>
            <p id="missionCharCount">0/200 characters</p>
            <!-- SimpleMDE JavaScript -->
            <script>
                const missionMaxChars = 200;

                // Initialize SimpleMDE
                var missionSimplemde = new SimpleMDE({ 
                    element: document.getElementById("missionEditor"),
                    toolbar: [
                        "bold", "italic", "|",
                        "quote", 
                        {
                            name: "clear",
                            action: function customFunction(editor){
                                editor.value(""); // Clear the editor content
                            },
                            className: "fa fa-eraser", // Icon for the button
                            title: "Clear Editor",
                        }, "|",
                        "preview", "side-by-side", "fullscreen"
                    ]
                });

                // Update character count and enforce limit
                missionSimplemde.codemirror.on("change", function() {
                    let missionContent = missionSimplemde.value();
                    let missionCharCount = missionContent.length;

                    // Check if the character limit is exceeded
                    if (missionCharCount > missionMaxChars) {
                        // Trim content to maxChars if limit exceeded
                        missionSimplemde.value(missionContent.substring(0, missionMaxChars));
                        missionCharCount = missionMaxChars;
                    }

                    // Update character count display
                    document.getElementById("missionCharCount").innerText = `${missionCharCount}/${missionMaxChars} characters`;
                });
            </script>
          </div>
        </div>
        <!-- Vision Tab -->
        <div class="tab-pane fade" id="vision">
          <div class="header-inputs">
            <textarea id="visionEditor" placeholder="Vision"></textarea>
            <p id="visionCharCount">0/200 characters</p>

            <!-- SimpleMDE JavaScript -->
            <script>
                const visionMaxChars = 200;

                // Initialize SimpleMDE for Vision Editor
                var visionSimpleMde = new SimpleMDE({ 
                    element: document.getElementById("visionEditor"),
                    toolbar: [
                        "bold", "italic", "|",
                        "quote", 
                        {
                            name: "clear",
                            action: function customFunction(editor){
                                editor.value(""); // Clear the editor content
                            },
                            className: "fa fa-eraser", // Icon for the button
                            title: "Clear Editor",
                        }, "|",
                        "preview", "side-by-side", "fullscreen"
                    ]
                });

                // Update character count and enforce limit
                visionSimpleMde.codemirror.on("change", function() {
                    let visionContent = visionSimpleMde.value();
                    let visionCharCount = visionContent.length;

                    // Check if the character limit is exceeded
                    if (visionCharCount > visionMaxChars) {
                        // Trim content to maxChars if limit exceeded
                        visionSimpleMde.value(visionContent.substring(0, visionMaxChars));
                        visionCharCount = visionMaxChars;
                    }

                    // Update character count display
                    document.getElementById("visionCharCount").innerText = `${visionCharCount}/${visionMaxChars} characters`;
                });
            </script>
          </div>
        </div>
        <!-- Values Tab -->
        <div class="tab-pane fade" id="values">
          <div class="header-inputs">
            <textarea id="valuesEditor" placeholder="Values"></textarea>
            <p id="valuesCharCount">0/200 characters</p>

            <!-- SimpleMDE JavaScript -->
            <script>
                const valuesMaxChars = 200;

                // Initialize SimpleMDE for Values Editor
                var valuesSimpleMde = new SimpleMDE({ 
                    element: document.getElementById("valuesEditor"),
                    toolbar: [
                        "bold", "italic", "|",
                        "quote", 
                        {
                            name: "clear",
                            action: function customFunction(editor){
                                editor.value(""); // Clear the editor content
                            },
                            className: "fa fa-eraser", // Icon for the button
                            title: "Clear Editor",
                        }, "|",
                        "preview", "side-by-side", "fullscreen"
                    ]
                });

                // Update character count and enforce limit
                valuesSimpleMde.codemirror.on("change", function() {
                    let valuesContent = valuesSimpleMde.value();
                    let valuesCharCount = valuesContent.length;

                    // Check if the character limit is exceeded
                    if (valuesCharCount > valuesMaxChars) {
                        // Trim content to maxChars if limit exceeded
                        valuesSimpleMde.value(valuesContent.substring(0, valuesMaxChars));
                        valuesCharCount = valuesMaxChars;
                    }

                    // Update character count display
                    document.getElementById("valuesCharCount").innerText = `${valuesCharCount}/${valuesMaxChars} characters`;
                });
            </script>
          </div>
          <button type="button" class="btn btn-secondary btn-add-header d-block mx-auto" data-placeholder="Values">Add Header</button>
        </div>
      </div>
    </div>
    <div class="card-footer text-center">
      <button type="button" class="btn btn-success">Update</button>
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
        <div class="tab-pane fade show active" id="complianceHistory">
          <div class="header-inputs">
            <textarea id="policiesEditor" placeholder="Policies"></textarea>
            <p id="policiesCharCount">0/200 characters</p>

            <!-- SimpleMDE JavaScript -->
            <script>
                const policiesMaxChars = 200;

                // Initialize SimpleMDE for Policies Editor
                var policiesSimpleMde = new SimpleMDE({ 
                    element: document.getElementById("policiesEditor"),
                    toolbar: [
                        "bold", "italic", "|",
                        "quote", 
                        {
                            name: "clear",
                            action: function customFunction(editor){
                                editor.value(""); // Clear the editor content
                            },
                            className: "fa fa-eraser", // Icon for the button
                            title: "Clear Editor",
                        }, "|",
                        "preview", "side-by-side", "fullscreen"
                    ]
                });

                // Update character count and enforce limit
                policiesSimpleMde.codemirror.on("change", function() {
                    let policiesContent = policiesSimpleMde.value();
                    let policiesCharCount = policiesContent.length;

                    // Check if the character limit is exceeded
                    if (policiesCharCount > policiesMaxChars) {
                        // Trim content to maxChars if limit exceeded
                        policiesSimpleMde.value(policiesContent.substring(0, policiesMaxChars));
                        policiesCharCount = policiesMaxChars;
                    }

                    // Update character count display
                    document.getElementById("policiesCharCount").innerText = `${policiesCharCount}/${policiesMaxChars} characters`;
                });
            </script>
          </div>
        </div>
        <div class="tab-pane fade" id="complianceDetails">
          <div class="header-inputs">
            <textarea id="complianceEditor" placeholder="Compliance"></textarea>
            <p id="complianceCharCount">0/200 characters</p>

            <!-- SimpleMDE JavaScript -->
            <script>
                const complianceMaxChars = 200;

                // Initialize SimpleMDE for Compliance Editor
                var complianceSimpleMde = new SimpleMDE({ 
                    element: document.getElementById("complianceEditor"),
                    toolbar: [
                        "bold", "italic", "|",
                        "quote", 
                        {
                            name: "clear",
                            action: function customFunction(editor){
                                editor.value(""); // Clear the editor content
                            },
                            className: "fa fa-eraser", // Icon for the button
                            title: "Clear Editor",
                        }, "|",
                        "preview", "side-by-side", "fullscreen"
                    ]
                });

                // Update character count and enforce limit
                complianceSimpleMde.codemirror.on("change", function() {
                    let complianceContent = complianceSimpleMde.value();
                    let complianceCharCount = complianceContent.length;

                    // Check if the character limit is exceeded
                    if (complianceCharCount > complianceMaxChars) {
                        // Trim content to maxChars if limit exceeded
                        complianceSimpleMde.value(complianceContent.substring(0, complianceMaxChars));
                        complianceCharCount = complianceMaxChars;
                    }

                    // Update character count display
                    document.getElementById("complianceCharCount").innerText = `${complianceCharCount}/${complianceMaxChars} characters`;
                });
            </script>
          </div>
        </div>
        <div class="tab-pane fade" id="complianceNotes">
          <div class="header-inputs">
            <textarea id="importantNotesEditor" placeholder="Important Notes"></textarea>
            <p id="importantNotesCharCount">0/200 characters</p>

            <!-- SimpleMDE JavaScript -->
            <script>
                const importantNotesMaxChars = 200;

                // Initialize SimpleMDE for Important Notes Editor
                var importantNotesSimpleMde = new SimpleMDE({ 
                    element: document.getElementById("importantNotesEditor"),
                    toolbar: [
                        "bold", "italic", "|",
                        "quote", 
                        {
                            name: "clear",
                            action: function customFunction(editor){
                                editor.value(""); // Clear the editor content
                            },
                            className: "fa fa-eraser", // Icon for the button
                            title: "Clear Editor",
                        }, "|",
                        "preview", "side-by-side", "fullscreen"
                    ]
                });

                // Update character count and enforce limit
                importantNotesSimpleMde.codemirror.on("change", function() {
                    let importantNotesContent = importantNotesSimpleMde.value();
                    let importantNotesCharCount = importantNotesContent.length;

                    // Check if the character limit is exceeded
                    if (importantNotesCharCount > importantNotesMaxChars) {
                        // Trim content to maxChars if limit exceeded
                        importantNotesSimpleMde.value(importantNotesContent.substring(0, importantNotesMaxChars));
                        importantNotesCharCount = importantNotesMaxChars;
                    }

                    // Update character count display
                    document.getElementById("importantNotesCharCount").innerText = `${importantNotesCharCount}/${importantNotesMaxChars} characters`;
                });
            </script>
          </div>
        </div>
      </div>
    </div>
    <div class="card-footer text-center">
      <button type="button" class="btn btn-success">Update</button>
    </div>
  </div>
</div>

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
