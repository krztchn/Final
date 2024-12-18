<?php
require_once 'controllers/AuthController.php';
require_once 'models/User.php';

$auth = new AuthController();
if (!$auth->isLoggedIn() || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

global $pdo;
$userModel = new User($pdo);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['id'];
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $role = $_POST['role'];

    if ($userModel->updateUser($userId, $username, $email, $role)) {
        header("Location: admin.php?success=User updated successfully");
        exit();
    } else {
        $error = "Failed to update user.";
    }
}

// Fetch the user data
if (isset($_GET['id'])) {
    $userId = $_GET['id'];
    $user = $userModel->getById($userId);

    if (!$user) {
        header("Location: admin.php?error=User not found");
        exit();
    }
} else {
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit User</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="id" value="<?= $user['id']; ?>">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-select">
                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : ''; ?>>User</option>
                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="admin.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
