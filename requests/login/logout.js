function confirmLogout() {
    Swal.fire({
        title: 'Are you sure?',
        text: "Do you want to logout?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then((result) => {
        if (result.isConfirmed) {
            const location = "requests/login/logout"
            window.location.href = location;
        }
    });
}