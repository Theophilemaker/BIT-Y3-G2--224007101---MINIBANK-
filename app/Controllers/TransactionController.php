<?php
// app/Controllers/TransactionController.php
require_once __DIR__ . '/../Services/TransactionService.php';
require_once __DIR__ . '/../Core/Response.php';
require_once __DIR__ . '/../Core/Logger.php';

class TransactionController {
    
    public function createAccount() {
        AuthMiddleware::handle();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!validateCSRF($_POST['csrf_token'] ?? '')) die("CSRF failed.");
            
            $db = Database::getInstance();
            $userId = $_SESSION['user_id'];
            $accountType = sanitize($_POST['account_type']);

            try {
                $stmt = $db->prepare("SELECT id FROM customers WHERE user_id = ?");
                $stmt->execute([$userId]);
                $customer = $stmt->fetch();

                if (!$customer) {
                    Response::withMessage('customer/dashboard.php', 'error', 'Customer profile not found.');
                    return;
                }

                $accountNumber = 'ACC-' . strtoupper(bin2hex(random_bytes(4)));

                $stmt = $db->prepare("INSERT INTO accounts (customer_id, account_number, account_type, currency, balance, status) VALUES (?, ?, ?, 'RWF', 0.00, 'active')");
                $stmt->execute([$customer['id'], $accountNumber, $accountType]);

                Logger::log("Customer created new $accountType account: $accountNumber");
                Response::withMessage('customer/dashboard.php', 'success', "New $accountType Account ($accountNumber) created successfully!");
            } catch (Exception $e) {
                Logger::log("Failed to create account: " . $e->getMessage(), 'ERROR');
                Response::withMessage('customer/dashboard.php', 'error', 'Failed to create account. Please try again.');
            }
        }
    }

    public function deposit() {
        AuthMiddleware::handle();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        $res = (new TransactionService())->deposit((int)$_POST['account_id'], (float)$_POST['amount'], sanitize($_POST['description']));
        Response::withMessage('customer/deposit.php', $res['success'] ? 'success' : 'error', $res['message']);
    }

    public function withdraw() {
        AuthMiddleware::handle();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
        $res = (new TransactionService())->withdraw((int)$_POST['account_id'], (float)$_POST['amount'], sanitize($_POST['description']));
        Response::withMessage('customer/withdraw.php', $res['success'] ? 'success' : 'error', $res['message']);
    }

    public function transfer() {
        AuthMiddleware::handle(); 
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!validateCSRF($_POST['csrf_token'] ?? '')) die("CSRF failed.");
            
            $sourceAccountId = (int)$_POST['source_account_id'];
            $destAccountNumber = sanitize($_POST['dest_account_number']);
            $amount = (float)$_POST['amount'];
            $description = sanitize($_POST['description']);

            $service = new TransactionService();
            $result = $service->transfer($sourceAccountId, $destAccountNumber, $amount, $description);

            if ($result['success']) {
                Response::withMessage('customer/transfer.php', 'success', 'Transfer successful!');
            } else {
                Response::withMessage('customer/transfer.php', 'error', $result['message']);
            }
        }
    }
}