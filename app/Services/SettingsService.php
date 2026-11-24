<?php
// app/Services/SettingsService.php
require_once __DIR__ . '/../Core/Database.php';

class SettingsService {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT setting_key, setting_value FROM system_settings");
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

    public function update($key, $value) {
        $stmt = $this->db->prepare("UPDATE system_settings SET setting_value = ? WHERE setting_key = ?");
        return $stmt->execute([$value, $key]);
    }

    public function updateMultiple($settings) {
        $success = true;
        foreach ($settings as $key => $val) {
            if (!$this->update($key, $val)) {
                $success = false;
            }
        }
        return $success;
    }
}
?>