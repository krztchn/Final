<?php
session_start();
require_once 'config/database.php';
require_once 'models/User.php';

class AuthController {
    private $user;

    public function __construct() {
        global $pdo;
        $this->user = new User($pdo);
    }

    // Register a new user with validation for duplicates
    public function register($username, $email, $password) {
        if ($this->user->getByUsername($username)) {
            return "Username is already taken.";
        }

        if ($this->user->getByEmail($email)) {
            return "Email is already registered.";
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if ($this->user->create($username, $email, $hashedPassword)) {
            $_SESSION['message'] = "Registration successful. Please log in.";
            header("Location: login.php");
            exit();
        } else {
            return "Registration failed.";
        }
    }

    // Login a user with username and password
    public function login($username, $password) {
        $user = $this->user->getByUsername($username);
    
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
    
                if ($user['role'] === 'user') {
                    header("Location: index.php");
                } else if ($user['role'] === 'admin'){
                    header("Location: admin.php");
                } else if ($user['role'] === 'superadmin'){
                    header("Location: superadmin.php");
                } else if ($user['role'] === 'instructor'){
                    header("Location: instructor.php");
                }
                exit();
            }
        }
    
        return "Invalid username or password.";
    }
    

    // Logout the current user
    public function logout() {
        session_destroy();
        header("Location: login.php");
        exit();
    }

    // Check if the user is logged in
    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    // Get the currently logged-in user
    public function getCurrentUser() {
        if ($this->isLoggedIn()) {
            return $this->user->getByUsername($_SESSION['username']);
        }
        return null;
    }
}
?>
