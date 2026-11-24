<?php
// app/Core/Auth.php
require_once __DIR__ . '/Response.php';
require_once __DIR__ . '/Logger.php';

class Auth {
    public static function check() {
        if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
            Logger::log("Unauthorized access attempt", 'SECURITY');
            Response::redirect('login.php');
        }
    }

    public static function user() {
        return [
            'id' => $_SESSION['user_id'] ?? null,
            'role' => $_SESSION['role'] ?? null,
            'name' => $_SESSION['name'] ?? 'User',
            'email' => $_SESSION['email'] ?? ''
        ];
    }

    public static function logout() {
        Logger::log("User logged out: " . ($_SESSION['email'] ?? 'Unknown'));
        session_unset();
        session_destroy();
        Response::redirect('index.php'); // Redirect to homepage after logout
    }
}
?>