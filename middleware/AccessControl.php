<?php
class AccessControl {
    public static function requireLogin() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit();
        }
    }

    public static function requireAdmin() {
        self::requireLogin();
        if ($_SESSION['role'] !== 'admin') {
            header("Location: dashboard.php");
            exit();
        }
    }
}

