# 🏦 MiniBank Rwanda

**Academic Banking Simulation System**

A full-stack, secure, and responsive online banking management system built with **Core PHP (OOP)**, **MySQL**, **Vanilla JavaScript**, and **Pure CSS**. This project simulates real-world banking workflows, emphasizing database integrity, atomic transactions, and role-based access control.

![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-blue)
![MySQL](https://img.shields.io/badge/MySQL-8.0%2B-orange)
![Architecture](https://img.shields.io/badge/Architecture-MVC-green)
![License](https://img.shields.io/badge/License-Academic-lightgrey)

---

## 🚀 Features

- **Authentication:** Secure registration, login, and logout with Bcrypt password hashing and CSRF protection.
- **Customer Dashboard:** Real-time balance tracking, multi-account management (Savings/Current), and quick actions.
- **Transactions:** Secure deposits, withdrawals, and double-entry atomic money transfers.
- **Statements:** Generate and print professional PDF bank statements.
- **Admin Panel:** Complete control over customers, accounts, transactions, system settings (logo/slogan), and contact messages.
- **Contact Form:** Public contact form with messages saved directly to the admin database.

---

## 🛠️ Setup Instructions (XAMPP on Windows)

### 1. Server Setup
1. Open the **XAMPP Control Panel**.
2. Start **Apache** and **MySQL**.
3. Copy the entire `minibank-rwanda` folder into your XAMPP web root directory:
   `C:\xampp\htdocs\`

### 2. Database Setup
1. Open your browser and go to `http://localhost/phpmyadmin/`.
2. Create a new database named exactly: `mini_banking_system`.
3. Click the **Import** tab.
4. Choose the file `database/schema.sql` and click **Go**.
5. (Optional) Import `database/seed.sql` to add test customers.

### 3. Environment Configuration
1. Open the project folder and locate the `.env` file (if it doesn't exist, rename `.env.example` to `.env`).
2. Open `.env` in a text editor (like VS Code or Notepad) and update your database credentials:
   ```env
   APP_ENV=development
   APP_URL=http://localhost/minibank-rwanda/public/
   
   DB_HOST=localhost
   DB_NAME=mini_banking_system
   DB_USER=root
   DB_PASS=
  
4. Run the Application
Open your browser and go to:
http://localhost/minibank-rwanda/public/

🔐 Default Credentials
Administrator Account
URL: http://localhost/minibank-rwanda/public/login.php

Email: niragire_224007101@stud.ur.ac.rw

Password: 15@theo20004n

Test Customer Accounts
Customer 1:

Name: Delphine Tuyizere

Email: tuyizere@gmail.com

Password: tuyizere12

Customer 2:

Name: Samson Tuyisingize

Email: samson298@gmail.com

Password: samson123

📁 Project Structure
This project follows a strict MVC-inspired architecture:

app/ - Core logic, Controllers, Models, Services, and Views.

database/ - SQL schema and seed files.

public/ - The web root (index, login, assets).

routes/ - Central routing logic (web.php).

storage/ - Logs, cache, and temporary generated PDFs.

🛡️ Security Implementations
Password Hashing: Bcrypt (password_hash()).

SQL Injection: PDO Prepared Statements.

XSS Protection: Output escaping and input sanitization.

CSRF Protection: Unique tokens generated for every form.

Database Transactions: beginTransaction() and FOR UPDATE locks for money transfers.
|| Rest cases of project from starting up to end ||


# BIT-Y3-G2--224007101---MINIBANK-
 An Online Banking Mini System which helps customers to register, deposit, withdraw, view balances, transfer funds, and see transaction history

