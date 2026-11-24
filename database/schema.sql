CREATE DATABASE IF NOT EXISTS mini_banking_system;
USE mini_banking_system;

CREATE TABLE users (id INT AUTO_INCREMENT PRIMARY KEY, email VARCHAR(100) UNIQUE NOT NULL, password_hash VARCHAR(255) NOT NULL, role ENUM('admin', 'customer') DEFAULT 'customer', status ENUM('active', 'suspended') DEFAULT 'active', created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE customers (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, customer_number VARCHAR(20) UNIQUE NOT NULL, first_name VARCHAR(50), last_name VARCHAR(50), phone VARCHAR(20), address TEXT, FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE);
CREATE TABLE accounts (id INT AUTO_INCREMENT PRIMARY KEY, customer_id INT NOT NULL, account_number VARCHAR(20) UNIQUE NOT NULL, account_type ENUM('Savings', 'Current') DEFAULT 'Savings', currency VARCHAR(3) DEFAULT 'RWF', balance DECIMAL(18,2) DEFAULT 0.00, status ENUM('active', 'frozen', 'closed') DEFAULT 'active', FOREIGN KEY (customer_id) REFERENCES customers(id));
CREATE TABLE transactions (id INT AUTO_INCREMENT PRIMARY KEY, reference VARCHAR(50) UNIQUE NOT NULL, account_id INT NOT NULL, related_account_id INT NULL, transaction_type ENUM('deposit', 'withdrawal', 'transfer', 'reversal') NOT NULL, amount DECIMAL(18,2) NOT NULL, description VARCHAR(255), status ENUM('pending', 'completed', 'failed') DEFAULT 'completed', created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, FOREIGN KEY (account_id) REFERENCES accounts(id));
CREATE TABLE system_settings (id INT AUTO_INCREMENT PRIMARY KEY, setting_key VARCHAR(50) UNIQUE, setting_value TEXT);
CREATE TABLE notifications (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT NOT NULL, title VARCHAR(100), message TEXT, is_read TINYINT(1) DEFAULT 0, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE audit_logs (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT, action VARCHAR(100), details TEXT, ip_address VARCHAR(45), created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);

INSERT INTO system_settings (setting_key, setting_value) VALUES ('site_name', 'MiniBank Rwanda'), ('site_slogan', 'Bank Smart. Live Better.'), ('contact_phone', '+250 788 000 000'), ('contact_email', 'support@minibank.rw');
INSERT INTO users (email, password_hash, role) VALUES ('admin@minibank.rw', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');