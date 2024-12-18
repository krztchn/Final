<?php
require_once 'controllers/AuthController.php';

$auth = new AuthController();
$error = '';
$disableForm = false;
$remainingTime = 0;


// Check if login attempts are tracked
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['lock_time'] = 0;
}

if ($_SESSION['login_attempts'] >= 3) {
    // Check kung tapos na timer
    if (time() - $_SESSION['lock_time'] >= 60) {
        // Reset after san oras
        $_SESSION['login_attempts'] = 0;
        $_SESSION['lock_time'] = 0;
    } else {
        $disableForm = true;
        $remainingTime = 60 - (time() - $_SESSION['lock_time']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    $error = $auth->login($username, $password);

    if ($error) {
        $_SESSION['login_attempts']++;
        if ($_SESSION['login_attempts'] >= 3) {
            $_SESSION['lock_time'] = time();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Login to Your Account</h1>
        <?php 
        if (!empty($error)) echo "<p style='color: red;'>$error</p>";
        if (isset($_SESSION['message'])) {
            echo "<p style='color: green;'>{$_SESSION['message']}</p>";
            unset($_SESSION['message']);
        }
        ?>
        
        <form method="POST" id="login-form">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn btn-dark" <?php echo $disableForm ? 'disabled' : ''; ?>>Login</button>
        </form>

        <?php if ($disableForm): ?>
            <p style="color: red;">Too many failed attempts. Please try again in <span id="countdown"><?php echo $remainingTime; ?></span> seconds.</p>
        <?php endif; ?>

        <p>Don't have an account? <a href="register.php">Register here</a></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        <?php if ($disableForm): ?>
            let countdownTime = <?php echo $remainingTime; ?>;
            const countdownElement = document.getElementById('countdown');

            function updateCountdown() {
                countdownTime--;
                countdownElement.textContent = countdownTime;
                if (countdownTime <= 0) {
                    window.location.reload();
                }
            }
            setInterval(updateCountdown, 1000);
        <?php endif; ?>
    </script>
</body>
</html>
