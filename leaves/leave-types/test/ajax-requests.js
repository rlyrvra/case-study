function fetchAll(){
    $.ajax({
        url: 'apiTest.php',
        method: 'POST',
        data: {
            action: 'fetchAll'
        },
        dataType: 'html',
        success(response) {
            $('#leave-types-table').html(response);
        },
        error(xhr, status, error) {
            console.error("Error fetching departments:", error);
        }
    });
}

function createLeaveType(){
    const leaveTypeName = document.getElementById('name').value;
    const maxNumber = document.getElementById('maximum_number_of_days').value;
    const isPaid = document.getElementById('is_paid').checked;
    const description = document.getElementById('description').value;
    const status = document.getElementById('status').value;

    const leaveTypeData = {
        name: leaveTypeName,
        maximum_number_of_days: maxNumber,
        is_paid: isPaid,
        description: description,
        status: status
    };

    console.log(leaveTypeData);

    $.ajax({
        url: 'apiTest.php',
        method: 'POST',
        data: {
            action: 'create',
            leave_type: leaveTypeData
        },
        success: function(response) {
            fetchAll();
            document.getElementById('leave_type_form').reset();
        },
        error(xhr, status, error) {
            console.error("Error creating department:", error);
        }
    });
}

function confirmDeleteLeaveType(button) {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to delete this leave type?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
        deleteLeaveType(button);
        Swal.fire(
            'Deleted!',
            'The leave type has been deleted.',
            'success'
        );
        }
    });
}

function showSuccessAlert() {
    Swal.fire({
        title: 'Success!',
        text: 'Updated successfully.',
        icon: 'success',
        timer: 2000,
        confirmButtonText: 'OK'
    });
}

function deleteLeaveType(button) {
    const row = button.closest('tr');  // Get the closest row
    const leaveTypeData = {
        token: row.getAttribute('data-id'),
    };
    $.ajax({
        url: 'apiTest.php',
        method: 'POST',
        data: {
            action: 'delete',
            md5_id: leaveTypeData.token
        },
        success: function(response) {
            
            fetchAll();
        },
        error(xhr, status, error) {
            console.error("Error deleting leave type:", error);
        }
    });
}

function updateLeaveType(button){
    const token = button.getAttribute('data-token');

    const leaveTypeName = document.getElementById('updateName').value;
    const maxNumber = document.getElementById('updateMaximum_number_of_days').value;
    const isPaid = document.getElementById('updateIs_paid').checked;
    const description = document.getElementById('updateDescription').value;
    const status = document.getElementById('updateStatus').value;
    console.log(`Leave Type Name: ${leaveTypeName}, 
        Max Number of Days: ${maxNumber}, 
        Is Paid: ${isPaid}, 
        Description: ${description}, 
        Status: ${status}`);
    $.ajax({
        url: 'apiTest.php',
        type: 'POST',
        data: {
            action: 'update',
            leave_type: {
                md5_id: token,
                name: leaveTypeName,
                maxNumberOfDays: maxNumber,
                isPaid: isPaid,
                description: description,
                status: status
            }
        },
        success: function(response) {
            $('#responseTest').html(response);
            showSuccessAlert();
            fetchAll();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        }
    });
}

function updateLeaveTypeClick(button){
    const row = button.closest('tr');  // Get the closest row
    const leaveTypeData = {
        token: row.getAttribute('data-id'),
        name: row.getAttribute('data-name'),
        maxNumberOfDays: row.getAttribute('data-maximum-number-of-days'),
        isPaid: row.getAttribute('data-is-paid'),
        description: row.getAttribute('data-description'),
        status: row.getAttribute('data-status')
    };

    const txtLeaveTypeName = document.getElementById('updateName');
    const txtMaxNumber = document.getElementById('updateMaximum_number_of_days');
    const cbIsPaid = document.getElementById('updateIs_paid');
    const txtDescription = document.getElementById('updateDescription');
    const txtStatus = document.getElementById('updateStatus');
    const btnUpdateLeaveType = document.getElementById('updateLeaveTypeBtn');

    txtLeaveTypeName.value = leaveTypeData.name;
    txtMaxNumber.value = leaveTypeData.maxNumberOfDays;
    cbIsPaid.checked = leaveTypeData.isPaid; 
    txtDescription.value = leaveTypeData.description;
    txtStatus.value = leaveTypeData.status;
    btnUpdateLeaveType.setAttribute('data-token', leaveTypeData.token);

}


