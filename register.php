<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // reCAPTCHA Verification
    $recaptcha_secret = "6LdYiPQqAAAAAH-CSB7lZZxXrL3mudAzoxnHo88E";
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $verify_url = "https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response";
    $verify_response = file_get_contents($verify_url);
    $response_data = json_decode($verify_response);

    if (!$response_data->success) {
        die("reCAPTCHA verification failed. Please try again.");
    }

    // Insert user into database
    $stmt = $conn->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $username, $password);

    if ($stmt->execute()) {
        echo "Registration successful! <a href='index.php'>Login here</a>";
    } else {
        echo "Error: " . $stmt->error;
    }
    // Assume user_id is the last inserted ID
    $user_id = $conn->insert_id;

// Insert a blank profile for the new user
    $sql = "INSERT INTO user (user_id, full_name, age, gender, role, strand, grade_level_section, profile_picture, updated_at) 
            VALUES (?, '', 0, '', 'Student', '', '', 'uploads/default.png', NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

}
?>
