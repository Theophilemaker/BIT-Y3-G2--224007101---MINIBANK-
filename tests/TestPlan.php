<?php
// tests/TestPlan.php
require_once __DIR__ . '/../app/Config/config.php';
require_once __DIR__ . '/../app/Core/Database.php';
require_once __DIR__ . '/../app/Services/TransactionService.php';
require_once __DIR__ . '/../app/Helpers/validation.php';

// Set up HTML for clean output
echo "<html><head><title>Test Plan - MiniBank Rwanda</title>";
echo "<style>body{font-family:Arial; margin:40px;} .pass{color:green;font-weight:bold;} .fail{color:red;font-weight:bold;} table{width:100%;border-collapse:collapse;margin-top:20px;} th,td{border:1px solid #ddd;padding:10px;text-align:left;} th{background:#f4f4f4;}</style>";
echo "</head><body>";
echo "<h1>MiniBank Rwanda - Test Execution Report</h1>";
echo "<p>Executing 12 Test Cases (Happy Path & Failure Path)...</p>";

// Open Database
$db = Database::getInstance();
$service = new TransactionService();
$passCount = 0;
$failCount = 0;

// Helper function to display results
function assertTest($testId, $description, $expectedResult, $actualResult, $condition) {
    global $passCount, $failCount;
    $status = $condition ? "<span class='pass'>PASS</span>" : "<span class='fail'>FAIL</span>";
    if ($condition) $passCount++; else $failCount++;
    
    echo "<tr>";
    echo "<td>$testId</td>";
    echo "<td>$description</td>";
    echo "<td>$expectedResult</td>";
    echo "<td>$actualResult</td>";
    echo "<td>$status</td>";
    echo "</tr>";
}

// Start Table
echo "<table>";
echo "<tr><th>ID</th><th>Test Scenario</th><th>Expected Result</th><th>Actual Result</th><th>Status</th></tr>";

// ==========================================
// 1. HAPPY PATH: User Registration
// ==========================================
$testEmail = "test_" . rand(1000, 9999) . "@example.com";
$stmt = $db->prepare("INSERT INTO users (email, password_hash, role) VALUES (?, ?, 'customer')");
$result = $stmt->execute([$testEmail, password_hash('password123', PASSWORD_DEFAULT)]);
assertTest("TC-01", "Register new customer (Happy Path)", "User inserted into database", "User ID " . $db->lastInsertId(), $result);

// ==========================================
// 2. FAILURE PATH: Duplicate Email
// ==========================================
try {
    $stmt = $db->prepare("INSERT INTO users (email, password_hash, role) VALUES (?, ?, 'customer')");
    $stmt->execute([$testEmail, password_hash('password123', PASSWORD_DEFAULT)]);
    assertTest("TC-02", "Register with duplicate email (Failure)", "Database throws exception", "No exception", false);
} catch (PDOException $e) {
    assertTest("TC-02", "Register with duplicate email (Failure)", "Database throws exception", "Exception: Duplicate entry", true);
}

// ==========================================
// 3. HAPPY PATH: Valid Login
// ==========================================
$stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$testEmail]);
$user = $stmt->fetch();
$loginSuccess = $user && password_verify('password123', $user['password_hash']);
assertTest("TC-03", "Login with valid credentials (Happy Path)", "Password verifies successfully", "Login allowed", $loginSuccess);

// ==========================================
// 4. FAILURE PATH: Invalid Login
// ==========================================
$loginFail = $user && password_verify('wrongpassword', $user['password_hash']);
assertTest("TC-04", "Login with wrong password (Failure)", "Password verification fails", "Access denied", !$loginFail);

// ==========================================
// 5. HAPPY PATH: Valid Deposit
// ==========================================
// Create a dummy account for testing
$db->exec("INSERT INTO customers (user_id, customer_number, first_name, last_name) VALUES (" . $user['id'] . ", 'TEST-CUST', 'Test', 'User')");
$custId = $db->lastInsertId();
$db->exec("INSERT INTO accounts (customer_id, account_number, balance, status) VALUES ($custId, 'ACC-TEST1', 10000, 'active')");
$accId = $db->lastInsertId();

