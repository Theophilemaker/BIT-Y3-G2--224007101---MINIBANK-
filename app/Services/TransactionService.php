<?php
// app/Services/TransactionService.php

class TransactionService {
    private $db;

    public function __construct() { 
        $this->db = Database::getInstance(); 
    }

    private function ref($p) { 
        return $p . '-' . strtoupper(bin2hex(random_bytes(5))); 
    }

    // 1. Deposit Funds
    public function deposit($accId, $amt, $desc) {
        if ($amt <= 0) return ['success' => false, 'message' => 'Amount must be greater than zero.'];
        try {
            $this->db->beginTransaction();
            
            // Check status and lock
            $stmt = $this->db->prepare("SELECT status FROM accounts WHERE id = ? FOR UPDATE");
            $stmt->execute([$accId]);
            if ($stmt->fetchColumn() !== 'active') throw new Exception("Account is inactive or frozen.");
            
            // Update balance
            $this->db->prepare("UPDATE accounts SET balance = balance + ? WHERE id = ?")->execute([$amt, $accId]);
            
            // Record transaction
            $ref = $this->ref('DEP');
            $this->db->prepare("INSERT INTO transactions (reference, account_id, transaction_type, amount, description, status) VALUES (?, ?, 'deposit', ?, ?, 'completed')")
                     ->execute([$ref, $accId, $amt, $desc]);
            
            $this->db->commit();
            Logger::log("Deposit successful: $amt to Account ID $accId", 'TRANSACTION');
            return ['success' => true, 'message' => 'Deposit successful.'];
        } catch (Exception $e) { 
            $this->db->rollBack(); 
            return ['success' => false, 'message' => $e->getMessage()]; 
        }
    }

    // 2. Withdraw Funds
    public function withdraw($accId, $amt, $desc) {
        if ($amt <= 0) return ['success' => false, 'message' => 'Amount must be greater than zero.'];
        try {
            $this->db->beginTransaction();
            
            // Check status and balance, then lock
            $stmt = $this->db->prepare("SELECT balance, status FROM accounts WHERE id = ? FOR UPDATE");
            $stmt->execute([$accId]);
            $acc = $stmt->fetch();
            
            if ($acc['status'] !== 'active') throw new Exception("Account is inactive or frozen.");
            if ($acc['balance'] < $amt) throw new Exception("Insufficient funds.");
            
            // Update balance
            $this->db->prepare("UPDATE accounts SET balance = balance - ? WHERE id = ?")->execute([$amt, $accId]);
            
            // Record transaction
            $ref = $this->ref('WTH');
            $this->db->prepare("INSERT INTO transactions (reference, account_id, transaction_type, amount, description, status) VALUES (?, ?, 'withdrawal', ?, ?, 'completed')")
                     ->execute([$ref, $accId, $amt, $desc]);
            
            $this->db->commit();
            Logger::log("Withdrawal successful: $amt from Account ID $accId", 'TRANSACTION');
            return ['success' => true, 'message' => 'Withdrawal successful.'];
        } catch (Exception $e) { 
            $this->db->rollBack(); 
            return ['success' => false, 'message' => $e->getMessage()]; 
        }
    }

    // 3. Transfer Funds (Fixed Session Issue)
    public function transfer($srcId, $destAccNum, $amt, $desc) {
        if ($amt <= 0) return ['success' => false, 'message' => 'Amount must be greater than zero.'];
        try {
            $this->db->beginTransaction();
            
            // 1. Find destination account
            $stmt = $this->db->prepare("SELECT id, status FROM accounts WHERE account_number = ?");
            $stmt->execute([$destAccNum]);
            $dest = $stmt->fetch();
            
            if (!$dest) throw new Exception("Destination account not found.");
            if ($dest['status'] !== 'active') throw new Exception("Destination account is inactive.");
            if ($dest['id'] == $srcId) throw new Exception("Cannot transfer to the same account.");
            
            // 2. Lock both accounts to prevent race conditions
            $ids = [$srcId, $dest['id']]; 
            sort($ids);
            $stmt = $this->db->prepare("SELECT id, balance, status FROM accounts WHERE id IN (?,?) FOR UPDATE");
            $stmt->execute($ids);
            $accounts = $stmt->fetchAll(PDO::FETCH_UNIQUE | PDO::FETCH_ASSOC);
            
            $source = $accounts[$srcId];
            if ($source['status'] !== 'active') throw new Exception("Your account is inactive.");
            if ($source['balance'] < $amt) throw new Exception("Insufficient funds.");
            
            // 3. Debit Source & Credit Destination
            $this->db->prepare("UPDATE accounts SET balance = balance - ? WHERE id = ?")->execute([$amt, $srcId]);
            $this->db->prepare("UPDATE accounts SET balance = balance + ? WHERE id = ?")->execute([$amt, $dest['id']]);
            
            // 4. Record Double-Entry Transactions
            $ref = $this->ref('TRF');
            
            $this->db->prepare("INSERT INTO transactions (reference, account_id, related_account_id, transaction_type, amount, description, status) VALUES (?, ?, ?, 'transfer', ?, ?, 'completed')")
                     ->execute([$ref.'-OUT', $srcId, $dest['id'], $amt, "Transfer to $destAccNum - $desc"]);
                     
            $this->db->prepare("INSERT INTO transactions (reference, account_id, related_account_id, transaction_type, amount, description, status) VALUES (?, ?, ?, 'transfer', ?, ?, 'completed')")
                     ->execute([$ref.'-IN', $dest['id'], $srcId, $amt, "Transfer from Account ID $srcId - $desc"]);
            
            $this->db->commit();
            Logger::log("Transfer successful: $amt from Acc ID $srcId to Acc ID {$dest['id']}", 'TRANSACTION');
            
            return ['success' => true, 'message' => 'Transfer completed successfully.'];
        } catch (Exception $e) { 
            $this->db->rollBack(); 
            return ['success' => false, 'message' => $e->getMessage()]; 
        }
    }

    // 4. Create New Account
    public function createAccount($userId, $accountType) {
        try {
            // Find customer ID
            $stmt = $this->db->prepare("SELECT id FROM customers WHERE user_id = ?");
            $stmt->execute([$userId]);
            $customer = $stmt->fetch();
            
            if (!$customer) throw new Exception("Customer profile not found.");

            // Generate unique account number
            $accountNumber = 'ACC-' . strtoupper(bin2hex(random_bytes(4)));

            // Insert new account
            $stmt = $this->db->prepare("INSERT INTO accounts (customer_id, account_number, account_type, currency, balance, status) VALUES (?, ?, ?, 'RWF', 0.00, 'active')");
            $stmt->execute([$customer['id'], $accountNumber, $accountType]);

            Logger::log("New $accountType account created: $accountNumber for User ID $userId", 'ACCOUNT');
            return ['success' => true, 'message' => "New $accountType Account ($accountNumber) created successfully!"];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Failed to create account: ' . $e->getMessage()];
        }
    }
}
?>