function fetchAllPayslips(page = 1) {
    var numberEntries = $("#entries-per-page").val();
    var pageNumber = getPage(page);
    var sortByColumn = getSortByColumn();
    if (sortByColumn == null) {
        sortByColumn = "created_at";
    }
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
            document.getElementById("skeleton-payslip-table")
        );
        document
            .getElementById("skeleton-payslip-table")
            .classList.remove("visually-hidden");
        document
            .getElementById("payslip-table")
            .classList.add("visually-hidden");
        skeletonLoaded = true;
    } else {
        document
            .getElementById("skeleton-payslip-table")
            .classList.remove("visually-hidden");
        document
            .getElementById("payslip-table")
            .classList.add("visually-hidden");
    }

    $.ajax({
        url: "payroll/modules/payslip-api",
        type: "POST",
        data: {
            action: "fetchAll",
            page: pageNumber,
            numberEntries: numberEntries,
            employee_id: employeeId,
            sort_by: sortByColumn,
            sort_order: sortOrderBy,
            filter_date_column: dateColumn,
            filter_startDate: startDate,
            filter_endDate: endDate,
        },
        success: function (response) {
            loadingSpinner.classList.add("visually-hidden");
            document
                .getElementById("skeleton-payslip-table")
                .classList.add("visually-hidden");
            document
                .getElementById("payslip-table")
                .classList.remove("visually-hidden");
            $("#payslip-table").html(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        },
    });
}

function downloadPDF(token){
    $.ajax({
        url: "payroll/modules/payslip-api",
        type: "POST",
        data: {
            action: "downloadPDF",
            token: token
        },
        xhrFields: { responseType: 'blob' }, // Expect binary data
        success: function (response) {
            var blob = new Blob([response], { type: "application/pdf" });
            var link = document.createElement("a");
            link.href = window.URL.createObjectURL(blob);
            link.download = `Payslip_${token}.pdf`;
            link.click();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("AJAX Error: " + textStatus + ": " + errorThrown);
        },
    });
}