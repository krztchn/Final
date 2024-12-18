<?php
require_once 'controllers/AuthController.php';
require_once 'models/User.php';

$auth = new AuthController();

// Ensure only admins can access this page
if (!$auth->isLoggedIn() || $_SESSION['role'] !== 'superadmin') {
    header("Location: login.php");
    exit();
}

global $pdo;
$userModel = new User($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $role = 'admin'; 

    if ($userModel->createAdmin($username, $email, $hashedPassword, $role)) {
        header("Location: superadmin.php?success=Student created successfully");
        exit();
    } else {
        $error = "Failed to create admin.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Create Admin</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Admin</button>
            <a href="superadmin.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
