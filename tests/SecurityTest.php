<?php
// tests/SecurityTest.php
session_start();
require_once __DIR__ . '/../app/Config/config.php';

echo "=== RUNNING SECURITY TESTS ===\n";

// Test 1: CSRF Token
echo "Test 1: CSRF Token Generation... ";
$token = generateCSRF();
if (strlen($token) === 64 && validateCSRF($token)) {
    echo "[PASS]\n";
} else {
    echo "[FAIL]\n";
}

// Test 2: XSS Sanitization
echo "Test 2: XSS Script Sanitization... ";
$malicious = "<script>alert('hack');</script>Hello";
$clean = sanitize($malicious);
if ($clean === "Hello") {
    echo "[PASS]\n";
} else {
    echo "[FAIL] Output was: $clean\n";
}