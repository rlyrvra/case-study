$(document).ready(function() {
    const startDate = document.getElementById('startDate');
    const today = new Date();
    const formattedDate = today.toISOString().split('T')[0];
    const future = new Date();
    future.setFullYear(future.getFullYear() + 300); // Add 300 years
    const futureformattedDate = future.toISOString().split('T')[0];
    // Function to disable past dates based on the selected date
    startDate.addEventListener('focus', function() {
        startDate.setAttribute('min', formattedDate);
        startDate.setAttribute('max', futureformattedDate);
    });
    

    startDate.addEventListener("input", function () {
        const minDate = new Date(this.min);
        const maxDate = new Date(this.max);
        const currentDate = new Date(this.value);

        if (currentDate < minDate || currentDate > maxDate) {
            console.log("Hello");
            alert(`Please select a date between ${formattedDate} and ${futureformattedDate}.`);
            this.value = ""; // Clear invalid input
        }
    });

});

function setEndDateMin(date){
    const endDate = document.getElementById('endDate');
    if (!date.value || isNaN(new Date(date.value).getTime())){
        endDate.disabled = true;
        endDate.value = "";
        $("#totalDays").val("");
        return;
    }
    limitDate = new Date(date.value);
    limitDate.setDate(limitDate.getDate());
    const formattedDate = limitDate.toISOString().split('T')[0];
    endDate.setAttribute('min', formattedDate);
    endDate.value = "";
    endDate.disabled = false;
    endDate.removeEventListener("input", function () {
        
    });
    endDate.addEventListener("input", function () {
        const minDate = limitDate;
        const currentDate = new Date(this.value);

        if (currentDate < minDate) {
            alert(`Please select a date beyond ${formattedDate}`);
            this.value = ""; // Clear invalid input
        }
    });
}

function calculateTotalNumberOfDays(){
    const startDateId = document.getElementById('startDate').value;
    const endDateId = document.getElementById('endDate').value;
    let startDate, endDate, totalNumberOfDays;
    if(!startDateId || !endDateId){
        console.log("missing");
        return;
    }
    startDate = new Date(startDateId);
    endDate = new Date(endDateId);
    totalNumberOfDays = (endDate - startDate) / (1000 * 60 * 60 * 24);
    if(startDate.getTime() === endDate.getTime()){
        totalNumberOfDays = 1;
    }
    $("#totalDays").val(totalNumberOfDays);
    const remainingBalance = $("#remainingBalance").val();
    if(remainingBalance <= 0){
        return false;
    }
    if(totalNumberOfDays > remainingBalance){
        showInvalidBalance();
        return false;
    }
    return true;

}

function updateLeaveRequestClick(button){
    const row = button.closest('tr');  // Get the closest row
    const leaveRequestData = {
        token: row.getAttribute('data-token'),
        name: row.getAttribute('data-leave-type-name'),
        start_date: row.getAttribute('data-start-date'),
        end_date: row.getAttribute('data-end-date'),
        reason: row.getAttribute('data-reason')
    };

    //console.log(leaveRequestData);

    const leaveTypeName = $("#leaveType");
    const startDate = $("#startDate");
    const endDate = $("#endDate");
    const reason = $("#reason");

    leaveTypeName.val(leaveRequestData.token);
    startDate.val(leaveRequestData.start_date);
    endDate.val(leaveRequestData.end_date);
    reason.val(leaveRequestData.reason);
    document.getElementById("form_indicator").innerHTML = "Update My Leave";
    if(!calculateTotalNumberOfDays()) return;
}

function showInvalidBalance(){
    Swal.fire({
        title: 'Error Request!',
        text: 'Your requested days is greater than your balance.',
        icon: 'error',
        confirmButtonText: 'OK'
    }).then((result) => {
        if(result.isConfirmed){
            document.getElementById('apply_leave_form').reset();
            document.getElementById('leaveType').value = "";
        }
    });
}

function showSuccessRequest(){
    Swal.fire({
        title: 'Request Success!',
        text: 'Your leave request has been filed.',
        icon: 'success',
        confirmButtonText: 'OK'
    }).then((result) => {
        if(result.isConfirmed){
            document.getElementById('apply_leave_form').reset();
            document.getElementById('leaveType').value = "";
        }
    });
}

function showSuccessDeleteRequest(){
    Swal.fire({
        title: 'Delete Success!',
        text: 'Your leave request has been deleted.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
}

function showError(){
    Swal.fire({
        title: 'Error!',
        text: 'An error has occured. Please try again.',
        icon: 'error',
        confirmButtonText: 'OK'
    }).then((result) => {
        if(result.isConfirmed){
            window.location.href = "apply-leave";
        }
    });
}
