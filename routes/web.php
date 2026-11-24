<?php
// routes/web.php
require_once __DIR__ . '/../app/Config/config.php';
require_once __DIR__ . '/../app/Core/Response.php';
require_once __DIR__ . '/../app/Core/Auth.php';
require_once __DIR__ . '/../app/Middleware/AuthMiddleware.php';
require_once __DIR__ . '/../app/Middleware/AdminMiddleware.php';

require_once __DIR__ . '/../app/Controllers/AuthController.php';
require_once __DIR__ . '/../app/Controllers/TransactionController.php';
require_once __DIR__ . '/../app/Controllers/AdminController.php';

$action = $_GET['action'] ?? '';

switch ($action) {
    case 'login': (new AuthController)->login(); break;
    case 'register': (new AuthController)->register(); break;
    
    case 'deposit': (new TransactionController)->deposit(); break;
    case 'withdraw': (new TransactionController)->withdraw(); break;
    case 'transfer': (new TransactionController)->transfer(); break;
    case 'create_account': (new TransactionController)->createAccount(); break;

    case 'update_settings': (new AdminController)->updateSettings(); break;
    case 'add_customer': (new AdminController)->addCustomer(); break;
    case 'edit_customer': (new AdminController)->editCustomer(); break;
    case 'delete_customer': (new AdminController)->deleteCustomer(); break;
    case 'update_account_status': (new AdminController)->updateAccountStatus(); break;
    case 'delete_account': (new AdminController)->deleteAccount(); break;

    case 'contact':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!validateCSRF($_POST['csrf_token'] ?? '')) die("CSRF failed.");
            $db = Database::getInstance();
            $stmt = $db->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([
                sanitize($_POST['name']),
                filter_var($_POST['email'], FILTER_SANITIZE_EMAIL),
                sanitize($_POST['subject']),
                sanitize($_POST['message'])
            ]);
            Response::withMessage('index.php#contact', 'success', 'Thank you! Your message has been sent successfully.');
        }
        break;

    default: 
        Response::redirect('index.php'); 
        break;
}