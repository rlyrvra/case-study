function showSpinnerLoader(){
    Swal.fire({
        title: 'Please wait...',
        html: '<div class="spinner-border text-primary spinner-border-lg" role="status"></div>',
        allowOutsideClick: false,
        allowEscapeKey: false,
        showConfirmButton: false
    });
}

function closeSpinnerLoader() {
    Swal.close();
}