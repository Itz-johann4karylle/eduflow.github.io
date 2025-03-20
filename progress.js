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

document.addEventListener("DOMContentLoaded", () => {
    updateProgress();
    generateWeeklyChart();
    generateMonthlyChart();
});

function updateProgress() {
    let completedTasks = JSON.parse(localStorage.getItem("completedTasks")) || [];
    let totalTasks = JSON.parse(localStorage.getItem("totalTasks")) || 10; // Default 10 tasks per day

    let progressPercentage = (completedTasks.length / totalTasks) * 100;
    progressPercentage = Math.min(progressPercentage, 100); // Ensure it doesn't exceed 100%

    document.getElementById("progress-percentage").textContent = Math.round(progressPercentage) + "%";
    document.getElementById("progress-fill").style.width = progressPercentage + "%";

    // Update completed task list
    let taskList = document.getElementById("task-list");
    taskList.innerHTML = "";
    completedTasks.forEach(task => {
        let li = document.createElement("li");
        li.textContent = task;
        taskList.appendChild(li);
    });
}

function generateWeeklyChart() {
    let weeklyData = JSON.parse(localStorage.getItem("weeklyProgress")) || [5, 8, 6, 10, 7, 9, 8]; 

    let ctx = document.getElementById("weeklyChart").getContext("2d");
    new Chart(ctx, {
        type: "pie",
        data: {
            labels: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],
            datasets: [{
                label: "Tasks Completed",
                data: weeklyData,
                backgroundColor: ["#FF5733", "#FFBD33", "#33FF57", "#3357FF", "#8D33FF", "#FF33A1", "#33FFF5"]
            }]
        }
    });
}

function generateMonthlyChart() {
    let monthlyData = JSON.parse(localStorage.getItem("monthlyProgress")) || [20, 25, 30, 22, 28, 35, 40];

    let ctx = document.getElementById("monthlyChart").getContext("2d");
    new Chart(ctx, {
        type: "bar",
        data: {
            labels: ["Week 1", "Week 2", "Week 3", "Week 4"],
            datasets: [{
                label: "Tasks Completed",
                data: monthlyData,
                backgroundColor: "#4287f5"
            }]
        }
    });
}
