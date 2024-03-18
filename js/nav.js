document.addEventListener("DOMContentLoaded", () => {
    "use strict";

    const menuIcon = document.querySelector(".menuIcon");
    menuIcon.addEventListener("click", toggleDashboard);

    const crossIcon = document.querySelector(".cross");
    crossIcon.addEventListener("click", toggleDashboard)

    const dashboard = document.querySelector(".dashboard");

    function toggleDashboard() {
        dashboard.classList.toggle("showed");
        if (dashboard.classList.contains("showed")) {
            document.body.style.overflow = "hidden";
        } else {
            document.body.style.overflow = "auto";
        }
    }
});