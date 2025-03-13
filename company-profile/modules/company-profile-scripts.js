$(document).ready(function(){
    fetchAllInfo();
});

function previewImage(event) {
    const file = event.target.files[0];
    const reader = new FileReader();
    
    reader.onload = function() {
        const imgElement = document.getElementById('company_picture');
        imgElement.src = reader.result;
    };
    
    if (file) {
        reader.readAsDataURL(file);
    }
}

function showSuccessUpdate() {
    Swal.fire({
        title: 'Success!',
        text: 'Company Information has been updated successfully.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
}

function showImageError(errorMessage){
    Swal.fire({
        title: 'Error!',
        text: errorMessage,
        icon: 'error',
        confirmButtonText: 'OK'
    });
}