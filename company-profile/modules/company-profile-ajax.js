function fetchAllInfo() {
    $.ajax({
        url: "company-profile/modules/company-profile-api",
        type: "POST",
        data: {
            action: "fetchAll"
        },
        success: function (response) {
            $("#response-test").html(response);
            console.log("success");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        },
    });
}

function updateInfo(){
    const fileInput = document.getElementById("company_picture_file");
    if (!fileInput || fileInput.files.length === 0) {
        console.log("No file selected.");
        return;
    }


    const name = document.getElementById("company_name").value;
    const date_established = document.getElementById("date_established").value;
    const historyValue = historySimpleMde.value();

    const industry = document.getElementById("industry").value;
    const business_type = document.getElementById("business_type").value;
    const company_size = document.getElementById("company_size").value;
    const employee_count = document.getElementById("employee_count").value;

    const address = document.getElementById("addressInput").value;
    const phone = document.getElementById("phoneInput").value;
    const emailInput = document.getElementById("emailInput").value;
    const websiteInput = document.getElementById("websiteInput").value;

    const missionValue = missionSimplemde.value();
    const visionValue = visionSimpleMde.value();
    const valuesValue = valuesSimpleMde.value();

    const policiesValue = policiesSimpleMde.value();
    const complianceValue = complianceSimpleMde.value();
    const notesValue = importantNotesSimpleMde.value();
    
    const companyProfile = {
        name: name,
        date_established: date_established,
        history: historyValue,
        industry: industry,
        business_type: business_type,
        company_size: company_size,
        employee_count: employee_count,
        address: address,
        phone: phone,
        email: emailInput,
        website: websiteInput,
        mission: missionValue,
        vision: visionValue,
        company_values: valuesValue,
        policies: policiesValue,
        compliance: complianceValue,
        notes: notesValue
    };
    
    console.log(companyProfile);

    const formData = new FormData();
    formData.append("action", "update"); // Action
    formData.append("company_profile", companyProfile); // Company_profile
    formData.append("company_logo", fileInput.files[0]); // File

    $.ajax({
        url: "company-profile/modules/company-profile-api",
        type: "POST",
        processData: false, // Prevent jQuery from converting the data
        contentType: false, // Let the browser set the `Content-Type` automatically
        data: formData,
        success: function (response) {
            $("#response-test").html(response);
            console.log("success");
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        },
    });
}
