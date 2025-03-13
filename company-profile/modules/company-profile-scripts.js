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