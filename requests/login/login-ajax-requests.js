function login(){
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const remember = document.getElementById('remember').checked;

    if(username.length <= 0 || password.length <= 0){
        return;
    }

    console.log(`Username: ${username}, Password: ${password}, Remember: ${remember}`);
    $.ajax({
        url: 'requests/login/login-api.php',
        method: 'POST',
        data: {
            username: username,
            password: password,
            remember: remember
        },
        dataType: 'json',
        success(response) {
            if (response.success) {
                window.location.href = "/case-study/smartWage-index.php?s=true";
            } else {
                $.get('/case-study/sweet-alert-toasts/login/login-incorrect.php', function(data) {
                    $('#response').html(data); // This loads and runs the script in login-incorrect.php
                });
            }
        },
        error(xhr, status, error) {
            console.error("Error fetching credentials", error);
        }
    });
}