<?php
// app/Services/StatementService.php
require_once __DIR__ . '/../Core/Database.php';

class StatementService {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getStatementData($accountId, $startDate, $endDate) {
        $stmt = $this->db->prepare("
            SELECT t.* 
            FROM transactions t 
            WHERE t.account_id = ? 
              AND DATE(t.created_at) BETWEEN ? AND ? 
            ORDER BY t.created_at ASC
        ");
        $stmt->execute([$accountId, $startDate, $endDate]);
        return $stmt->fetchAll();
    }

    public function getAccountDetails($accountId) {
        $stmt = $this->db->prepare("
            SELECT a.*, c.first_name, c.last_name, c.customer_number 
            FROM accounts a 
            JOIN customers c ON a.customer_id = c.id 
            WHERE a.id = ?
        ");
        $stmt->execute([$accountId]);
        return $stmt->fetch();
    }
}
?>