<?php
session_start();
require __DIR__ . '/db_connect.php'; // Ensure this file has a valid database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST["token"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    if ($new_password !== $confirm_password) {
        echo "Passwords do not match!";
        exit();
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Check if the token exists in the database
    $query = "SELECT email FROM users WHERE reset_token = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row["email"];

        // Update password and remove token
        $updateQuery = "UPDATE users SET password = ?, reset_token = NULL WHERE email = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("ss", $hashed_password, $email);

        if ($updateStmt->execute()) {
            // Redirect to login page with success message
            header("Location: index.php?reset=success");
            exit(); // Ensure script stops execution after redirection
        } else {
            echo "Error updating password.";
            exit();
        }
    } else {
        echo "Invalid or expired token.";
        exit();
    }
} else {
    // Redirect if accessed directly
    header("Location: index.php");
    exit();
}
?>