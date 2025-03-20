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

