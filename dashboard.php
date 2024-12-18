<?php
require_once 'controllers/AuthController.php';
require_once 'middleware/AccessControl.php';
require_once 'models/User.php';
require_once 'models/Class.php';

AccessControl::requireLogin();

$auth = new AuthController();
$user = $auth->getCurrentUser();
$userModel = new User($pdo);
$classModel = new ClassModel($pdo); // Updated line

// Fetch available classes
$classes = $classModel->getAvailableClasses();

// Handle class application
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['class_id'])) {
    $classId = filter_input(INPUT_POST, 'class_id', FILTER_SANITIZE_NUMBER_INT);
    if ($classModel->applyForClass($user['id'], $classId)) {
        $message = "Successfully applied for the class!";
    } else {
        $error = "Failed to apply for the class. Please try again.";
    }
}

// Handle class cancellation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_class_id'])) {
    $cancelClassId = filter_input(INPUT_POST, 'cancel_class_id', FILTER_SANITIZE_NUMBER_INT);
    if ($classModel->cancelClassApplication($user['id'], $cancelClassId)) {
        $message = "Successfully cancelled the class application!";
    } else {
        $error = "Failed to cancel the class application. Please try again.";
    }
    // Refresh the list of applied classes
    $appliedClasses = $classModel->getUserAppliedClasses($user['id']);
}

// Fetch user's applied classes
$appliedClasses = $classModel->getUserAppliedClasses($user['id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav>
        <div class="container">
            <ul>
                <li><a href="index.php">Home</a></li>
                <?php if ($auth->isLoggedIn()): ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="user-profile.php">Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1>Dashboard</h1>
        <p>Welcome, <?php echo htmlspecialchars($user['username']); ?>!</p>
        
        <?php 
        if (isset($message)) echo "<p class='success'>$message</p>";
        if (isset($error)) echo "<p class='error'>$error</p>";
        ?>

        <div class="dashboard-grid">
            <div class="dashboard-item">
                <h2>Available Classes</h2>
                <ul class="class-list">
                    <?php foreach ($classes as $class): ?>
                        <li>
                            <h3><?php echo htmlspecialchars($class['name']); ?></h3>
                            <p>Start Date: <?php echo htmlspecialchars($class['start_date']); ?></p>
                            <p>Duration: <?php echo htmlspecialchars($class['duration']); ?></p>
                            <form action="dashboard.php" method="POST">
                                <input type="hidden" name="class_id" value="<?php echo $class['id']; ?>">
                                <button type="submit" class="btn">Apply for this Class</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            
            <div class="dashboard-item">
                <h2>Your Applied Classes</h2>
                <?php if (empty($appliedClasses)): ?>
                    <p>You haven't applied for any classes yet.</p>
                <?php else: ?>
                    <ul class="applied-class-list">
                        <?php foreach ($appliedClasses as $class): ?>
                            <li>
                                <h3><?php echo htmlspecialchars($class['name']); ?></h3>
                                <p>Start Date: <?php echo htmlspecialchars($class['start_date']); ?></p>
                                <p>Duration: <?php echo htmlspecialchars($class['duration']); ?></p>
                                <p>Status: <?php echo htmlspecialchars($class['status']); ?></p>
                                <form action="dashboard.php" method="POST">
                                    <input type="hidden" name="cancel_class_id" value="<?php echo $class['id']; ?>">
                                    <button type="submit" class="btn btn-danger">Cancel Application</button>
                                </form>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>

        <a href="user-profile.php" class="btn">Edit Profile</a>
        
        <?php if ($_SESSION['role'] === 'admin'): ?>
            <div class="admin-panel">
                <h2>Admin Panel</h2>
                <p>As an admin, you have access to additional features and settings.</p>
                <a href="admin/manage-classes.php" class="btn">Manage Classes</a>
                <a href="admin/manage-users.php" class="btn">Manage Users</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

