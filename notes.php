<?php
include 'db_connect.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $subject_id = $_POST['subject']; // Get selected subject ID

    // Check if a file was uploaded
    if (!empty($_FILES["file"]["name"])) {
        $upload_dir = "uploads/"; // Directory where files are stored
        $file_name = basename($_FILES["file"]["name"]);
        $file_tmp = $_FILES["file"]["tmp_name"];
        $file_size = $_FILES["file"]["size"];
        $file_path = $upload_dir . $file_name;

        // Check if file already exists (prevent overwriting)
        if (file_exists($file_path)) {
            echo "<script>alert('Error: File already exists!');</script>";
        } else {
            // Move file to upload directory
            if (move_uploaded_file($file_tmp, $file_path)) {
                // Insert into the database
                $query = "INSERT INTO uploads (file_name, file_path, subject_id, uploaded_at) 
                          VALUES ('$file_name', '$file_path', '$subject_id', NOW())";

                if (mysqli_query($conn, $query)) {
                    echo "<script>alert('File uploaded successfully!');</script>";
                } else {
                    echo "<script>alert('Database error: " . mysqli_error($conn) . "');</script>";
                }
            } else {
                echo "<script>alert('Error: File upload failed.');</script>";
            }
        }
    } else {
        echo "<script>alert('No file selected.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes | EduFlow</title>
    <link rel="stylesheet" href="notes.css">
    <script src="notes.js" defer></script>
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

<div class="notes-wrapper">
        <!-- Left Side: Notes and Subject Creation -->
        <div class="notes-content">
            <h2>Notes</h2>
            <div class="notes-buttons">
                <button class="btn" id="openNoteModalBtn">+<br>Create a new note</button>
                <button class="btn" id="openFileUploadModalBtn">📤<br>Upload a file</button>
            </div>

            <h2>Subjects</h2>
            <button class="btn" id="openSubjectModalBtn">+<br>Create a subject folder</button>
            
            <div id="subjectList"></div> <!-- Subjects will appear here -->
        </div>

        <!-- Right Side: Uploaded Notes & Files -->
        <div class="notes-container">
            <h3>Uploaded Notes</h3>
            <div id="uploadedNotes"></div> <!-- Notes will appear here -->
            <h3>Uploaded Files</h3>
            <div id="uploadedFiles"></div>
        </div>
    </div>

    <!-- Modal: Create Subject -->
    <div id="subjectModal" class="modal">
        <div class="modal-content">
            <h2>Create a subject</h2>
            <label>Subject title:</label>
            <input type="text" id="subjectTitle" placeholder="Name of the subject">
            
            <label>Subject color:</label>
            <input type="color" id="subjectColor">
            
            <div class="modal-buttons">
                <button id="cancelSubjectBtn" class="btn-cancel">Cancel</button>
                <button id="addSubjectBtn" class="btn-add">Add</button>
            </div>
        </div>
    </div>

    <!-- Modal: Create Note -->
    <div id="noteModal" class="modal">
        <div class="modal-content">
            <h2>Create a new note</h2>
            <label>Title:</label>
            <input type="text" id="noteTitle" placeholder="Write the title of your notes">
            
            <label>Subject:</label>
            <select id="noteSubject">
                <option disabled selected>Select a subject</option>
            </select>

            <label>Note:</label>
            <textarea id="noteContent" placeholder="Write it down"></textarea>

            <div class="modal-buttons">
                <button id="cancelNoteBtn" class="btn-cancel">Cancel</button>
                <button id="saveNoteBtn" class="btn-add">Save</button>
            </div>
        </div>
    </div>

    <!-- Modal: View Note -->
    <div id="viewNoteModal" class="modal">
        <div class="modal-content">
            <h2 id="viewNoteTitle"></h2>
            <h4 id="viewNoteSubject"></h4>
            <p id="viewNoteContent"></p>

            <div class="modal-buttons">
                <button id="closeNoteView">Close</button>
            </div>
        </div>
    </div>

        <!-- Upload File Modal -->
    <div id="uploadFileModal" class="modal">
        <div class="modal-content">
            <h2>Upload a file</h2>
            <label for="fileUpload">Upload</label>
            <input type="file" id="fileUpload">
            
            <label for="fileSubject">Subject:</label>
            <select id="fileSubject">
                <option disabled selected>Select a subject</option>
            </select>

            <div class="modal-buttons">
                <button id="cancelUploadBtn" class="cancel-btn">Cancel</button>
                <button id="addFileBtn" class="add-btn">Add</button>
            </div>
        </div>
    </div>

    <div id="viewFileModal" class="modal">
    <div class="modal-content">
        <h2 id="viewFileName"></h2>
        <iframe id="fileViewer" width="100%" height="400px"></iframe>
        <button id="closeFileView">Close</button>
    </div>
</div>
</body>
</html>