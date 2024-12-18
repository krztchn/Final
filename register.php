<?php
require_once 'controllers/AuthController.php';

$auth = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate username
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);

    // Sanitize and validate email
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    // Validate email format after sanitization
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    }
    // Validate password strength
    else {
        $password = $_POST['password'];
        
        // Password strength validation: at least 8 characters, including at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character
        $passwordPattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        if (!preg_match($passwordPattern, $password)) {
            $error = "Password must be at least 8 characters long, with at least one uppercase letter, one lowercase letter, one number, and one special character.";
        }
        // Proceed with registration if email and password are valid
        else {
            $error = $auth->register($username, $email, $password);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Register an account</h1>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>