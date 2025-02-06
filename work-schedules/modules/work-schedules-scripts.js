function getPage(page){
    let output;
    if(page === 'next'){
        page = $("#pagination .active .page-link").text();
        let currentPage = parseInt($("#pagination .active .page-link").text(), 10);
        let maxPage = getMaxPageValue();
        if(currentPage < maxPage) page = currentPage + 1;
    } else if(page === 'prev'){
        page = $("#pagination .active .page-link").text();
        let currentPage = parseInt($("#pagination .active .page-link").text(), 10);
        if(currentPage != 1) page = currentPage - 1;
    }
    return page;
}

function getMaxPageValue() {
    // Find all <a> tags inside the <ul> with id "pagination"
    let pageNumbers = $("#pagination .page-link").map(function() {
        // Get the text content of each <a> tag and convert it to a number
        let pageText = $(this).text().trim(); // Use trim to remove any extra spaces
        return parseInt(pageText, 10);
    }).get(); // `.get()` turns the jQuery object into a plain array

    // Get the maximum value from the array (excluding NaN values)
    let maxPage = Math.max(...pageNumbers.filter(num => !isNaN(num)));

    return maxPage;
}


document.addEventListener('DOMContentLoaded', function () {
    const startTime = document.getElementById('startTime');
    const endTime = document.getElementById('endTime');
    const isFlextimeCheckbox = document.getElementById('isFlextime');
    // const coreStartTime = document.getElementById('coreStartTime');
    // const coreEndTime = document.getElementById('coreEndTime');
    const totalHours = document.getElementById('totalHoursPerWeek');

    isFlextimeCheckbox.addEventListener('change', function () {
        const isRequired = isFlextimeCheckbox.checked;

        // coreStartTime.required = isRequired;
        // coreEndTime.required = isRequired;
        totalHours.required = isRequired;
        
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const startTimeSelect = document.getElementById("startTime");
    const endTimeSelect = document.getElementById("endTime");

    function calculateWorkHours() {
        const startTime = startTimeSelect.value;
        const endTime = endTimeSelect.value;

        if (startTime && endTime) {
            const startDate = new Date(`1970-01-01T${convertTo24Hour(startTime)}`);
            const endDate = new Date(`1970-01-01T${convertTo24Hour(endTime)}`);

            let diff = (endDate - startDate) / (1000 * 60 * 60); // Difference in hours

            // Adjust for cases where end time is on the next day
            if (diff < 0) {
                diff += 24;
            }

            document.getElementById("totalWorkHours").value = diff;
        }
    }

    function convertTo24Hour(time) {
        const [hours, minutes, period] = time.match(/(\d+):(\d+)(AM|PM)/).slice(1);
        let hour = parseInt(hours, 10);
        if (period === "PM" && hour !== 12) {
            hour += 12;
        } else if (period === "AM" && hour === 12) {
            hour = 0;
        }
        return `${hour.toString().padStart(2, "0")}:${minutes}`;
    }

    endTimeSelect.addEventListener("change", calculateWorkHours);
});

function showFormIncomplete(){
    $('#add_work_schedules').modal('hide');
    Swal.fire({
        title: 'Warning!',
        text: 'Please fill up the create form.',
        icon: 'warning',
        timer: 2000,
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            $('#add_work_schedules').modal('show');
        }
    });
    
}

function missingFieldValues(fieldName){
    $('#add_work_schedules').modal('hide');
    Swal.fire({
        title: 'Warning!',
        text: `The ${fieldName} is missing. Please fill it up and try again.`,
        icon: 'warning',
        confirmButtonText: 'OK'
    });
}

function showSuccessCreate() {
    $('#add_work_schedules').modal('hide');
    Swal.fire({
        title: 'Success!',
        text: 'The work schedule has been created successfully.',
        icon: 'success',
        timer: 2000,
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
            window.location.href = SMARTWAGE_LOCATION + "/work-schedule";
        }
    });
}