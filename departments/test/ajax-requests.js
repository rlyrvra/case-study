function fetchAllDepartments(page = 1) {
    console.log(page);
    $.ajax({
        url: 'apiTest.php',
        method: 'POST',
        data: {
            action: 'fetchAll',
            page: page
        },
        dataType: 'html',
        success(response) {
            $('#departments').html(response);
        },
        error(xhr, status, error) {
            console.error("Error fetching departments:", error);
        }
    });
}

// $(document).on('click', '.page-link', function(e) {
//     e.preventDefault();
//     const page = $(this).data('page');
//     fetchAllDepartments(page);
// });

function createDepartment() {
    const departmentName = document.getElementById('createDepartmentName').value;
    const departmentHeadId = document.getElementById('createDepartmentHeadId').value;

    const departmentData = {
        name: departmentName,
        departmentHeadId
    };

    $.ajax({
        url: 'apiTest.php',
        method: 'POST',
        data: {
            action: 'create',
            department: departmentData
        },
        success(response) {
            fetchAllSort();
            document.getElementById('createDepartmentForm').reset();
        },
        error(xhr, status, error) {
            console.error("Error creating department:", error);
        }
    });
}

function updateDepartment(departmentData) {
    $.ajax({
        url: 'apiTest.php',
        method: 'POST',
        data: {
            action: 'update',
            department: departmentData
        },
        success(response) {
            fetchAllDepartments();
        },
        error(xhr, status, error) {
            console.error("Error updating department:", error);
        }
    });
}

