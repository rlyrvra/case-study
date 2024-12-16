$(document).ready(function() {
    const startDate = document.getElementById('startDate');
    // Function to disable past dates based on the selected date
    startDate.addEventListener('focus', function() {
        const today = new Date();
        const formattedDate = today.toISOString().split('T')[0];
        startDate.setAttribute('min', formattedDate);
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
    limitDate.setDate(limitDate.getDate() + 1);
    const formattedDate = limitDate.toISOString().split('T')[0];
    endDate.setAttribute('min', formattedDate);
    endDate.value = "";
    endDate.disabled = false;
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
    $("#totalDays").val(totalNumberOfDays);
    const remainingBalance = $("#remainingBalance").val();
    if(remainingBalance <= 0){
        return;
    }
    if(totalNumberOfDays > remainingBalance){
        showInvalidBalance();
    }

}

function showInvalidBalance(){
    Swal.fire({
        title: 'Error!',
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
        title: 'Success!',
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
