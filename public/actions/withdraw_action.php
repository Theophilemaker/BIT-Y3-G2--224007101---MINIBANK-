<?php
require_once '../../app/Config/config.php';
require_once '../../app/Core/Auth.php';
require_once '../../app/Services/TransactionService.php';

Auth::check();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCSRF($_POST['csrf_token'] ?? '')) die("CSRF failed.");
    
    $accountId = (int)$_POST['account_id'];
    $amount = (float)$_POST['amount'];
    $description = htmlspecialchars($_POST['description']);
    
    $service = new TransactionService();
    $result = $service->withdraw($accountId, $amount, $description);
    
    $_SESSION[$result['success'] ? 'success' : 'error'] = $result['message'];
    header('Location: ' . BASE_URL . 'customer/withdraw.php');
    exit;
}
?>