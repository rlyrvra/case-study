function showSpinnerLoader(){
    Swal.fire({
        title: 'Please wait...',
        html: '<div class="container-fluid spinner-border spinner-border-lg d-flex align-items-center justify-content-center w-px-200 h-px-200" role="status"></div>',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false
    });
}

function closeSpinnerLoader() {
    Swal.close();
}