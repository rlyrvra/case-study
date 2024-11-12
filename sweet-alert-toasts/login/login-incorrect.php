<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function login_failed(){
    const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    });
        Toast.fire({
        icon: "error",
        title: "Login credentials is wrong."
    });
}

</script>

<?php
    $script_call = "<script>
        $(document).ready(function(){
            login_failed();
        });
    </script>";
    echo $script_call;
?>
