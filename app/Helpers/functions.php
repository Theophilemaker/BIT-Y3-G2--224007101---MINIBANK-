<?php
// app/Helpers/functions.php
require_once __DIR__ . '/../Core/Database.php';

function getSettings() {
    try {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT setting_key, setting_value FROM system_settings");
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    } catch (Exception $e) {
        return [
            'site_name' => 'MiniBank Rwanda',
            'site_slogan' => 'Bank Smart. Live Better.',
            'contact_phone' => '+250 788 000 000',
            'contact_email' => 'support@minibank.rw'
        ];
    }
}

function formatRWF($amount) {
    return 'RWF ' . number_format((float)$amount, 2);
}

function generateCSRF() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function validateCSRF($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
?>