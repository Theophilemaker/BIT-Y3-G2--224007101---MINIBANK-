<?php
// app/Middleware/AuthMiddleware.php
require_once __DIR__ . '/../Core/Auth.php';
require_once __DIR__ . '/../Core/Logger.php';
require_once __DIR__ . '/../Core/Response.php';

class AuthMiddleware {
    public static function handle() {
        Auth::check();
    }
}
?>