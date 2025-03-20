<?php
session_start();
include 'db_connect.php'; // Make sure this file contains the database connection

if (!isset($_SESSION['user_id'])) {
    die("User not logged in");
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileUpload"])) {
    $file_name = $_FILES["fileUpload"]["name"];
    $file_tmp = $_FILES["fileUpload"]["tmp_name"];
    $file_size = $_FILES["fileUpload"]["size"];
    $upload_dir = "uploads/";

    // Create uploads directory if not exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file_path = $upload_dir . basename($file_name);

    // Move file to uploads folder
    if (move_uploaded_file($file_tmp, $file_path)) {
        // Insert file details into database
        $query = "INSERT INTO uploads (user_id, file_name, file_path, uploaded_at) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iss", $user_id, $file_name, $file_path);

        if ($stmt->execute()) {
            echo "File uploaded successfully!";
        } else {
            echo "Error updating database: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Error moving file.";
    }
}

$conn->close();
?>
