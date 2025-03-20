<?php
$conn = new mysqli("localhost", "root", "", "student_acad_track_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // echo "Database connected successfully.";
}
?>
