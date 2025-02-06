<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function require_login(){
    const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    });
        Toast.fire({
        icon: "warning",
        title: "You need to log in to view this page."
    });
}

</script>

<?php
    $script_call = "<script>
        $(document).ready(function(){
            require_login();
        });
    </script>";
    echo $script_call;
?>
