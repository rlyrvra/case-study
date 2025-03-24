$(document).ready(function(){
    fetchAllBreakTypes();
});

let rowAdded = false;
function addBreakRowCreate() {
    if(rowAdded){
        return;
    }
    const tableBody = document.getElementById('break_table_body'); // Ensure we target tbody
    const row = document.createElement('tr');

    const breakTypeHTML = `
    <td>
        <input 
        type="text" 
        class="form-control" 
        id="create_break_name" 
        name="break_name" 
        required 
        minlength="2" 
        maxlength="50" 
        pattern="[A-Za-z\s]+" 
        title="Please enter a valid break name (letters and spaces only)">
    </td>
    <td>
        <select class="form-select" id="create_paid">
            <option value="Paid">Paid</option>
            <option value="Unpaid" selected>Unpaid</option>
        </select>
    </td>
    <td>
        <select class="form-select" id="create_duration_in_minutes">
            <option value="" selected disabled>Select duration...</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="30">30</option>
            <option value="40">40</option>
            <option value="50">50</option>
            <option value="60">60</option>
        </select>
    </td>
    <td>
        <button type="submit" class="btn btn-success" title="Click to Create" onclick="createBreaks()"> 
            <i class="bx bx-plus"></i>
        </button> 
        <button class="btn btn-danger" title="Click to Cancel" onclick="cancelBreakCreate(this)">
            <i class="bx bx-x"></i>
        </button>
    </td>
    `;
    row.innerHTML = breakTypeHTML;
    tableBody.appendChild(row);
    rowAdded = true;


}

function validateInputs(name, paid, duration){
    // Validation
    if (name === "") {
        //alert("Break name is required.");
        showInvalidFieldsBreak();
        return false;
    }


    if (!/^\d+$/.test(duration) || parseInt(duration) <= 0) {
        //alert("Break duration must be a positive number.");
        showInvalidFieldsBreak();
        return false;
    }
    return true;
}


// JavaScript function to delete a row
function cancelBreakCreate(button) {
    const row = button.parentNode.parentNode;
    row.parentNode.removeChild(row);
    rowAdded = false;
}

function showSuccessCreateBreak() {
    $('#add_breaks').modal('hide');
    Swal.fire({
        title: 'Success!',
        text: 'This break type has been created successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#add_breaks').modal('show');
        }
    });
}

function showSuccessUpdateBreak() {
    $('#add_breaks').modal('hide');
    Swal.fire({
        title: 'Success!',
        text: 'This break type has been updated successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#add_breaks').modal('show');
        }
    });
}

function showSuccessDeletionBreak() {
    Swal.fire({
        title: 'Success!',
        text: 'This break type has been deleted successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
}


function showInvalidFieldsBreak() {
    $('#add_breaks').modal('hide');
    Swal.fire({
        title: 'Warning!',
        text: 'Please fill up the fields properly.',
        icon: 'warning',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#add_breaks').modal('show');
        }
    });
}

function confirmDeleteBreakType(button) {
    $('#add_breaks').modal('hide');
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to delete this break type?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
        deleteBreakType(button);
        }else{
            $('#add_breaks').modal('show');
        }
    });
}

function showValidationError(errorMessages) {
    $('#update-allowances-modal').modal('hide');
    $('#add-allowances-modal').modal('hide');

    let formattedMessages = '';

    if (Array.isArray(errorMessages)) {
        formattedMessages = errorMessages.join('<br>'); // Format as a list
    } else if (typeof errorMessages === 'object') {
        formattedMessages = Object.values(errorMessages).flat().join('<br>'); // Flatten object values
    } else {
        formattedMessages = errorMessages; // Assume it's already a string
    }

    Swal.fire({
        title: 'Warning!',
        html:  formattedMessages,
        icon: 'warning',
        confirmButtonText: 'OK'
    });
}


function showError(message) {
    Swal.fire({
        title: 'Error!',
        text: message,
        icon: 'error',
        confirmButtonText: 'OK'
    });
}

function showFatalError(message) {
    Swal.fire({
        title: 'Fatal Error!',
        html: `${message} <br> Please contact the system administrator.`,
        icon: 'error',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            location.reload();
        }
    });
}