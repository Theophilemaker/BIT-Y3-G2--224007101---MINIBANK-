<?php
class Logger {
    public static function log($message, $type = 'INFO') {
        $logDir = __DIR__ . '/../../storage/logs/';
        if (!is_dir($logDir)) mkdir($logDir, 0755, true);
        $logFile = $logDir . 'app_' . date('Y-m-d') . '.log';
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
        $user = $_SESSION['email'] ?? 'GUEST';
        $formatted = "[" . date('Y-m-d H:i:s') . "] [$type] [IP: $ip] [User: $user] - $message" . PHP_EOL;
        file_put_contents($logFile, $formatted, FILE_APPEND | LOCK_EX);
    }
}
?>