<?php
// app/Controllers/AdminController.php

class AdminController {
    
    // ==========================================
    // 1. SYSTEM SETTINGS (Logo, Slogan, Name)
    // ==========================================
    public function updateSettings() {
        AdminMiddleware::handle();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!validateCSRF($_POST['csrf_token'] ?? '')) die("CSRF failed.");
            
            $db = Database::getInstance();
            foreach(['site_name', 'site_slogan', 'logo_url'] as $key) {
                $stmt = $db->prepare("UPDATE system_settings SET setting_value = ? WHERE setting_key = ?");
                $stmt->execute([sanitize($_POST[$key] ?? ''), $key]);
            }
            Logger::log("Admin updated system settings", 'ADMIN_ACTION');
            Response::withMessage('admin/settings.php', 'success', 'Brand settings updated successfully.');
        }
    }

    // ==========================================
    // 2. CUSTOMER MANAGEMENT (CRUD)
    // ==========================================
    
    // Add New Customer
    public function addCustomer() {
        AdminMiddleware::handle();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!validateCSRF($_POST['csrf_token'] ?? '')) die("CSRF failed.");
            
            $db = Database::getInstance();
            try {
                $db->beginTransaction();
                
                // Create User
                $stmt = $db->prepare("INSERT INTO users (email, password_hash, role, status) VALUES (?, ?, 'customer', 'active')");
                $stmt->execute([sanitize($_POST['email']), password_hash($_POST['password'], PASSWORD_DEFAULT)]);
                $userId = $db->lastInsertId();

                // Create Customer Profile
                $customerNumber = 'CUST-' . strtoupper(bin2hex(random_bytes(3)));
                $stmt = $db->prepare("INSERT INTO customers (user_id, customer_number, first_name, last_name, phone, address) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $userId, 
                    $customerNumber, 
                    sanitize($_POST['first_name']), 
                    sanitize($_POST['last_name']), 
                    sanitize($_POST['phone']), 
                    sanitize($_POST['address'])
                ]);
                $customerId = $db->lastInsertId();

                // Create Default Bank Account
                $accountNumber = 'ACC-' . strtoupper(bin2hex(random_bytes(4)));
                $stmt = $db->prepare("INSERT INTO accounts (customer_id, account_number, account_type, currency, balance) VALUES (?, ?, 'Savings', 'RWF', 0.00)");
                $stmt->execute([$customerId, $accountNumber]);

                $db->commit();
                Logger::log("Admin added new customer: " . $_POST['email'], 'ADMIN_ACTION');
                Response::withMessage('admin/customers.php', 'success', 'Customer added successfully.');
            } catch (Exception $e) {
                $db->rollBack();
                Logger::log("Admin failed to add customer: " . $e->getMessage(), 'ERROR');
                Response::withMessage('admin/customers.php', 'error', 'Failed to add customer. Email might already exist.');
            }
        }
    }

    // Edit Existing Customer
    public function editCustomer() {
        AdminMiddleware::handle();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!validateCSRF($_POST['csrf_token'] ?? '')) die("CSRF failed.");
            
            $db = Database::getInstance();
            $userId = (int)$_POST['user_id'];
            
            try {
                $db->beginTransaction();
                
                // Update User Status
                $stmt = $db->prepare("UPDATE users SET status = ? WHERE id = ? AND role = 'customer'");
                $stmt->execute([sanitize($_POST['status']), $userId]);

                // Update Customer Details
                $stmt = $db->prepare("UPDATE customers SET first_name = ?, last_name = ?, phone = ?, address = ? WHERE user_id = ?");
                $stmt->execute([
                    sanitize($_POST['first_name']), 
                    sanitize($_POST['last_name']), 
                    sanitize($_POST['phone']), 
                    sanitize($_POST['address']), 
                    $userId
                ]);

                $db->commit();
                Logger::log("Admin updated customer ID: $userId", 'ADMIN_ACTION');
                Response::withMessage('admin/customers.php', 'success', 'Customer updated successfully.');
            } catch (Exception $e) {
                $db->rollBack();
                Response::withMessage('admin/customers.php', 'error', 'Failed to update customer.');
            }
        }
    }

    // Delete Customer
    public function deleteCustomer() {
        AdminMiddleware::handle();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!validateCSRF($_POST['csrf_token'] ?? '')) die("CSRF failed.");
            
            $db = Database::getInstance();
            $userId = (int)$_POST['user_id'];
            
            try {
                // Because of ON DELETE CASCADE in schema, deleting the user removes the customer and accounts
                $stmt = $db->prepare("DELETE FROM users WHERE id = ? AND role = 'customer'");
                $stmt->execute([$userId]);
                
                Logger::log("Admin deleted customer ID: $userId", 'ADMIN_ACTION');
                Response::withMessage('admin/customers.php', 'success', 'Customer deleted successfully.');
            } catch (Exception $e) {
                Logger::log("Failed to delete customer ID $userId: " . $e->getMessage(), 'ERROR');
                Response::withMessage('admin/customers.php', 'error', 'Cannot delete customer. They may have active transactions.');
            }
        }
    }

    // ==========================================
    // 3. ACCOUNT MANAGEMENT
    // ==========================================

    // Update Account Status (Active, Frozen, Closed)
    public function updateAccountStatus() {
        AdminMiddleware::handle();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!validateCSRF($_POST['csrf_token'] ?? '')) die("CSRF failed.");
            
            $db = Database::getInstance();
            $accountId = (int)$_POST['account_id'];
            $status = $_POST['status']; // active, frozen, closed

            $stmt = $db->prepare("UPDATE accounts SET status = ? WHERE id = ?");
            $stmt->execute([$status, $accountId]);
            
            Logger::log("Admin changed Account ID $accountId status to $status", 'ADMIN_ACTION');
            Response::withMessage('admin/accounts.php', 'success', 'Account status updated successfully.');
        }
    }

    // Delete Account
       public function deleteAccount() {
        AdminMiddleware::handle();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!validateCSRF($_POST['csrf_token'] ?? '')) {
                die("Security Error: CSRF token validation failed.");
            }
            
            $db = Database::getInstance();
            $accountId = (int)$_POST['account_id'];

            try {
                // Safety Check: Prevent deleting accounts with money
                $stmt = $db->prepare("SELECT balance FROM accounts WHERE id = ?");
                $stmt->execute([$accountId]);
                $acc = $stmt->fetch();

                if ($acc && $acc['balance'] > 0) {
                    Response::withMessage('admin/accounts.php', 'error', 'Cannot delete an account with funds. Withdraw or transfer funds first.');
                    return;
                }

                // Delete the account
                $stmt = $db->prepare("DELETE FROM accounts WHERE id = ?");
                $stmt->execute([$accountId]);
                
                Logger::log("Admin deleted Account ID $accountId", 'ADMIN_ACTION');
                Response::withMessage('admin/accounts.php', 'success', 'Account deleted successfully.');
            } catch (Exception $e) {
                // This catches errors if the account has transactions linked to it
                Response::withMessage('admin/accounts.php', 'error', 'Cannot delete account. It has transaction history.');
            }
        }
    }
}
?>