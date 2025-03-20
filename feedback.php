<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Survey Feedback | EduFlow</title>
    <link rel="stylesheet" href="feedback.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="feedback.js" defer></script>
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

<div class="feedback-container">
        <h1>Survey Feedback</h1>

        <h2>Hello!</h2>
        <p class="info-text">
            Have you tried out all the features? If you have, it would really appreciate us, the researchers, 
            if you would answer this questionnaire below. Thank you so much for trying our system!
        </p>

        <p class="survey-link">
            Google Form Link: 
            <a href="https://forms.gle/FtRdBHt4M5EkchBk9" target="_blank">https://forms.gle/FtRdBHt4M5EkchBk9</a>
        </p>

        <div class="gif-container">
            <img src="images/thank_you.gif" alt="Thank You GIF">
        </div>
    </div>

</body>
</html>