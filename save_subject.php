<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id']; // Get logged-in user ID
    $subject_name = $_POST['subject_name'];
    $color_code = $_POST['color_code'];

    $stmt = $conn->prepare("INSERT INTO subjects (user_id, subject_name, color_code, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iss", $user_id, $subject_name, $color_code);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false]);
    }
    $stmt->close();
    $conn->close();
}
?>
