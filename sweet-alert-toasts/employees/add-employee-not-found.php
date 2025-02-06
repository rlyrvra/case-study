<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<!-- Sweet Alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function showEmployeeNotFound() {
    Swal.fire({
        title: 'Warning',
        text: 'Employee not found.',
        icon: 'warning',
        confirmButtonText: 'OK'
    });
}

</script>

<?php
    $script_call = "<script>
        $(document).ready(function(){
            showEmployeeNotFound();
        });
    </script>";
    echo $script_call;
?>
