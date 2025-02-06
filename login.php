<?php require_once __DIR__ . '/includes/header.php'; ?>
<?php require_once __DIR__ . '/includes/session.php'; ?>
<?php require_once __DIR__ . '/includes/file-locations.php' ?>
<?php require_once __DIR__ . '/login-validator.php'; ?>
<?php
if(isset($_GET['r']) && $_GET['r']){
    include_once __DIR__ . '/sweet-alert-toasts/login/login-require.php';
}else if(isset($_GET['l']) && $_GET['l']){
    include_once __DIR__ . '/sweet-alert-toasts/login/login-logout.php';
}else{
    // do nothing
}

?>
<!-- Scripts -->
<script src="requests/login/login-ajax-requests.js?v=1.5"></script>
<title>
smartWAGE Login
</title>
<link rel="icon" type="image/x-icon" href="img/logo-files/logo1.ico" />
<style>
@import url('https://fonts.googleapis.com/css2?family=Medula+One&family=Onest:wght@100..900&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Medula+One&family=Onest:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

body{
    background-color: #16423C;
}

.header-smart h1, .header-wage h1{
    font-family: "Medula One", serif;
    color: #FFFFFF;
    overflow-wrap: break-word;
    word-break: break-word;
    font-size: clamp(8rem, 6vh, 5rem);
}

.header-wage h1{
    text-indent: 10%;
}

.body-container{
    min-height: 100vh;
    overflow: hidden;
}

.col {
    max-width: 100%;
}


.login-container {
    background-color: #d9d9d9;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    font-family: "Poppins", sans-serif;
}

.login-container h1 {
    font-weight: bold;
}

.form-check-label {
    font-size: 0.9rem;
}

.btn-login {
    background-color: #004d40;
    color: #fff;
    width: 100%;
}

.btn-login:hover {
    background-color: #003b31;
}

.forgot-password {
    font-size: 0.9rem;
}


</style>



<body>
<section class="body-container container-fluid d-flex align-items-center justify-content-center">
    <div class="container p-5">
        <div id="response"></div>
        <div class="row">
            <div class="col mt-5">
                <div class="row header-smart">
                    <h1 class="display-1">SMART</h1>
                </div>
                <div class="row header-wage">
                    <h1 class="display-1">WAGE</h1>
                </div>
            </div>
            <div class="col">
                <div class="login-container p-5">
                    <h1 class="text-center mb-4">LOGIN</h1>
                    <form onsubmit="event.preventDefault()">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required value="">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required value="">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" checked>
                            <label class="form-check-label" for="remember">Remember me?</label>
                        </div>
                        <button type="submit" class="btn btn-login mb-3" onclick="login()">LOGIN</button>
                       
                    </form>
                </div>
            </div>
        </div>
    </div>
    

</section>

    
</body>
