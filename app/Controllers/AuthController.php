<?php
class AuthController {
   public function login() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
    if (!validateCSRF($_POST['csrf_token'] ?? '')) Response::withMessage('login.php', 'error', 'Invalid CSRF.');

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $db = Database::getInstance();
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Debugging: If it still fails, you can temporarily add:
    // if (!$user) { die("User not found in database"); }

    if ($user && password_verify($_POST['password'], $user['password_hash'])) {
        // Check if they are suspended
        if ($user['status'] !== 'active') {
            Response::withMessage('login.php', 'error', 'Account suspended.');
        }
        
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['email'] = $user['email'];
        
        Logger::log("Login successful: $email");
        
        // Redirect based on role
        if ($user['role'] === 'admin') {
            Response::redirect('admin/dashboard.php');
        } else {
            Response::redirect('customer/dashboard.php');
        }
    }
    
    Logger::log("Failed login: $email", 'WARNING');
    Response::withMessage('login.php', 'error', 'Invalid credentials.');
}
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        if (!validateCSRF($_POST['csrf_token'] ?? '')) Response::withMessage('register.php', 'error', 'Invalid CSRF.');

        $db = Database::getInstance();
        try {
            $db->beginTransaction();
            $stmt = $db->prepare("INSERT INTO users (email, password_hash, role) VALUES (?, ?, 'customer')");
            $stmt->execute([sanitize($_POST['email']), password_hash($_POST['password'], PASSWORD_DEFAULT)]);
            $userId = $db->lastInsertId();

            $custNum = 'CUST-' . strtoupper(bin2hex(random_bytes(3)));
            $stmt = $db->prepare("INSERT INTO customers (user_id, customer_number, first_name, last_name, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$userId, $custNum, sanitize($_POST['first_name']), sanitize($_POST['last_name']), sanitize($_POST['phone']), sanitize($_POST['address'])]);
            $custId = $db->lastInsertId();

            $accNum = 'ACC-' . strtoupper(bin2hex(random_bytes(4)));
            $stmt = $db->prepare("INSERT INTO accounts (customer_id, account_number, account_type, currency, balance) VALUES (?, ?, 'Savings', 'RWF', 0.00)");
            $stmt->execute([$custId, $accNum]);

            $db->commit();
            Response::withMessage('login.php', 'success', 'Registration successful. Please login.');
        } catch (Exception $e) {
            $db->rollBack();
            Response::withMessage('register.php', 'error', 'Registration failed. Email may exist.');
        }
    }
}
?>