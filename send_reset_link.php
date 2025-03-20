<?php
set_include_path(__DIR__);

require_once __DIR__ . '/PHPMailer/src/Exception.php';
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ✅ Get email from form input
if (isset($_POST['email']) && !empty($_POST['email'])) {
    $email = $_POST['email'];
} else {
    die("Error: Email field is empty.");
}

// ✅ Generate a secure token
$token = bin2hex(random_bytes(32)); // 64-character secure token

// ✅ Store token in database
$conn = new mysqli("localhost", "root", "", "student_acad_track_db"); // Update with your DB credentials

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$expiry_time = date("Y-m-d H:i:s", strtotime("+1 hour")); // Token expires in 1 hour
$sql = "UPDATE users SET reset_token='$token', token_expiry='$expiry_time' WHERE email='$email'";
$conn->query($sql);
$conn->close();

$mail = new PHPMailer(true);
try {
    // SMTP settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth = true;
    $mail->Username = 'johannakarylle.a@gmail.com'; 
    $mail->Password = 'vlnj ijpe vxkp nzqb';   
    $mail->SMTPSecure = 'tls'; 
    $mail->Port = 587;

    // Email details
    $mail->setFrom('your-email@gmail.com', 'Your Name');
    $mail->addAddress($email); 
    $mail->Subject = 'Password Reset Request';
    $mail->isHTML(true);
    $mail->Body = "Click <a href='http://localhost:8080/student_acad_track/reset_password.php?token=$token'>here</a> to reset your password.";
    $mail->send();
    echo 'Password reset email sent!';
} catch (Exception $e) {
    echo "Error: Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
