-- ==========================================
-- MINIBANK RWANDA - SEED DATA (TEST RECORDS)
-- ==========================================
USE mini_banking_system;

-- 1. TEST CUSTOMERS
-- Passwords: tuyizere12, theophilen, samson123
INSERT INTO `users` (`id`, `email`, `password_hash`, `role`, `status`, `created_at`) VALUES
(4, 'tuyizere@gmail.com', '$2y$10$4svgXdUEFV95iz1bN/RO7unghKd3Q/w7BGidNjRl8KOKFSbyISHse', 'customer', 'active', '2026-11-23 18:29:15'),
(5, 'theophilen298@gmail.com', '$2y$10$ts.alUgwkkTporwZ0wzuKO/UHTocLvbSP/TJnHPzKu31hzECtbFry', 'customer', 'active', '2026-11-23 18:33:20'),
(6, 'samson298@gmail.com', '$2y$10$iWieXoRUQhVHIQUUyv5LpuBAkqDSKtCLYn9.MamDDg/mN/GSetm5K', 'customer', 'active', '2026-11-23 19:03:32');

INSERT INTO `customers` (`id`, `user_id`, `customer_number`, `first_name`, `last_name`, `phone`, `address`, `created_at`) VALUES
(3, 4, 'CUST-8DE7D1', 'Delphine', 'Tuyizere', '0738084659', 'huye-mukoni', '2026-11-23 18:29:15'),
(4, 5, 'CUST-55C9CE', 'NIRAGIRE', 'theophile', '0793473101', 'rulindo district,', '2026-11-23 18:33:20'),
(5, 6, 'CUST-9425F7', 'Tuyisingize', 'Samson', '0790098357', 'Kigali, Gasabo,Jabana', '2026-11-23 19:03:32');

-- 2. TEST ACCOUNTS
INSERT INTO `accounts` (`id`, `customer_id`, `account_number`, `account_type`, `currency`, `balance`, `status`, `created_at`) VALUES
(4, 3, 'ACC-02A1BADA', 'Savings', 'RWF', 47600.00, 'active', '2026-11-23 18:29:15'),
(5, 4, 'ACC-7E40CBB1', 'Savings', 'RWF', 27400.18, 'active', '2026-11-23 18:33:20'),
(6, 5, 'ACC-1317EBE5', 'Savings', 'RWF', 119899.90, 'active', '2026-11-23 19:03:32'),
(7, 5, 'ACC-43C08F2E', 'Savings', 'RWF', 0.00, 'active', '2026-11-23 19:09:16'),
(8, 4, 'ACC-73EED83C', 'Savings', 'RWF', 0.00, 'active', '2026-11-23 20:26:14'),
(9, 4, 'ACC-77F3FEB4', 'Savings', 'RWF', 0.00, 'active', '2026-11-23 21:15:05'),
(10, 4, 'ACC-250A61F7', 'Savings', 'RWF', 0.00, 'active', '2026-11-24 05:17:47');

