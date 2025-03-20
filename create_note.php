<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch subjects from the database
$query = "SELECT subject_name, color_code FROM subjects WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$subjects = [];
while ($row = $result->fetch_assoc()) {
    $subjects[] = $row;
}
$stmt->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['note_title'];
    $subject = $_POST['subject_name'];
    $content = $_POST['note_content'];

    // Get the subject color from the database
    $query = "SELECT color_code FROM subjects WHERE user_id = ? AND subject_name = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $user_id, $subject);
    $stmt->execute();
    $stmt->bind_result($subject_color);
    $stmt->fetch();
    $stmt->close();

    // Insert note into database
    $insertQuery = "INSERT INTO notes (user_id, subject_name, subject_color, note_title, note_content, created_at) 
                    VALUES (?, ?, ?, ?, ?, NOW())";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("issss", $user_id, $subject, $subject_color, $title, $content);
    
    if ($stmt->execute()) {
        header("Location: notes.php"); // Redirect back to Notes page
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create a New Note | EduFlow</title>
    <link rel="stylesheet" href="create_note.css">
    <script src="create_note.js" defer></script>
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
        <img src="images/profile-picture.png" alt="Profile" class="profile-pic">
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

<script>
function updateColor() {
            var subjectDropdown = document.getElementById("subject");
            var selectedSubject = subjectDropdown.options[subjectDropdown.selectedIndex].value;
            var colorBox = document.getElementById("colorBox");

            var subjects = <?php echo json_encode($subjects); ?>;
            for (var i = 0; i < subjects.length; i++) {
                if (subjects[i].subject_name === selectedSubject) {
                    colorBox.style.backgroundColor = subjects[i].color_code;
                    break;
                }
            }
        }
</script>

<div class="note-container">
    <h1>Create a New Note</h1>
    <form method="POST">
        <div class="note-form">
            <div class="color-box" id="colorBox"></div>

            <div class="input-group">
                <label>Title:</label>
                <input type="text" name="note_title" placeholder="Write the title of your notes" required>
            </div>

            <div class="input-group">
            <label for="subjectDropdown">Subject:</label>
            <select name="subject_name" id="subjectSelect" onchange="updateSubjectColor()">
                <option value="">Select a Subject</option>
                <?php while ($row = $subjects_result->fetch_assoc()): ?>
                    <option value="<?php echo $row['subject_name']; ?>" data-color="<?php echo $row['color_code']; ?>">
                        <?php echo $row['subject_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>

    <script>
    function updateSubjectColor() {
        var subjectSelect = document.getElementById("subjectSelect");
        var selectedOption = subjectSelect.options[subjectSelect.selectedIndex];
        var color = selectedOption.getAttribute("data-color");
        document.getElementById("subjectColorBox").style.backgroundColor = color;
    }
    </script>

    <div id="subjectColorBox" style="width: 50px; height: 50px; background-color: transparent; border: 1px solid #ccc;"></div>

            <div class="input-group">
                <label>Note:</label>
                <textarea name="note_content" placeholder="Write it down" required></textarea>
            </div>

            <div class="button-group">
                <button type="button" class="cancel-btn" onclick="window.location.href='notes.php'">Cancel</button>
                <button type="submit" class="save-btn">Add</button>
            </div>
        </div>
    </form>
</div>

</body>
</html>