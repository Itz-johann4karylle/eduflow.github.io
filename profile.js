document.addEventListener("DOMContentLoaded", function () {
    const menuIcon = document.querySelector(".menu-icon");
    const sidebar = document.querySelector(".sidebar");
    const productivityTools = document.getElementById("productivityTools");
    const dropdownMenu = document.querySelector(".dropdown-menu");

    menuIcon.addEventListener("click", function () {
        sidebar.classList.toggle("expanded"); // Expands sidebar
        sidebar.classList.toggle("hidden"); // Toggles transparency
    });

    // Toggle Productivity Tools Dropdown
    productivityTools.addEventListener("click", function (event) {
        event.preventDefault(); 
        dropdownMenu.classList.toggle("show");
    });
});

// Wait for the DOM to load
document.addEventListener("DOMContentLoaded", function () {
    // Set profile picture
    if (localStorage.getItem("profilePic")) {
        document.getElementById("profile-pic").src = localStorage.getItem("profilePic");
    }

    // Set profile details
    document.getElementById("full-name").textContent = localStorage.getItem("fullName") || "N/A";
    document.getElementById("grade-section").textContent = localStorage.getItem("gradeSection") || "N/A";
    document.getElementById("strand-course").textContent = localStorage.getItem("strandCourse") || "N/A";
    document.getElementById("gender").textContent = localStorage.getItem("gender") || "N/A";
    document.getElementById("age").textContent = localStorage.getItem("age") || "N/A";
    document.getElementById("role").textContent = localStorage.getItem("role") || "Student";
});

