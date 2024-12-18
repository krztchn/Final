<?php
require_once 'controllers/AuthController.php';

$auth = new AuthController();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management System</title>
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
        <h1>Welcome To Our Student Management System</h1>
        
        <?php if ($auth->isLoggedIn()): ?>
            <p>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>
            
            <div class="feature-section">
                <h2>Manage Your Profile</h2>
                <p>Keep your information up to date and secure. You can edit your personal details, update your preferences, and manage your account settings.</p>
                <a href="user-profile.php" class="btn">Go to Profile</a>
            </div>
            
            <div class="feature-section">
                <h2>Take Classes</h2>
                <p>Explore our wide range of classes and start learning today. From beginner to advanced levels, we have courses to suit everyone's needs.</p>
                <a href="dashboard.php" class="btn">View Classes</a>
            </div>
            
            <div class="feature-section">
                <h2>Upcoming Events</h2>
                <p>Stay informed about our latest events, workshops, and webinars. Don't miss out on opportunities to enhance your skills and network with others.</p>
               
            </div>
            
        <?php else: ?>
            <p>Join our community to access a world of learning opportunities and connect with like-minded individuals.</p>
            <div class="cta-buttons">
                <a href="login.php" class="btn">Login</a>
                <a href="register.php" class="btn btn-secondary">Register</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>