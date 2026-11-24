<?php
// tests/TransactionTest.php
require_once __DIR__ . '/../app/Config/config.php';
require_once __DIR__ . '/../app/Services/TransactionService.php';

echo "=== RUNNING TRANSACTION TESTS ===\n";

$service = new TransactionService();

// Test 1: Negative Deposit
echo "Test 1: Reject Negative Deposit... ";
$result = $service->deposit(1, -500, "Hack attempt");
if (!$result['success'] && strpos($result['message'], 'greater than zero') !== false) {
    echo "[PASS]\n";
} else {
    echo "[FAIL]\n";
}

// Test 2: Negative Withdrawal
echo "Test 2: Reject Negative Withdrawal... ";
$result = $service->withdraw(1, -200, "Hack attempt");
if (!$result['success']) {
    echo "[PASS]\n";
} else {
    echo "[FAIL]\n";
}

// Test 3: Transfer to Self
echo "Test 3: Reject Transfer to Self... ";
// Note: This assumes Account 1 exists and has a balance
$result = $service->transfer(1, "ACC-100100", 100, "Self transfer"); 
if (!$result['success'] && strpos($result['message'], 'same account') !== false) {
    echo "[PASS]\n";
} else {
    echo "[FAIL]\n";
}