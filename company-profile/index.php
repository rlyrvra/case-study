<?php require_once __DIR__ . '/../includes/security-headers.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- SimpleMDE for text editors -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
    <script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
    <style>
        .header-section { 
        background-color: #d4edda; 
        padding: 10px; 
        }
        .section-title { 
        font-weight: bold; 
        }
        .section { 
        padding: 20px; 
        }
        .full-width-btn-group{
            width: 100%;
        }
        #detailsSection, #historySection{
            background-color: #CADDCB;
        }
        #addressSection, #phoneSection, #emailSection, #webSection{
            background-color: #CADDCB;
        }
        #missionSection, #visionSection, #valuesSection{
            background-color: #CADDCB;
        }
        #policiesSection, #complianceSection, #notesSection{
            background-color: #CADDCB;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <!-- Company Name and Date -->
    <div class="d-flex justify-content-between align-items-center">
        <input type="text" class="form-control mb-2" placeholder="Enter company name">
        <input type="date" class="form-control" value="2000-10-19" style="max-width: 200px;">
        <button class="btn btn-outline-secondary">Upload</button>
    </div>

    <!-- Company Information with Details and History Tabs -->
    <div class="section">
        <div class="header-section">
        <h5 class="section-title">Company Information</h5>
        </div>
        <div class="btn-group mt-3 full-width-btn-group" role="group" aria-label="Company Information Toggle">
            <button type="button" id="detailsBtn" class="btn btn-primary" onclick="showCompanyDetails('detailsSection', 'detailsBtn')">Details</button>
            <button type="button" id="historyBtn" class="btn btn-outline-secondary" onclick="showCompanyDetails('historySection', 'historyBtn')">History</button>
        </div>

        <!-- Details Section (Default) -->
        <div id="detailsSection" class="container p-5">
            <input type="text" class="form-control mb-2" placeholder="Enter location" required id="infoLocation">
            <input type="text" class="form-control mb-2" placeholder="Enter industry" required id="infoIndustry">
            <input type="text" class="form-control mb-2" placeholder="Enter business type" required id="infoBusinessType">
            <input type="number" class="form-control mb-2" placeholder="Enter size of company" required id="infoSizeOfCompany">
        </div>

        <!-- History Section (Hidden by Default) -->
        <div id="historySection" class="container p-5" style="display: none;">
            <textarea id="historyEditor"></textarea>
            <p id="historyCharCount">0/600 characters</p>
            <!-- SimpleMDE JavaScript -->
            <script>
                const historyMaxChars = 600;

                // Initialize SimpleMDE
                var historySimplemde = new SimpleMDE({ 
                    element: document.getElementById("historyEditor"),
                    toolbar: [
                        "bold", "italic", "heading", "|",
                        "quote", 
                        {
                            name: "clear",
                            action: function customFunction(editor){
                                editor.value(""); // Clear the editor content
                            },
                            className: "fa fa-eraser", // Icon for the button
                            title: "Clear Editor",
                        },
                        {
                            name: "center",
                            action: function customFunction(editor) {
                                const cm = editor.codemirror;
                                const selectedText = cm.getSelection();
                                cm.replaceSelection(`<div style="text-align: center;">${selectedText}</div>`);
                            },
                            className: "fa fa-align-center",
                            title: "Center Align",
                        },
                        {
                            name: "justify",
                            action: function customFunction(editor) {
                                const cm = editor.codemirror;
                                const selectedText = cm.getSelection();
                                cm.replaceSelection(`<div style="text-align: justify;">${selectedText}</div>`);
                            },
                            className: "fa fa-align-justify",
                            title: "Justify Align",
                        }, "unordered-list", "ordered-list", "|",
                        "preview", "side-by-side", "fullscreen"
                    ]
                });

                // Update character count and enforce limit
                historySimplemde.codemirror.on("change", function() {
                    let historyContent = historySimplemde.value();
                    let historyCharCount = historyContent.length;

                    // Check if the character limit is exceeded
                    if (historyCharCount > historyMaxChars) {
                        // Trim content to maxChars if limit exceeded
                        historySimplemde.value(historyContent.substring(0, historyMaxChars));
                        historyCharCount = historyMaxChars;
                    }

                    // Update character count display
                    document.getElementById("historyCharCount").innerText = `${historyCharCount}/${historyMaxChars} characters`;
                });
            </script>
        </div>
        <button class="btn btn-primary mt-2" id="infoConfirm">Update/Confirm</button>
        <script>
            //Company Information AJAX handler
            $(document).ready(function() {
            $('#infoConfirm').click(function(e) {
                

                // Collect form data
                var infoLocation = $("#infoLocation").val(); // Ensure # is present
                var infoIndustry = $("#infoIndustry").val();
                var infoBusinessType = $("#infoBusinessType").val();
                var infoSizeOfCompany = $("#infoSizeOfCompany").val();
                var infoHistory = historySimplemde.value();
                //validation of data
                if(
                    infoLocation.length <= 8
                ){
                    return;
                }
                

                // Send an AJAX request to JobTitleAPI.php to fetch table data
                $.ajax({
                    url: 'api/getCompanyInfo.php', // URL should be here
                    type: 'POST',
                    data: {
                        action: 'updateInfo',
                        company_info: {
                            location: infoLocation,
                            industry: infoIndustry,
                            business_type: infoBusinessType,
                            size: infoSizeOfCompany,
                            history: infoHistory
                        },
                    },
                    success: function(response) {
                        // Insert the HTML response
                        $('#response').html(response);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("AJAX Error: " + textStatus + ": " + errorThrown);
                    }
                });
                console.log(infoLocation + infoIndustry + infoBusinessType + infoSizeOfCompany);
                console.log(infoHistory);
            });
        });
        </script>
        <div id="response">
        </div>
    </div>

    <script>
    const informationSections = ["detailsSection", "historySection"];
    const informationButtons = ["historyBtn", "detailsBtn"];
    // Function to show Details section and hide History section
    function showCompanyDetails(currentSection, currentButton){
        informationSections.forEach(section => {
            document.getElementById(section).style.display = "none";
        });
        informationButtons.forEach(button => {
            document.getElementById(button).classList.add("btn-outline-secondary");
            document.getElementById(button).classList.remove("btn-primary");
        });
        document.getElementById(currentSection).style.display = "block";
        document.getElementById(currentButton).classList.add("btn-primary");
        document.getElementById(currentButton).classList.remove("btn-outline-secondary");
    }
    </script>

    <!-- Contact Information -->
    <div class="section">
        <div class="header-section">
        <h5 class="section-title">Contact Information</h5>
        </div>
        <div class="btn-group mt-3 full-width-btn-group" role="group" aria-label="Company Information Toggle">
            <button type="button" id="addressBtn" class="btn btn-primary" onclick="showContactInformation('addressSection', 'addressBtn')">Details</button>
            <button type="button" id="phoneBtn" class="btn btn-outline-secondary" onclick="showContactInformation('phoneSection', 'phoneBtn')">Phone</button>
            <button type="button" id="emailBtn" class="btn btn-outline-secondary" onclick="showContactInformation('emailSection', 'emailBtn')">Email</button>
            <button type="button" id="webBtn" class="btn btn-outline-secondary" onclick="showContactInformation('webSection', 'webBtn')">Website</button>
        </div>
        <!-- Address Section (Default) -->
        <div id="addressSection" class="container p-5">
            <textarea class="form-control mt-2" rows="2" placeholder="Enter address here"></textarea>
        </div>
        <!-- Phone Number Section (Hidden By Default) -->
        <div id="phoneSection" class="container p-5" style="display: none;">
            <textarea class="form-control mt-2" rows="2" placeholder="Enter phone number here"></textarea>
        </div>
        <!-- Email Section (Hidden By Default) -->
        <div id="emailSection" class="container p-5" style="display: none;">
            <textarea class="form-control mt-2" rows="2" placeholder="Enter email here"></textarea>
        </div>
        <!-- Website Section (Hidden By Default) -->
        <div id="webSection" class="container p-5" style="display: none;">
            <textarea class="form-control mt-2" rows="2" placeholder="Enter website here"></textarea>
        </div>
        <button class="btn btn-primary mt-2">Update/Confirm</button>
    </div>

    <script>
    const contactSections = ["addressSection", "phoneSection", "emailSection", "webSection"];
    const contactButtons = ["addressBtn", "phoneBtn", "emailBtn", "webBtn"];
    // Function to show Contact Info Sections
    function showContactInformation(currentSection, currentButton){
        contactSections.forEach(section => {
            document.getElementById(section).style.display = "none";
        });
        contactButtons.forEach(button => {
            document.getElementById(button).classList.add("btn-outline-secondary");
            document.getElementById(button).classList.remove("btn-primary");
        });
        document.getElementById(currentSection).style.display = "block";
        document.getElementById(currentButton).classList.add("btn-primary");
        document.getElementById(currentButton).classList.remove("btn-outline-secondary");
    }
    </script>

    <!-- Company Principles -->
    <div class="section">
        <div class="header-section">
        <h5 class="section-title">Company Principles</h5>
        </div>
        <div class="btn-group mt-3 full-width-btn-group" role="group" aria-label="Company Information Toggle">
            <button type="button" id="missionBtn" class="btn btn-primary" onclick="showCompanyPrinciples('missionSection', 'missionBtn')">Mission</button>
            <button type="button" id="visionBtn" class="btn btn-outline-secondary" onclick="showCompanyPrinciples('visionSection', 'visionBtn')">Vision</button>
            <button type="button" id="valuesBtn" class="btn btn-outline-secondary" onclick="showCompanyPrinciples('valuesSection', 'valuesBtn')">Values</button>
        </div>
        
        <!-- Mission Section (Default) -->
        <div id="missionSection" class="container p-5">
            <textarea id="missionEditor"></textarea>
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
        <!-- Vision Section (Hidden By Default) -->
        <div id="visionSection" class="container p-5" style="display: none;">
            <textarea id="visionEditor"></textarea>
            <p id="visionCharCount">0/200 characters</p>
            <!-- SimpleMDE JavaScript -->
            <script>
                const visionMaxChars = 200;

                // Initialize SimpleMDE
                var visionSimplemde = new SimpleMDE({ 
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
                visionSimplemde.codemirror.on("change", function() {
                    let visionContent = visionSimplemde.value();
                    let visionCharCount = visionContent.length;

                    // Check if the character limit is exceeded
                    if (visionCharCount > visionMaxChars) {
                        // Trim content to maxChars if limit exceeded
                        visionSimplemde.value(visionContent.substring(0, visionMaxChars));
                        visionCharCount = visionMaxChars;
                    }

                    // Update character count display
                    document.getElementById("visionCharCount").innerText = `${visionCharCount}/${visionMaxChars} characters`;
                });
            </script>
        </div>

        <!-- Values Section (Hidden By Default) -->
        <div id="valuesSection" class="container p-5" style="display: none;">
            <textarea id="valuesEditor"></textarea>
            <p id="valuesCharCount">0/200 characters</p>
            <!-- SimpleMDE JavaScript -->
            <script>
                const valuesMaxChars = 200;

                // Initialize SimpleMDE
                var valuesSimplemde = new SimpleMDE({ 
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
                valuesSimplemde.codemirror.on("change", function() {
                    let valuesContent = valuesSimplemde.value();
                    let valuesCharCount = valuesContent.length;

                    // Check if the character limit is exceeded
                    if (valuesCharCount > valuesMaxChars) {
                        // Trim content to maxChars if limit exceeded
                        valuesSimplemde.value(valuesContent.substring(0, valuesMaxChars));
                        valuesCharCount = valuesMaxChars;
                    }

                    // Update character count display
                    document.getElementById("valuesCharCount").innerText = `${valuesCharCount}/${valuesMaxChars} characters`;
                });
            </script>
        </div>

        <button class="btn btn-primary mt-2">Update/Confirm</button>
    </div>

    <script>
    const principlesSections = ["missionSection", "visionSection", "valuesSection"];
    const principlesButtons = ["missionBtn", "visionBtn", "valuesBtn"];
    // Function to show Contact Info Sections
    function showCompanyPrinciples(currentSection, currentButton){
        principlesSections.forEach(section => {
            document.getElementById(section).style.display = "none";
        });
        principlesButtons.forEach(button => {
            document.getElementById(button).classList.add("btn-outline-secondary");
            document.getElementById(button).classList.remove("btn-primary");
        });
        document.getElementById(currentSection).style.display = "block";
        document.getElementById(currentButton).classList.add("btn-primary");
        document.getElementById(currentButton).classList.remove("btn-outline-secondary");
    }
    </script>

    <!-- Compliance and Policies -->
    <div class="section">
        <div class="header-section">
        <h5 class="section-title">Compliance and Policies</h5>
        </div>
        <div class="btn-group mt-3 full-width-btn-group" role="group" aria-label="Company Information Toggle">
            <button type="button" id="policiesBtn" class="btn btn-primary" onclick="showCompliance('policiesSection', 'policiesBtn')">HR Policies Overview</button>
            <button type="button" id="complianceBtn" class="btn btn-outline-secondary" onclick="showCompliance('complianceSection', 'complianceBtn')">Compliance Requirements</button>
            <button type="button" id="notesBtn" class="btn btn-outline-secondary" onclick="showCompliance('notesSection', 'notesBtn')">Important Notes</button>
        </div>
        <!-- Policies Section (Default) -->
        <div id="policiesSection" class="container p-5">
            
        </div>
        <!-- Compliance Section (Hidden By Default) -->
        <div id="complianceSection" class="container p-5" style="display: none;">
            
        </div>
        <!-- Important Notes Section (Hidden By Default) -->
        <div id="notesSection" class="container p-5" style="display: none;">
            
        </div>
        
        <button class="btn btn-primary mt-2">Update/Confirm</button>
    </div>


    <script>
    const complianceSections = ["policiesSection", "complianceSection", "notesSection"];
    const complianceButtons = ["policiesBtn", "complianceBtn", "notesBtn"];
    // Function to show Contact Info Sections
    function showCompliance(currentSection, currentButton){
        complianceSections.forEach(section => {
            document.getElementById(section).style.display = "none";
        });
        complianceButtons.forEach(button => {
            document.getElementById(button).classList.add("btn-outline-secondary");
            document.getElementById(button).classList.remove("btn-primary");
        });
        document.getElementById(currentSection).style.display = "block";
        document.getElementById(currentButton).classList.add("btn-primary");
        document.getElementById(currentButton).classList.remove("btn-outline-secondary");
    }
    </script>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>