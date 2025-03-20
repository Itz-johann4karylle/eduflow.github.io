<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // Redirect to login if not authenticated
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | EduFlow</title>
    <link rel="stylesheet" href="dashboard.css">
    <script src="dashboard.js" defer></script>
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

    <!-- Main content -->
    <main class="main-content">
        <!-- Dashboard Content -->
        <section class="dashboard">
            <h1>Hello <span id="username"><?php echo $_SESSION['username']; ?>!</span></h1>
            
            <div class="feature-buttons">
                <button class="notes" onclick="goToNotes()">Notes</button>
                <button class="task">Task</button>
                <button class="event">Event</button>
                <button class="progress">Progress</button>
            </div>

            <div class="dashboard-bottom">
            <div class="recent-files">
            <h3>Recent Uploaded Files</h3>
                <ul>
                    <?php
                    include 'db_connect.php';

                    $query = "SELECT u.file_name, u.uploaded_at, s.subject_name, u.file_path 
                            FROM uploads u
                            JOIN subjects s ON u.subject_id = s.subject_id
                            ORDER BY u.uploaded_at DESC
                            LIMIT 5";
                            
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<li>
                                    <a href='" . $row['file_path'] . "' target='_blank'>" . $row['file_name'] . "</a>
                                    <br><small>Subject: " . $row['subject_name'] . " | Date: " . $row['uploaded_at'] . "</small>
                                </li>";
                        }
                    } else {
                        echo "<li>No recent files uploaded.</li>";
                    }
                    ?>
                </ul>
            </div>

                <div class="calendar-container">
                    <h3>Calendar</h3>
                    <div class="calendar">
                        <img src="calendar-placeholder.png" alt="Calendar">
                    </div>
                </div>

                <div class="tasks">
                    <h3>Tasks for today</h3>
                    <p>No upcoming tasks.</p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>


