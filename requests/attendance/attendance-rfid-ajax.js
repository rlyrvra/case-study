function handleRFID(rfid, date){
    var type;
    document.querySelectorAll('input[name="type"]').forEach((radio) => {
        type = document.querySelector('input[name="type"]:checked').value;
    });

    const data = {
        type: type,
        rfid: rfid,
        date: date
    }
    showSpinnerLoader();
    $.ajax({
        url: 'requests/attendance/attendance-rfid-api',
        type: 'POST',
        data: {
            action: 'handleRfid',
            type: type,
            rfid: rfid,
            date: date
        },
        success: function(response) {
            closeSpinnerLoader();
            $('#response-test').html(response);
            fetchAllAttendance();
            fetchAllBreaks();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

$(document).ready(function() {
    fetchAllAttendance();

});

function fetchAllAttendance(){
    $.ajax({
        url: 'requests/attendance/attendance-rfid-api',
        type: 'POST',
        data: {
            action: 'fetchAllAttendance'
        },
        success: function(response) {
            $('#attendance-table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

$(document).ready(function() {
    fetchAllBreaks();

});

function fetchAllBreaks(){
    $.ajax({
        url: 'requests/attendance/attendance-rfid-api',
        type: 'POST',
        data: {
            action: 'fetchAllBreaks'
        },
        success: function(response) {
            $('#break-table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}