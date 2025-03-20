<?php
session_start();
include 'db_connect.php';

// Check if session user_id exists
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "User not logged in"]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $subject_name = trim($_POST['subject_name']);
    $color_code = trim($_POST['color_code']);

    // Check if fields are empty
    if (empty($subject_name) || empty($color_code)) {
        echo json_encode(["success" => false, "message" => "Fields cannot be empty"]);
        exit;
    }

    // Check if the subject already exists
    $check_stmt = $conn->prepare("SELECT * FROM subjects WHERE user_id = ? AND subject_name = ?");
    $check_stmt->bind_param("is", $user_id, $subject_name);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "Subject already exists"]);
        exit;
    }
    $check_stmt->close();

    // Insert subject
    $stmt = $conn->prepare("INSERT INTO subjects (user_id, subject_name, color_code, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iss", $user_id, $subject_name, $color_code);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "subject_name" => $subject_name, "color_code" => $color_code]);
    } else {
        echo json_encode(["success" => false, "message" => "Database error"]);
    }
    $stmt->close();
    $conn->close();
}
?>
