// Ensure the DOM is fully loaded before attaching event listeners
document.addEventListener("DOMContentLoaded", function() {
    let registerForm = document.querySelector("#registerForm");

    if (registerForm) {
        registerForm.addEventListener("submit", function(e) {
            e.preventDefault();

            // Get the input values
            let firstName = document.querySelector("#firstName").value;
            let lastName = document.querySelector("#lastName").value;
            let email = document.querySelector("#email").value;
            let password = document.querySelector("#password").value;

            // Save user information in localStorage
            localStorage.setItem("firstName", firstName);
            localStorage.setItem("lastName", lastName);
            localStorage.setItem("email", email);
            localStorage.setItem("password", password);
            localStorage.setItem("username", email); // Assuming username is the email

            alert("Registration successful!");

            // Redirect to the login page after successful registration
            setTimeout(function () {
                window.location.href = "login.html";
            }, 100); // Small delay before redirecting
        });
    } else {
        console.error("Register form not found");
    }
});