document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form"); // Get the form
    const password = document.getElementById("password"); // Get the password input
    const rePassword = document.getElementById("re-password"); // Get the re-password input

    form.addEventListener("submit", function(event) {
        // Check if passwords match
        if (password.value !== rePassword.value) {
            // Prevent form submission
            event.preventDefault();
            // Display SweetAlert
            Swal.fire({
                icon: 'error',
                title: 'Password Does not Match!',
                text: 'Please re-enter your password.',
                confirmButtonText: 'OK'
            });
        }
    });
});
