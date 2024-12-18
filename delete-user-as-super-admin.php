<?php
require_once 'controllers/AuthController.php';
require_once 'models/User.php';

$auth = new AuthController();
if (!$auth->isLoggedIn() || $_SESSION['role'] !== 'superadmin') {
    header("Location: login.php");
    exit();
}

global $pdo;
$userModel = new User($pdo);

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    if ($userId == $_SESSION['user_id']) {
        header("Location: superadmin.php?error=You cannot delete your own account.");
        exit();
    }

    if ($userModel->deleteUser($userId)) {
        header("Location: superadmin.php?success=User deleted successfully");
        exit();
    } else {
        header("Location: superadmin.php?error=Failed to delete user");
        exit();
    }
} else {
    header("Location: superadmin.php?error=Invalid user ID");
    exit();
}
?>
