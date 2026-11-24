<?php
// app/Models/Account.php
require_once __DIR__ . '/../Core/Database.php';

class Account {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getByCustomer($userId) {
        $stmt = $this->db->prepare("
            SELECT a.* FROM accounts a 
            JOIN customers c ON a.customer_id = c.id 
            WHERE c.user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getTotalBalance($userId) {
        $stmt = $this->db->prepare("
            SELECT SUM(a.balance) as total FROM accounts a 
            JOIN customers c ON a.customer_id = c.id 
            WHERE c.user_id = ? AND a.status = 'active'
        ");
        $stmt->execute([$userId]);
        $res = $stmt->fetch();
        return $res['total'] ?? 0.00;
    }

    public function getRecentTransactions($userId, $limit = 5) {
        $stmt = $this->db->prepare("
            SELECT t.*, a.account_number 
            FROM transactions t 
            JOIN accounts a ON t.account_id = a.id 
            JOIN customers c ON a.customer_id = c.id 
            WHERE c.user_id = ? 
            ORDER BY t.created_at DESC LIMIT ?
        ");
        $stmt->bindValue(1, $userId, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>