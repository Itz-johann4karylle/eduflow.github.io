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

document.addEventListener("DOMContentLoaded", function () {
    const addTaskBtn = document.querySelector(".add-task");
    const clearTasksBtn = document.getElementById("clearTasks");
    const taskList = document.getElementById("taskList");
    const deadlineList = document.getElementById("deadlineList");

    addTaskBtn.addEventListener("click", function () {
        let taskName = document.querySelector(".task-name").value;
        let subjectId = document.querySelector(".task-subject").value;
        let priority = document.querySelector(".task-priority").value;
        let difficulty = document.querySelector(".task-difficulty").value;
        let deadline = document.querySelector(".task-deadline").value;

        if (!taskName || !subjectId || !priority || !difficulty || !deadline) {
            alert("Please complete all fields before adding a task.");
            return;
        }

        // Remove placeholder text when a task is added
        if (taskList.textContent.trim() === "No new tasks") {
            taskList.innerHTML = ""; // Clear the text
        }
        if (deadlineList.textContent.trim() === "No deadlines yet") {
            deadlineList.innerHTML = ""; // Clear the text
        }

        // Add new task to To-Do List
        let taskItem = document.createElement("li");
        taskItem.textContent = taskName;
        taskItem.classList.add("task-item");
        taskList.appendChild(taskItem);

        // Add new deadline to Incoming Deadlines
        let deadlineItem = document.createElement("li");
        deadlineItem.textContent = `${taskName} - Due: ${deadline}`;
        deadlineItem.classList.add("deadline-item");
        deadlineList.appendChild(deadlineItem);

        // Add task completion functionality
        taskItem.addEventListener("click", function () {
            taskItem.classList.toggle("completed");
            updateProgress();
        });

        // Save task data to database
        let formData = new FormData();
        formData.append("task_name", taskName);
        formData.append("subject_id", subjectId);
        formData.append("priority", priority);
        formData.append("difficulty", difficulty);
        formData.append("deadline", deadline);

        fetch("save_task.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert("Task added successfully!");
        })
        .catch(error => console.error("Error:", error));
    });

    // Clear all tasks function
    clearTasksBtn.addEventListener("click", function () {
        if (confirm("Are you sure you want to clear all tasks?")) {
            fetch("clear_tasks.php", { method: "POST" })
            .then(response => response.text())
            .then(data => {
                alert("All tasks cleared!");
                taskList.innerHTML = "No new tasks"; // Reset text
                deadlineList.innerHTML = "No deadlines yet"; // Reset text
            })
            .catch(error => console.error("Error:", error));
        }
    });

    // Function to update the progress meter
    function updateProgress() {
        let totalTasks = document.querySelectorAll(".task-item").length;
        let completedTasks = document.querySelectorAll(".task-item.completed").length;
        let progressMeter = document.getElementById("taskProgress");
        let progressText = document.getElementById("progressText");

        if (totalTasks > 0) {
            let progressPercentage = (completedTasks / totalTasks) * 100;
            progressMeter.value = progressPercentage;
            progressText.textContent = `${Math.round(progressPercentage)}%`;
        }
    }
});


