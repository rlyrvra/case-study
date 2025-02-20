let attempts = 5;
function login(){
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const remember = document.getElementById('remember').checked;

    if(username.length <= 0 || password.length <= 0){
        showEmptyFields();
        return;
    }

    if(attempts <= 0){
        const location = "login";
        window.location.href = location;
    }

    $.ajax({
        url: 'requests/login/login-api',
        method: 'POST',
        data: {
            username: username,
            password: password,
            remember: remember
        },
        dataType: 'json',
        success(response) {
            if (response.success) {
                const location = "smartWage-index?s=true"
                window.location.href = location;
            } else {
                const location = "sweet-alert-toasts/login/login-incorrect"
                $.get(location, function(data) {
                    $('#response').html(data); // This loads and runs the script in login-incorrect.php
                });
            }
        },
        error(xhr, status, error) {
            console.error("Error fetching credentials", error);
        }
    });
}

function showEmptyFields(){
    Swal.fire({
        title: 'Warning!',
        text: 'Password and/or username fields cannot be empty.',
        icon: 'warning',
        confirmButtonText: 'OK'
    });
}