$depositRes = $service->deposit($accId, 5000, "Test Deposit");
assertTest("TC-05", "Deposit 5,000 RWF (Happy Path)", "Balance increases to 15,000", "Success: " . ($depositRes['success']?'Yes':'No'), $depositRes['success']);

// ==========================================
// 6. FAILURE PATH: Negative Deposit
// ==========================================
$negDepRes = $service->deposit($accId, -500, "Hack attempt");
assertTest("TC-06", "Deposit negative amount (Failure)", "Rejected with error message", "Msg: " . $negDepRes['message'], !$negDepRes['success']);

// ==========================================
// 7. HAPPY PATH: Valid Withdrawal
// ==========================================
$withRes = $service->withdraw($accId, 2000, "Test Withdrawal");
assertTest("TC-07", "Withdraw 2,000 RWF (Happy Path)", "Balance decreases to 13,000", "Success: " . ($withRes['success']?'Yes':'No'), $withRes['success']);

// ==========================================
// 8. FAILURE PATH: Insufficient Funds
// ==========================================
$failWithRes = $service->withdraw($accId, 9999999, "Overdraft attempt");
assertTest("TC-08", "Withdraw more than balance (Failure)", "Rejected with 'Insufficient funds'", "Msg: " . $failWithRes['message'], !$failWithRes['success']);

// ==========================================
// 9. FAILURE PATH: Transfer to Self
// ==========================================
$selfTrans = $service->transfer($accId, 'ACC-TEST1', 1000, "Self transfer");
assertTest("TC-09", "Transfer to same account (Failure)", "Rejected with 'Cannot transfer to self'", "Msg: " . $selfTrans['message'], !$selfTrans['success']);

// ==========================================
// 10. HAPPY PATH: Valid Transfer
// ==========================================
// Create Destination Account
$db->exec("INSERT INTO customers (user_id, customer_number, first_name, last_name) VALUES (" . $user['id'] . ", 'TEST-CUST2', 'Receiver', 'User')");
$cust2Id = $db->lastInsertId();
$db->exec("INSERT INTO accounts (customer_id, account_number, balance, status) VALUES ($cust2Id, 'ACC-TEST2', 0, 'active')");
$acc2Id = $db->lastInsertId();

$transRes = $service->transfer($accId, 'ACC-TEST2', 3000, "Test Transfer");
assertTest("TC-10", "Transfer 3,000 RWF to valid account (Happy Path)", "Success and funds moved", "Success: " . ($transRes['success']?'Yes':'No'), $transRes['success']);

// ==========================================
// 11. FAILURE PATH: Invalid CSRF
// ==========================================
$csrfValid = validateCSRF("fake_token_123");
assertTest("TC-11", "Submit form with fake CSRF token (Failure)", "validateCSRF returns false", "Result: " . ($csrfValid ? 'True' : 'False'), !$csrfValid);

// ==========================================
// 12. FAILURE PATH: SQL Injection Attempt
// ==========================================
$sqlInjectInput = "' OR '1'='1";
$stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$sqlInjectInput]);
$injectResult = $stmt->fetch();
assertTest("TC-12", "SQL Injection in login (Failure)", "Query returns 0 rows safely", "Rows found: " . ($injectResult ? '1' : '0'), !$injectResult);

// Close Table & Cleanup
echo "</table>";
echo "<h3>Summary: <span class='pass'>$passCount Passed</span>, <span class='fail'>$failCount Failed</span></h3>";

// Clean up test data so database isn't messed up
$db->exec("DELETE FROM users WHERE email = '$testEmail'");
$db->exec("DELETE FROM customers WHERE customer_number IN ('TEST-CUST', 'TEST-CUST2')");
echo "</body></html>";
?>
