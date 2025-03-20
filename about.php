<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About | EduFlow</title>
    <link rel="stylesheet" href="about.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="about.js" defer></script>
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

    <div class="about-container">
        <h1>About</h1>

        <h2>Researchers</h2>
        <div class="researchers-grid">
            <?php 
            // Researcher details
            $researchers = [
                ["image" => "images/aquino.png", "name" => "Johanna Karylle Aquino", "position" => "Leader"],
                ["image" => "images/pantaleon.jpg", "name" => "Dominique Pantaleon", "position" => "Member"],
                ["image" => "images/luna.jpg", "name" => "Chelsea Luna", "position" => "Member"],
                ["image" => "images/domingo.JPG", "name" => "Quirc Edrian Domingo", "position" => "Member"],
                ["image" => "images/sumalinog.jpg", "name" => "Rainne Sumalinog", "position" => "Member"],
                ["image" => "images/sullano.jpeg", "name" => "Roman Sullano", "position" => "Member"],
                ["image" => "images/nunal.jpeg", "name" => "Lester Nuñal", "position" => "Member"],
                ["image" => "images/almario.jpg", "name" => "Ryan Almario", "position" => "Member"]
            ];

            // Loop through each researcher
            foreach ($researchers as $researcher) { ?>
                <div class="researcher-card">
                    <img src="<?php echo $researcher['image']; ?>" alt="Researcher Image">
                    <p><?php echo $researcher['name']; ?></p>
                    <p><?php echo $researcher['position']; ?></p>
                </div>
            <?php } ?>
        </div>

        <h2>Student Academic Tracker (EduFlow)</h2>
        <p class="info-text">
            Hello! We are the researchers of Group 1 from Grade 12 - ICT B1. Welcome to our student academic tracker system “EduFlow”.
            The purpose of the researchers’ study is to determine whether or not academic trackers are effective in a student’s academic 
            performance and encourage productivity.
        </p>
        <p class="info-text">
            EduFlow is a student academic tracker that helps a student track down tasks like activities and projects, 
            upcoming events, and create/upload notes. With these features combined, it meets three aspects: 
            motivation, time management, and organization.
        </p>

        <div class="placeholder-img">
            <img src="images/lofi.jpeg" alt="EduFlow Image">
        </div>

        <p class="info-text">
            We hope you enjoy using all the features our system has to offer. If you have finished testing them out, you can visit our 
            “Feedback” page to answer a quick survey about your experience. Thank you!
        </p>

        <p class="footer">© 2025 EduFlow | All Rights Reserved.</p>
    </div>

</body>
</html>
