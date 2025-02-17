function fetchAllBreakTypes(page = 1){
    $.ajax({
        url: 'work-schedules/modules/work-schedules-break-api',
        type: 'POST',
        data: {
            action: 'fetchAll',
        },
        success: function(response) {
            $('#breaks-create-table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function createBreaks(){
    const breakName = document.getElementById("create_break_name").value.trim();
    const breakPaid = document.getElementById("create_paid").value.trim();
    const breakDuration = document.getElementById("create_duration_in_minutes").value.trim();

    if(!validateInputs(breakName, breakPaid, breakDuration)){
        return;
    }

    const breakTypeData = {
        name: breakName,
        is_paid: breakPaid,
        duration: breakDuration
    };

    $.ajax({
        url: 'work-schedules/modules/work-schedules-break-api',
        type: 'POST',
        data: {
            action: 'create',
            breakTypeData: breakTypeData
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchAllBreakTypes();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });

    rowAdded = false;
}

function updateBreakType(button){
    const row = button.closest('tr');  // Get the closest row
    const token = button.getAttribute('data-token');
    const updateName = row.querySelector('#update_name').value;
    const updateDuration = row.querySelector('#update_duration').value;
    const updatePaid = row.querySelector('#update_paid').value;
    const breakTypeData = {
        id: token,
        name: updateName,
        is_paid: updatePaid,
        duration: updateDuration
    };
    if(!validateInputs(updateName, updatePaid, updateDuration)){
        return;
    }
    

    $.ajax({
        url: 'work-schedules/modules/work-schedules-break-api',
        type: 'POST',
        data: {
            action: 'update',
            breakTypeData: breakTypeData
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchAllBreakTypes();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });

    rowAdded = false;
}

function deleteBreakType(button){
    const token = button.getAttribute('data-token');
    $.ajax({
        url: 'work-schedules/modules/work-schedules-break-api',
        type: 'POST',
        data: {
            action: 'delete',
            token: token
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchAllBreakTypes();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
    rowAdded = false;
}