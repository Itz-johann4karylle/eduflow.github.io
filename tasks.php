<?php
include 'db_connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task | EduFlow</title>
    <link rel="stylesheet" href="tasks.css">
    <script src="tasks.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <!-- Top Navigation Bar -->
    <div class="top-nav">
    <!-- Left Section: EduFlow Logo -->
    <div class="nav-left">
        <img src="images/edu.PNG" alt="EduFlow Logo" class="logo-placeholder">
    </div>

    <!-- Right Section: Time, Date, Profile Picture -->
    <div class="nav-right">
        <span id="current-time"></span>
        <span id="current-date"></span>
    </div>
</div>

<script>
        function updateTime() {
            const now = new Date();
            document.getElementById('current-time').textContent = now.toLocaleTimeString();
            document.getElementById('current-date').textContent = now.toLocaleDateString(undefined, { 
                weekday: 'short', year: 'numeric', month: 'short', day: 'numeric' 
            });
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>

<!-- Sidebar -->
<aside class="sidebar">
    <div class="logo">
        <i class="fas fa-bars menu-icon" id="menuToggle"></i>
    </div>
    <nav class="menu">
        <a href="dashboard.php">
            <i class="fas fa-home"></i>
            <span class="menu-text">Dashboard</span>
        </a>

        <!-- Productivity Tools Dropdown (No Icon, Clickable Entirely) -->
        <div class="dropdown">
            <a href="#" id="productivityTools">
                <i class="fas fa-calendar"></i>
                <span class="menu-text">Productivity Tools</span>
            </a>
            <div class="dropdown-menu">
                <a href="notes.php"><i class="fas fa-sticky-note"></i> <span class="menu-text">Notes</span></a>
                <a href="tasks.php"><i class="fas fa-tasks"></i> <span class="menu-text">Task</span></a>
                <a href="events.php"><i class="fas fa-calendar-alt"></i> <span class="menu-text">Event</span></a>
                <a href="progress.php"><i class="fas fa-chart-line"></i> <span class="menu-text">Progress</span></a>
            </div>
        </div>

        <a href="profile.php">
            <i class="fas fa-user"></i>
            <span class="menu-text">Profile</span>
        </a>
        <a href="about.php">
            <i class="fas fa-info-circle"></i>
            <span class="menu-text">About</span>
        </a>
        <a href="feedback.php">
            <i class="fas fa-comment"></i>
            <span class="menu-text">Feedback</span>
        </a>
        <a href="logout.php" class="logout">
            <i class="fas fa-sign-out-alt"></i>
            <span class="menu-text">Logout</span>
        </a>
    </nav>
</aside>

<div class="task-container">
        <h2 class="task-header">Tasks</h2>

        <!-- Task Table -->
        <table class="task-table">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Subject</th>
                    <th>Priority</th>
                    <th>Difficulty</th>
                    <th>Deadline</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="taskTable">
                <tr>
                    <td><input type="text" class="task-name" placeholder="Add a new task"></td>
                    <td>
                        <select class="task-subject">
                            <option value="">Select Subject</option>
                            <?php
                            $subject_query = "SELECT * FROM subjects";
                            $result = mysqli_query($conn, $subject_query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row['subject_id'] . "'>" . $row['subject_name'] . "</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select class="task-priority">
                            <option value="Low">Low</option>
                            <option value="Moderate">Moderate</option>
                            <option value="Very Important">Very Important</option>
                        </select>
                    </td>
                    <td>
                        <select class="task-difficulty">
                            <option value="Easy">Easy</option>
                            <option value="Medium">Medium</option>
                            <option value="Difficult">Difficult</option>
                        </select>
                    </td>
                    <td><input type="date" class="task-deadline"></td>
                    <td><button class="add-task">➕</button></td>
                </tr>
            </tbody>
        </table>

        <!-- Clear All Tasks -->
        <button id="clearTasks">Clear all tasks</button>

        <div class="task-summary">
            <!-- To-Do List -->
            <div class="to-do-list">
                <h3>To-Do List</h3>
                <ul id="taskList">No new tasks</ul>
            </div>

            <!-- Incoming Deadlines -->
            <div class="incoming-deadlines">
                <h3>Incoming Deadlines</h3>
                <ul id="deadlineList">No deadlines yet</ul>
            </div>

            <!-- Completion Meter -->
            <div class="completion-meter">
                <h3>Completion Meter</h3>
                <progress id="taskProgress" value="0" max="100"></progress>
                <p id="progressText">0%</p>
            </div>
        </div>
    </div>
</body>
</html>