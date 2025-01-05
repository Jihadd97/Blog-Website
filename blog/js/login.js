// Ensure the DOM is fully loaded before attaching event listeners
document.addEventListener("DOMContentLoaded", function() {
    let loginForm = document.querySelector("#loginForm");

    if (loginForm) {
        loginForm.addEventListener("submit", function(e) {
            e.preventDefault();

            // Get input values
            let email = document.querySelector("#email").value;
            let password = document.querySelector("#password").value;
            let rememberMe = document.querySelector("#rememberMe").checked;

            // Get stored values from localStorage
            let storedEmail = localStorage.getItem("email");
            let storedPassword = localStorage.getItem("password");
            let storedFirstName = localStorage.getItem("firstName");

            // Check if email and password match stored values
            if (email === storedEmail && password === storedPassword) {
                // Set logged-in status and store the first name
                localStorage.setItem("loggedIn", "true");
                localStorage.setItem("username", storedFirstName); // Assuming you're storing the username as the first name

                // Handle "Remember me" functionality
                if (rememberMe) {
                    localStorage.setItem("rememberMe", "true");
                } else {
                    localStorage.removeItem("rememberMe");
                }

                alert("Login successful!");

                // Redirect to homepage after login
                setTimeout(() => {
                    window.location = "index.html";
                }, 300); // Small delay before redirecting
            } else {
                alert("Incorrect email or password.");
            }
        });
    } else {
        console.error("Login form not found");
    }
 });