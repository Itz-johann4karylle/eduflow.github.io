<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

<form method="post" action="login.php">
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>

    <!-- reCAPTCHA Widget -->
    <div class="g-recaptcha" data-sitekey="6LdYiPQqAAAAAO7AXZsATuZUSnlLUuLWtiJq5Flh"></div><br>

    <button type="submit">Login</button>
</form>
    <p>Don't have an account? <a href="register_form.php">Register here</a></p>
</body>
</html>