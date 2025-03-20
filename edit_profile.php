<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM profiles WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$stmt->close();
$conn->close();

$full_name = $user_data['full_name'] ?? '';
$grade_level_section = $user_data['grade_level_section'] ?? '';
$strand = $user_data['strand'] ?? '';
$gender = $user_data['gender'] ?? '';
$age = $user_data['age'] ?? '';
$role = $user_data['role'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | EduFlow</title>
    <link rel="stylesheet" href="edit_profile.css">
    <script src="edit_profile.js"></script>
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

<div class="edit-profile-container">
    <h1>Edit Student's Profile</h1>
    <form action="update_profile.php" method="POST">
        <div class="edit-profile-field">
            <label>Full Name:</label>
            <input type="text" name="full_name" value="<?php echo htmlspecialchars($user_data['full_name']); ?>" placeholder="Enter your full name">
        </div>

        <div class="edit-profile-field">
            <label>Grade and Section:</label>
            <select name="grade_level_section">
                <option value="">Select your grade level and section</option>
                <option value="12 - A1" <?php echo ($user_data['grade_level_section'] == "12 - A1") ? 'selected' : ''; ?>>12 - A1</option>
                <option value="12 - A2" <?php echo ($user_data['grade_level_section'] == "12 - A2") ? 'selected' : ''; ?>>12 - A2</option>
                <option value="12 - A3" <?php echo ($user_data['grade_level_section'] == "12 - A3") ? 'selected' : ''; ?>>12 - A3</option>
                <option value="12 - A4" <?php echo ($user_data['grade_level_section'] == "12 - A4") ? 'selected' : ''; ?>>12 - A4</option>
                <option value="12 - B1" <?php echo ($user_data['grade_level_section'] == "12 - B1") ? 'selected' : ''; ?>>12 - B1</option>
                <option value="12 - B2" <?php echo ($user_data['grade_level_section'] == "12 - B2") ? 'selected' : ''; ?>>12 - B2</option>
                <option value="12 - B3" <?php echo ($user_data['grade_level_section'] == "12 - B3") ? 'selected' : ''; ?>>12 - B3</option>
                <option value="12 - B4" <?php echo ($user_data['grade_level_section'] == "12 - B4") ? 'selected' : ''; ?>>12 - B4</option>
            </select>
        </div>

        <div class="edit-profile-field">
            <label>Strand/Course:</label>
            <select name="strand">
                <option value="">Select your strand/course</option>
                <option value="INFORMATION, COMMUNICATIONS, AND TECHNOLOGIES" <?php echo ($user_data['strand'] == "INFORMATION, COMMUNICATIONS, AND TECHNOLOGIES") ? 'selected' : ''; ?>>INFORMATION, COMMUNICATIONS, AND TECHNOLOGIES</option>
            </select>
        </div>

        <div class="edit-profile-field">
            <label>Gender:</label>
            <select name="gender">
                <option value="">Select your gender</option>
                <option value="Male" <?php echo ($user_data['gender'] == "Male") ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($user_data['gender'] == "Female") ? 'selected' : ''; ?>>Female</option>
                <option value="Prefer Not to Say" <?php echo ($user_data['gender'] == "Prefer Not to Say") ? 'selected' : ''; ?>>Prefer Not to Say</option>
            </select>
        </div>

        <div class="edit-profile-field">
            <label>Age:</label>
            <input type="number" name="age" value="<?php echo htmlspecialchars($user_data['age']); ?>" placeholder="Enter your age">
        </div>

        <div class="edit-profile-field">
            <label>Role:</label>
            <select name="role">
                <option value="">Select your role</option>
                <option value="Student" <?php echo ($user_data['role'] == "Student") ? 'selected' : ''; ?>>Student</option>
            </select>
        </div>

        <div class="profile-actions">
            <button type="button" class="cancel-btn" onclick="window.location.href='profile.php'">Cancel</button>
            <button type="submit" class="save-btn">Save</button>
        </div>
    </form>
</div>

</body>
</html>