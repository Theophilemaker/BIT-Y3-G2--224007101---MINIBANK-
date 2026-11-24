<?php
// tests/AuthTest.php
require_once __DIR__ . '/../app/Helpers/validation.php';

echo "=== RUNNING AUTH TESTS ===\n";

// Test 1: Email Validation
echo "Test 1: Valid Email... ";
if (validateEmail('test@example.com')) {
    echo "[PASS]\n";
} else {
    echo "[FAIL]\n";
}

echo "Test 2: Invalid Email... ";
if (!validateEmail('invalid-email.com')) {
    echo "[PASS]\n";
} else {
    echo "[FAIL]\n";
}

// Test 3: Password Hashing
echo "Test 3: Password Hash Verification... ";
$password = 'secret123';
$hash = password_hash($password, PASSWORD_DEFAULT);
if (password_verify($password, $hash) && !password_verify('wrongpass', $hash)) {
    echo "[PASS]\n";
} else {
    echo "[FAIL]\n";
}