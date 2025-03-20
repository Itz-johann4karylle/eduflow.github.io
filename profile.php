<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT full_name, grade_level_section, strand, gender, age, role FROM profiles WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();

// Set default values if data is missing
$full_name = $user_data['full_name'] ?? 'N/A';
$age = $user_data['age'] ?? 'N/A';
$gender = $user_data['gender'] ?? 'N/A';
$role = $user_data['role'] ?? 'N/A';
$strand = $user_data['strand'] ?? 'N/A';
$grade_level_section = $user_data['grade_level_section'] ?? 'N/A';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | EduFlow</title>
    <link rel="stylesheet" href="profile.css">
    <script src="profile.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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

<div class="profile-container"> 
    <div class="profile-details">
        <h1>Student's Profile</h1>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user['full_name']); ?></p>
        <p><strong>Grade and Section:</strong> <?php echo htmlspecialchars($user['grade_level_section']); ?></p>
        <p><strong>Strand/Course:</strong> <?php echo htmlspecialchars($user['strand']); ?></p>
        <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></p>
        <p><strong>Age:</strong> <?php echo htmlspecialchars($user['age']); ?></p>
        <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
    </div>
    
    <div class="profile-actions">
        <button onclick="window.location.href='edit_profile.php'" class="edit-profile-btn">Edit Profile</button>
    </div>
</div>
</body>
</html>
