USE mini_banking_system;

-- Test Customer 1 (Password: password123)
INSERT INTO users (email, password_hash, role) VALUES 
('john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer');
SET @user1 = LAST_INSERT_ID();

INSERT INTO customers (user_id, customer_number, first_name, last_name, phone, address) VALUES 
(@user1, 'CUST-001', 'John', 'Doe', '+250788111111', 'Kigali');
SET @cust1 = LAST_INSERT_ID();

INSERT INTO accounts (customer_id, account_number, account_type, currency, balance) VALUES 
(@cust1, 'ACC-100100', 'Savings', 'RWF', 500000.00),
(@cust1, 'ACC-100101', 'Current', 'RWF', 250000.00);

-- Test Customer 2 (Password: password123)
INSERT INTO users (email, password_hash, role) VALUES 
('jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer');
SET @user2 = LAST_INSERT_ID();

INSERT INTO customers (user_id, customer_number, first_name, last_name, phone, address) VALUES 
(@user2, 'CUST-002', 'Jane', 'Smith', '+250788222222', 'Kigali');
SET @cust2 = LAST_INSERT_ID();

INSERT INTO accounts (customer_id, account_number, account_type, currency, balance) VALUES 
(@cust2, 'ACC-200200', 'Savings', 'RWF', 1000000.00);