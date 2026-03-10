
document.addEventListener('DOMContentLoaded', () => {

    const userSubmitBtn = document.getElementById('user-submit');
    const adminSubmitBtn = document.getElementById('admin-submit');
    const logInForm = document.getElementById('login-form');

    userSubmitBtn.addEventListener('click', (event) => {

        if (logInForm.checkValidity()) {
            event.preventDefault();
            window.location.href = 'UserPage.php';
        } else {
            // This triggers the native browser popups (e.g., "Please fill out this field")
            logInForm.reportValidity();
        }
    });


    adminSubmitBtn.addEventListener('click', (event) => {

        if (logInForm.checkValidity()) {
            event.preventDefault();
            window.location.href = 'AdminPage.php';
        } else {
            // This triggers the native browser popups (e.g., "Please fill out this field")
            logInForm.reportValidity();
        }
    });

});