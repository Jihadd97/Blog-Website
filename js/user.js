let userInfo = document.querySelector("#user_info");
let userD = document.querySelector("#user");
let links = document.querySelector("#links");

if (localStorage.getItem("loggedIn") === "true") {
    links.style.display = "none"; // Hide login/register links
    userInfo.style.display = "flex"; // Show user info
    userD.innerHTML = `Welcome, ${localStorage.getItem("username")}`;
}

let logOutBtn = document.querySelector("#logout");
logOutBtn.addEventListener("click", function () {
    if (localStorage.getItem("rememberMe") !== "true") {
        localStorage.clear(); // Clear all localStorage items if not remembered
    } else {
        localStorage.removeItem("loggedIn"); // Only remove logged-in status
    }
    setTimeout(() => {
        window.location = "login.html";
    }, 1500);
});