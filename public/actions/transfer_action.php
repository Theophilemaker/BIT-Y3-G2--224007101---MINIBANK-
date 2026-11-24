<?php
require_once '../../app/Config/config.php';
require_once '../../app/Core/Auth.php';
require_once '../../app/Services/TransactionService.php';

Auth::check();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validateCSRF($_POST['csrf_token'] ?? '')) die("CSRF failed.");
    
    $sourceAccountId = (int)$_POST['source_account_id'];
    $destAccountNumber = htmlspecialchars($_POST['dest_account_number']);
    $amount = (float)$_POST['amount'];
    $description = htmlspecialchars($_POST['description']);
    
    $service = new TransactionService();
    $result = $service->transfer($sourceAccountId, $destAccountNumber, $amount, $description);
    
    $_SESSION[$result['success'] ? 'success' : 'error'] = $result['message'];
    header('Location: ' . BASE_URL . 'customer/transfer.php');
    exit;
}
?>