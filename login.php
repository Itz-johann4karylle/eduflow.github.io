<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // reCAPTCHA Verification
    $recaptcha_secret = "6LdYiPQqAAAAAH-CSB7lZZxXrL3mudAzoxnHo88E";
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $verify_url = "https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response";
    $verify_response = file_get_contents($verify_url);
    $response_data = json_decode($verify_response);

    if (!$response_data->success) {
        die("reCAPTCHA verification failed. Please try again.");
    }

    // Check user credentials
    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Invalid credentials!";
    }
    $stmt->close();
}
?>
