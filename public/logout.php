<?php
// public/logout.php

// 1. Load the application configuration and core classes
require_once '../app/Config/config.php';
require_once '../app/Core/Auth.php';
require_once '../app/Core/Logger.php';

// 2. Log the logout action for security auditing (before session is destroyed)
if (isset($_SESSION['email'])) {
    Logger::log("User logged out successfully: " . $_SESSION['email']);
}

// 3. Trigger the secure logout method from the Auth class
// This will unset session variables, destroy the session, and redirect to login.php
Auth::logout();
?>