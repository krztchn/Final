<?php
require_once 'controllers/AuthController.php';
require_once 'middleware/AccessControl.php';
require_once 'models/User.php';

AccessControl::requireLogin();

$auth = new AuthController();
$user = $auth->getCurrentUser();
$userModel = new User($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $birthdate = filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_STRING);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $hobby = filter_input(INPUT_POST, 'hobby', FILTER_SANITIZE_STRING);

    if ($userModel->updateProfile($user['id'], [
        'name' => $name,
        'email' => $email,
        'birthdate' => $birthdate,
        'gender' => $gender,
        'address' => $address,
        'hobby' => $hobby
    ])) {
        $message = "Profile updated successfully.";
        $user = $auth->getCurrentUser(); // Refresh user data
    } else {
        $error = "Failed to update profile.";
    }
}

$age = $user['birthdate'] ? $userModel->calculateAge($user['birthdate']) : 'N/A';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <nav>
        <div class="container">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="user-profile.php">Profile</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <h1>User Profile</h1>
        <?php 
        if (isset($message)) echo "<p class='success'>$message</p>";
        if (isset($error)) echo "<p class='error'>$error</p>";
        ?>
        <div class="profile-info">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Age:</strong> <?php echo $age; ?></p>
            <p><strong>Birthdate:</strong> <?php echo htmlspecialchars($user['birthdate'] ?? 'Not set'); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender'] ?? 'Not set'); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address'] ?? 'Not set'); ?></p>
            <p><strong>Hobby:</strong> <?php echo htmlspecialchars($user['hobby'] ?? 'Not set'); ?></p>
            <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
        </div>
        <h2>Update Profile</h2>
        <form method="POST">
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" placeholder="Name" required>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" placeholder="Email" required>
            <input type="date" name="birthdate" value="<?php echo htmlspecialchars($user['birthdate'] ?? ''); ?>" placeholder="Birthdate">
            <select name="gender">
                <option value="">Select Gender</option>
                <option value="Male" <?php echo ($user['gender'] ?? '') === 'Male' ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($user['gender'] ?? '') === 'Female' ? 'selected' : ''; ?>>Female</option>
                <option value="Other" <?php echo ($user['gender'] ?? '') === 'Other' ? 'selected' : ''; ?>>Other</option>
            </select>
            <input type="text" name="address" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>" placeholder="Address">
            <input type="text" name="hobby" value="<?php echo htmlspecialchars($user['hobby'] ?? ''); ?>" placeholder="Hobby">
            <button type="submit" class="btn">Update Profile</button>
        </form>
    </div>
</body>
</html>