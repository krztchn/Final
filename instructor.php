<?php
require_once 'controllers/AuthController.php';
require_once 'models/User.php';
require_once 'models/Class.php';

$auth = new AuthController();
// if (!$auth->isLoggedIn() || $_SESSION['role'] !== 'admin') {
//     header("Location: login.php");
//     exit();
// }
$classModel = new ClassModel($pdo); // Updated line

// Fetch available classes
$classes = $classModel->getAvailableClasses();
global $pdo; 
$userModel = new User($pdo);
$users = $userModel->getStudents();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid d-flex justify-content-between">
            <div> <a class="navbar-brand" href="#">Instructor Dashboard</a></div>
            <div class="">
                <ul class="navbar-nav d-flex gap-5 ">
                <li class="nav-item">
                        <a class="nav-link" href="create-class.php">Create Class</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4 ">View all Classes</h1>

        <div class="dashboard-grid ">
            <div class="dashboard-item2">
                <ul class="class-list">
                    <?php foreach ($classes as $class): ?>
                        <li class=" bg-light p-3 rounded mb-2 list-style-none">
                            <h3><?php echo htmlspecialchars($class['name']); ?></h3>
                            <p>Start Date: <?php echo htmlspecialchars($class['start_date']); ?></p>
                            <p>Duration: <?php echo htmlspecialchars($class['duration']); ?></p>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
