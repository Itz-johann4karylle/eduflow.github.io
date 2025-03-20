<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Sign Up</h2>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

<form method="post" action="register.php">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    
    <!-- reCAPTCHA Widget -->
    <div class="g-recaptcha" data-sitekey="6LdYiPQqAAAAAO7AXZsATuZUSnlLUuLWtiJq5Flh"></div><br>

    <button type="submit">Register</button>
</form>
</body>
</html>