function fetchAllAttendance(page = 1) {
    var numberEntries = $("#entries-per-page").val();
    var pageNumber = getPage(page);
    var sortByColumn = getSortByColumn();
    if (sortByColumn == null) {
        sortByColumn = "created_at";
    }
    var filterStatus = $("#status").val();
    var sortOrderBy = getOrderBy();
    if (sortOrderBy == null) {
        sortOrderBy = "DESC";
    }
    var dateColumn = getByDate();
    var startDate, endDate;
    if (dateColumn) {
        startDate = $("#dateStart").val();
        endDate = $("#dateEnd").val();
    }
    var employeeId = $("#selectize_employee_sorter").val();
    var viewMode = getViewMode();

    // console.log(`
    //     Number of Entries: ${numberEntries},
    //     Sort By Column: ${sortByColumn},
    //     Page Number: ${pageNumber},
    //     Sort Order By: ${sortOrderBy},
    //     Date Column: ${dateColumn},
    //     Start Date: ${startDate},
    //     End Date: ${endDate}`);

    var loadingSpinner = document.getElementById("loadingSpinner");
    loadingSpinner.classList.remove("visually-hidden");

    if (!skeletonLoaded) {
        loadSkeletonView(
            7,
            [
                "Date",
                "Check In Time",
                "Check Out Time",
                "Break Duration (in min)",
                "Total Hours Worked",
                "Late Check In",
                "Overtime Hours",
                "Overtime Approval",
                "Status",
                "Remarks",
            ],
            numberEntries,
            document.getElementById("skeleton-attendance-table")
        );
        document
            .getElementById("skeleton-attendance-table")
            .classList.remove("visually-hidden");
        document
            .getElementById("my-attendance-table")
            .classList.add("visually-hidden");
        skeletonLoaded = true;
    } else {
        document
            .getElementById("skeleton-attendance-table")
            .classList.remove("visually-hidden");
        document
            .getElementById("my-attendance-table")
            .classList.add("visually-hidden");
    }

    $.ajax({
        url: "attendance/attendance/modules/attendance-api",
        type: "POST",
        data: {
            action: "fetchAll",
            page: pageNumber,
            numberEntries: numberEntries,
            employee_id: employeeId,
            sort_by: sortByColumn,
            sort_order: sortOrderBy,
            filter_status: filterStatus,
            filter_date_column: dateColumn,
            filter_startDate: startDate,
            filter_endDate: endDate,
            view_mode: viewMode
        },
        success: function (response) {
            loadingSpinner.classList.add("visually-hidden");
            document
                .getElementById("skeleton-attendance-table")
                .classList.add("visually-hidden");
            document
                .getElementById("my-attendance-table")
                .classList.remove("visually-hidden");
            $("#my-attendance-table").html(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        },
    });
}


async function approveOvertime(button){
    const row = button.closest('tr');  // Get the closest row
    const attendanceData = {
        id: row.getAttribute('data-id')
    }
    console.log(attendanceData);
    try{
        const response = await fetch(
            'attendance/attendance/modules/attendance-api',
            {
                method: 'POST',
                headers: {
                    'Accept' : '*/*',
                    'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
                    'X-Requested-With' : 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    action: 'approveOvertime',
                    attendance: JSON.stringify(attendanceData)
                })
            }
        );
        if(!response.ok){
            console.log("Response Error: " + error);
            return;
        }

        const data = await response.text();
        $('#response-test').html(data);
        fetchAllAttendance();
    } catch (error) {
        console.log("Fatal Error: " + error);
        return;
    }
}