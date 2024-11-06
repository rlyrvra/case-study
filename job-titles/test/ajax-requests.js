function fetchAllJobTitles() {
    $.ajax({
        url: 'apiTest.php',
        method: 'POST',
        data: {
            action: 'fetchAll'
        },
        dataType: 'html',
        success(response) {
            $('#job_title_table').html(response);
        },
        error(xhr, status, error) {
            console.error("Error fetching departments:", error);
        }
    });
}