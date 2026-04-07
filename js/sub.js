
document.addEventListener('DOMContentLoaded', () => {
    const logInForm = document.getElementById('login-form');

    logInForm.addEventListener('submit', (event) => {
        if (!logInForm.checkValidity()) {
            event.preventDefault();
            logInForm.reportValidity();
        }
        // if valid, do nothing — let the form submit naturally to login_process.php
    });
});