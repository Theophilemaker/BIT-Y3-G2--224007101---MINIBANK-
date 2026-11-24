<?php
// app/Models/Transaction.php
require_once __DIR__ . '/../Core/Database.php';

class Transaction {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllByCustomer($userId) {
        $stmt = $this->db->prepare("
            SELECT t.*, a.account_number 
            FROM transactions t 
            JOIN accounts a ON t.account_id = a.id 
            JOIN customers c ON a.customer_id = c.id 
            WHERE c.user_id = ? 
            ORDER BY t.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getByAccount($accountId) {
        $stmt = $this->db->prepare("SELECT * FROM transactions WHERE account_id = ? ORDER BY created_at DESC");
        $stmt->execute([$accountId]);
        return $stmt->fetchAll();
    }
}
?>