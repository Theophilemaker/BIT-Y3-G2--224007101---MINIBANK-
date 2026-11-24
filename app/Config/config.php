<?php
// app/Config/config.php
$envFile = __DIR__ . '/../../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0 || strpos($line, '=') === false) continue;
        list($key, $value) = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}

define('APP_ENV', $_ENV['APP_ENV'] ?? 'development');
define('BASE_URL', $_ENV['APP_URL'] ?? 'http://localhost/minibank-rwanda/public/');
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'mini_banking_system');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? '');

date_default_timezone_set($_ENV['APP_TIMEZONE'] ?? 'Africa/Kigali');

if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    session_start();
}

require_once __DIR__ . '/../Core/Logger.php';
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Helpers/functions.php';
require_once __DIR__ . '/../Helpers/validation.php';