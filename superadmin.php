<?php
require_once 'controllers/AuthController.php';
require_once 'models/User.php';


$auth = new AuthController();
// if (!$auth->isLoggedIn() || $_SESSION['role'] !== 'superadmin') {
//     header("Location: login.php");
//     exit();
// }


global $pdo;
$userModel = new User($pdo);
$users = $userModel->getAllUsers();
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid d-flex justify-content-between">
            <div> <a class="navbar-brand" href="#">Super Admin Dashboard</a></div>
            <div class="">
                <ul class="navbar-nav d-flex gap-5 ">
                <li class="nav-item">
                        <a class="nav-link" href="create-student-as-super-admin.php">Create Student</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="create-instructor-as-super-admin.php">Create Instructor</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="create-admin.php">Create Admin</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1 class="mb-4">View all users</h1>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $index => $user): ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= htmlspecialchars($user['username']); ?></td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                        <td><?= htmlspecialchars($user['role']); ?></td>
                        <td>
                            <a href="edit-user.php?id=<?= $user['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="delete-user-as-super-admin.php?id=<?= $user['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
