<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form method="post" action="update_password.php">
        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
        <input type="password" name="new_password" placeholder="New Password" required><br>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required><br>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>


