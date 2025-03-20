<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$full_name = $_POST['full_name'];
$grade_level_section = $_POST['grade_level_section'];
$strand = $_POST['strand'];
$gender = $_POST['gender'];
$age = $_POST['age'];
$role = $_POST['role'];
$profile_picture = $_POST['profile_picture'] ?? 'uploads/';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'] ?? '';
    $grade_level_section = $_POST['grade_level_section'] ?? '';
    $strand = $_POST['strand'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $age = $_POST['age'] ?? '';
    $role = $_POST['role'] ?? '';

    // Update profile information in the database
    $query = "UPDATE profiles SET full_name=?, grade_level_section=?, strand=?, gender=?, age=?, role=? WHERE user_id=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssi", $full_name, $grade_level_section, $strand, $gender, $age, $role, $user_id);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Profile updated successfully!";
    } else {
        $_SESSION['error_message'] = "Error updating profile.";
    }
    
    $stmt->close();
    $conn->close();
    
    header("Location: profile.php");
    exit();
}
