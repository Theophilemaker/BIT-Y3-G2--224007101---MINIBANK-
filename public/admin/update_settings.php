<?php
require_once '../../app/Config/config.php';
require_once '../../app/Core/Auth.php';
Auth::requireRole('admin');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCSRF($_POST['csrf_token'] ?? '')) die("CSRF failed.");
    
    $db = Database::getInstance();
    $settings = [
        'site_name' => $_POST['site_name'],
        'site_slogan' => $_POST['site_slogan'],
        'logo_url' => $_POST['logo_url']
    ];
    
    foreach($settings as $key => $val) {
        $stmt = $db->prepare("UPDATE system_settings SET setting_value = ? WHERE setting_key = ?");
        $stmt->execute([$val, $key]);
    }
    
    $_SESSION['success'] = "Settings updated successfully.";
    header('Location: ' . BASE_URL . 'admin/dashboard.php');
    exit;
}
?>