function fetchEmployeeLeaves(){
    const employeeId = document.getElementById('select_employee').value;
    
    $.ajax({
        url: 'leaves/modules/assign-leaves-api',
        type: 'POST',
        data: {
            action: 'fetchEmployeeLeave',
            employee_id: employeeId,
        },
        success: function(response) {
            $('#employee-leave-credits-table').html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function assignLeaves(selectedLeavesTypes){
    if (!selectedLeavesTypes || selectedLeavesTypes.length === 0) {
        showNoSelectedLeaves();
        return;
    }
    const employment_type = document.getElementById('employment-type').value;
    $.ajax({
        url: 'leaves/modules/assign-leaves-api',
        type: 'POST',
        data: {
            action: 'assignLeaves',
            employment_type: employment_type,
            selected_leaves: selectedLeavesTypes
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchEmployeeLeaves();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function deleteEmployeeLeave(button){
    const leaveEntitlementId = button.getAttribute("data-id");
    
    $.ajax({
        url: 'leaves/modules/assign-leaves-api',
        type: 'POST',
        data: {
            action: 'deleteEmployeeLeave',
            leave_entitlement_id: leaveEntitlementId,
        },
        success: function(response) {
            $('#response-test').html(response);
            fetchEmployeeLeaves();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

async function checkEmploymentTypeLeaves(){
    const checkboxes = document.querySelectorAll('#leaveEntitlementModal #leaveTableBody input[type="checkbox"]');
    checkboxes.forEach(checkbox => checkbox.checked = false);

    const employmentType = document.getElementById('employment-type').value;
    if(!employmentType){
        return;
    }
    const employmentTypeLeaves = await fetchSelectedEmploymentType(employmentType);
    if (!employmentTypeLeaves || employmentTypeLeaves.length === 0) {
        return;
    }
    
    employmentTypeLeaves.forEach(employmentTypeLeave => {
        const checkbox = document.querySelector(`#leaveEntitlementModal #leaveTableBody input[type="checkbox"][id="${employmentTypeLeave.leave_type_id}"]`);
        if(!checkbox){
            return;
        }
        checkbox.checked = true;
    });
    
}

async function fetchSelectedEmploymentType(employmentType){
    try{
        const response = await fetch(
            'leaves/modules/assign-leaves-api',{
                method: 'POST',
                headers: {
                    'Accept': '*/*',
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: new URLSearchParams({
                    action: 'fetchEmploymentTypeLeaves',
                    employmentType: employmentType
                })
            }
            
        );
        if(!response.ok){
            console.error(`HTTP error! Status: ${response.status}`);
        }
        const employmentTypeLeaves = await response.json();
        return employmentTypeLeaves;
    } catch (error) {
        console.error('Fetch error:', error);
        return null; // Return null in case of an error
    }
}