-- 3. TEST TRANSACTIONS
INSERT INTO `transactions` (`id`, `reference`, `account_id`, `related_account_id`, `transaction_type`, `amount`, `description`, `status`, `created_at`) VALUES
(5, 'DEP-E0C6529DA6', 4, NULL, 'deposit', 50000.00, 'monthly income', 'completed', '2026-11-23 18:30:51'),
(6, 'WTH-7C9FFB76BC', 4, NULL, 'withdrawal', 3000.00, 'debit card', 'completed', '2026-11-23 18:31:21'),
(7, 'DEP-01E7D0FE8E', 5, NULL, 'deposit', 20000.00, 'monthly salary', 'completed', '2026-11-23 18:34:04'),
(8, 'TRF-4C50C015B7-OUT', 5, 4, 'transfer', 600.00, 'Transfer to ACC-02A1BADA - gift', 'completed', '2026-11-23 18:59:04'),
(9, 'TRF-4C50C015B7-IN', 4, 5, 'transfer', 600.00, 'Transfer from Account ID 5 - gift', 'completed', '2026-11-23 18:59:04'),
(10, 'DEP-D2CD865EF8', 5, NULL, 'deposit', 8900.00, 'gift from friends', 'completed', '2026-11-23 19:01:17'),
(11, 'DEP-A44EDA8732', 6, NULL, 'deposit', 80000.08, '2 monthly bursary', 'completed', '2026-11-23 19:05:51'),
(12, 'WTH-6FB63C85F1', 6, NULL, 'withdrawal', 18000.00, 'mobile money', 'completed', '2026-11-23 19:06:49'),
(13, 'TRF-8490AA385F-OUT', 6, 5, 'transfer', 2000.08, 'Transfer to ACC-7E40CBB1 - support', 'completed', '2026-11-23 19:07:46'),
(14, 'TRF-8490AA385F-IN', 5, 6, 'transfer', 2000.08, 'Transfer from Account ID 6 - support', 'completed', '2026-11-23 19:07:46'),
(15, 'DEP-E4BCFE5EC2', 6, NULL, 'deposit', 2000.00, 'gift', 'completed', '2026-11-23 19:21:37'),
(16, 'WTH-E21A8A7238', 6, NULL, 'withdrawal', 10000.00, 'mobile money', 'completed', '2026-11-23 19:22:30'),
(17, 'DEP-29F0471074', 5, NULL, 'deposit', 5000.00, 'gift', 'completed', '2026-11-23 19:30:20'),
(18, 'WTH-A4F0D6A7D3', 5, NULL, 'withdrawal', 5000.00, 'mobile money', 'completed', '2026-11-23 19:31:19'),
(19, 'TRF-C6114D6D2E-OUT', 5, 6, 'transfer', 10000.00, 'Transfer to ACC-1317EBE5 - rental cost', 'completed', '2026-11-23 19:32:19'),
(20, 'TRF-C6114D6D2E-IN', 6, 5, 'transfer', 10000.00, 'Transfer from Account ID 5 - rental cost', 'completed', '2026-11-23 19:32:19'),
(21, 'DEP-760F26A2CE', 5, NULL, 'deposit', 5000.00, 'gift from friends', 'completed', '2026-11-23 20:23:24'),
(22, 'WTH-3EE192204A', 5, NULL, 'withdrawal', 5000.00, 'mobile money', 'completed', '2026-11-23 20:23:51'),
(23, 'TRF-BAC08C791D-OUT', 5, 6, 'transfer', 10000.00, 'Transfer to ACC-1317EBE5 - rental cost', 'completed', '2026-11-23 20:25:04'),
(24, 'TRF-BAC08C791D-IN', 6, 5, 'transfer', 10000.00, 'Transfer from Account ID 5 - rental cost', 'completed', '2026-11-23 20:25:04'),
(25, 'DEP-FC0A331B11', 5, NULL, 'deposit', 5000.00, 'gift', 'completed', '2026-11-23 20:46:49'),
(26, 'WTH-B511D9AA41', 5, NULL, 'withdrawal', 5000.00, 'mobile money', 'completed', '2026-11-23 20:47:12'),
(27, 'TRF-1CA40C6DBB-OUT', 5, 6, 'transfer', 1000.00, 'Transfer to ACC-1317EBE5 - gift', 'completed', '2026-11-23 21:11:09'),
(28, 'TRF-1CA40C6DBB-IN', 6, 5, 'transfer', 1000.00, 'Transfer from Account ID 5 - gift', 'completed', '2026-11-23 21:11:09'),
(29, 'TRF-B25EF6EC15-OUT', 5, 6, 'transfer', 1899.90, 'Transfer to ACC-1317EBE5 - salary on october', 'completed', '2026-11-23 21:11:53'),
(30, 'TRF-B25EF6EC15-IN', 6, 5, 'transfer', 1899.90, 'Transfer from Account ID 5 - salary on october', 'completed', '2026-11-23 21:11:53'),
(31, 'DEP-35CBAFBFA6', 5, NULL, 'deposit', 10000.00, 'gift from friends', 'completed', '2026-11-23 21:14:50'),
(32, 'WTH-25D89D4FCD', 5, NULL, 'withdrawal', 5000.00, 'debit card', 'completed', '2026-11-23 21:15:30'),
(33, 'TRF-E6438D5377-OUT', 5, 6, 'transfer', 5000.00, 'Transfer to ACC-1317EBE5 - support', 'completed', '2026-11-23 21:16:08'),
(34, 'TRF-E6438D5377-IN', 6, 5, 'transfer', 5000.00, 'Transfer from Account ID 5 - support', 'completed', '2026-11-23 21:16:08'),
(35, 'DEP-80447878FB', 5, NULL, 'deposit', 40000.00, 'bursary november', 'completed', '2026-11-24 05:17:18'),
(36, 'WTH-B7CF179E0B', 5, NULL, 'withdrawal', 10000.00, 'debit card', 'completed', '2026-11-24 05:18:29'),
(37, 'TRF-573072C703-OUT', 5, 6, 'transfer', 10000.00, 'Transfer to ACC-1317EBE5 - support money', 'completed', '2026-11-24 05:19:37'),
(38, 'TRF-573072C703-IN', 6, 5, 'transfer', 10000.00, 'Transfer from Account ID 5 - support money', 'completed', '2026-11-24 05:19:37'),
(39, 'TRF-33CD4638FF-OUT', 5, 6, 'transfer', 10000.00, 'Transfer to ACC-1317EBE5 - support money', 'completed', '2026-11-24 05:19:57'),
(40, 'TRF-33CD4638FF-IN', 6, 5, 'transfer', 10000.00, 'Transfer from Account ID 5 - support money', 'completed', '2026-11-24 05:19:57'),
(41, 'DEP-25E3AC12B0', 5, NULL, 'deposit', 40000.00, 'bursary november', 'completed', '2026-11-24 05:42:44'),
(42, 'WTH-2347F1B6AB', 5, NULL, 'withdrawal', 5000.00, 'debit card', 'completed', '2026-11-24 05:43:44'),
(43, 'TRF-65E42D08BA-OUT', 5, 6, 'transfer', 10000.00, 'Transfer to ACC-1317EBE5 - support money', 'completed', '2026-11-24 05:44:28'),
(44, 'TRF-65E42D08BA-IN', 6, 5, 'transfer', 10000.00, 'Transfer from Account ID 5 - support money', 'completed', '2026-11-24 05:44:28'),
(45, 'DEP-A8AF68FD60', 5, NULL, 'deposit', 5000.00, 'gift from friends', 'completed', '2026-11-24 05:53:12'),
(46, 'WTH-81F76F72D0', 5, NULL, 'withdrawal', 10000.00, 'mobile money', 'completed', '2026-11-24 05:54:00'),
(47, 'TRF-FA6214C332-OUT', 5, 6, 'transfer', 10000.00, 'Transfer to ACC-1317EBE5 - support money', 'completed', '2026-11-24 05:54:52'),
(48, 'TRF-FA6214C332-IN', 6, 5, 'transfer', 10000.00, 'Transfer from Account ID 5 - support money', 'completed', '2026-11-24 05:54:52');

-- 4. TEST CONTACT MESSAGES
INSERT INTO `contact_messages` (`id`, `name`, `email`, `subject`, `message`, `status`, `created_at`) VALUES
(1, 'Alice Mukamana', 'alice@gmail.com', 'Account Opening', 'Hello, I would like to know the requirements to open a current account.', 'unread', '2026-11-23 18:21:03'),
(2, 'Bob Habimana', 'bob@yahoo.com', 'Transfer Issue', 'My transfer to Jane has been pending for 10 minutes. Please assist.', 'unread', '2026-11-23 18:21:03');
