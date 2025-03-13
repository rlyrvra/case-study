function fetchAllSettings() {
    var loadingSpinner = document.getElementById("loadingSpinner");
    loadingSpinner.classList.remove("visually-hidden");

    $.ajax({
        url: "settings/modules/company-settings-api",
        type: "POST",
        data: {
            action: "fetchAll",
        },
        success: function (response) {
            loadingSpinner.classList.add("visually-hidden");
            $("#settings-table").html(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        },
    });
}

function updateSetting(button){
    const settingValues = getSettingValues(button);
    $.ajax({
        url: "settings/modules/company-settings-api",
        type: "POST",
        data: {
            action: "update",
            settings: settingValues
        },
        success: function (response) {
            $("#response-test").html(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        },
    });
}