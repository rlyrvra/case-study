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
            sort_by: sortByColumn,
            sort_order: sortOrderBy,
            filter_status: filterStatus,
            filter_date_column: dateColumn,
            filter_startDate: startDate,
            filter_endDate: endDate,
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
