<?php
// app/Middleware/AdminMiddleware.php
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Core/Logger.php';
require_once __DIR__ . '/../Core/Response.php';

class AdminMiddleware {
    public static function handle() {
        Auth::check();
        if (($_SESSION['role'] ?? '') !== 'admin') {
            Logger::log("Unauthorized admin access attempt by user: " . ($_SESSION['email'] ?? 'GUEST'), 'SECURITY');
            Response::redirect('login.php');
        }
    }
}
?>