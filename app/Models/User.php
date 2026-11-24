<?php
// app/Models/User.php
require_once __DIR__ . '/../Core/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

        public function getProfile($userId) {
        $stmt = $this->db->prepare("
            SELECT c.*, u.email, u.status as user_status 
            FROM customers c 
            JOIN users u ON c.user_id = u.id 
            WHERE u.id = ?
        ");
        $stmt->execute([$userId]);
        $profile = $stmt->fetch();
        
        // If no profile is found, return a default empty array
        if (!$profile) {
            return [
                'first_name' => 'Unknown',
                'last_name' => 'Customer',
                'customer_number' => 'N/A',
                'email' => $this->db->query("SELECT email FROM users WHERE id = $userId")->fetchColumn() ?? 'N/A',
                'phone' => 'N/A',
                'address' => 'N/A'
            ];
        }
        
        return $profile;
    }

    public function updateProfile($userId, $data) {
        $stmt = $this->db->prepare("
            UPDATE customers 
            SET first_name = ?, last_name = ?, phone = ?, address = ? 
            WHERE user_id = ?
        ");
        return $stmt->execute([
            $data['first_name'], 
            $data['last_name'], 
            $data['phone'], 
            $data['address'], 
            $userId
        ]);
    }
}
?>