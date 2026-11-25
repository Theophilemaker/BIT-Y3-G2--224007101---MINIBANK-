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


|| **TEST CASES OF FAILED PATH AND SUCCESSFULL PATH OF PROJECT OF MINIBANK-SYSTEMF ROM STARTING UP TO END** . ||
# Testing Documentation

## 1. Test Strategy
- **Unit Testing:** Automated PHP scripts in the `tests/` folder verify validation and security.
- **Integration Testing:** Manual verification of database transactions and routing.
- **Security Testing:** Attempted SQL Injection, XSS, and CSRF attacks.

## 2. Test Cases

| Test ID | Module | Scenario | Expected Result | Status |
|---------|--------|----------|-----------------|--------|
| TC-01 | Auth | Login with wrong password | Shows "Invalid credentials" error | Pass |
| TC-02 | Auth | Register with existing email | Rejects registration | Pass |
| TC-03 | Deposit | Deposit RWF 10,000 | Balance increases by 10,000 | Pass |
| TC-04 | Withdraw | Withdraw more than balance | Rejects with "Insufficient funds" | Pass |
| TC-05 | Transfer | Transfer to non-existent account | Rejects with "Destination not found" | Pass |
| TC-06 | Transfer | Transfer to self | Rejects with "Cannot transfer to self" | Pass |
| TC-07 | Admin | Add new customer | User and Default Account created | Pass |
| TC-08 | Admin | Delete account with balance > 0 | System blocks deletion | Pass |
| TC-09 | Security | Submit form without CSRF token | Form submission rejected | Pass |
| TC-10 | Security | Inject SQL into login form | Rejected safely via PDO | Pass |


OUTPUT OF SAME ERRORS I HAVE EXPERIENCED WITH AND PASSED 
<img width="893" height="407" alt="image" src="https://github.com/user-attachments/assets/23b86829-1c2d-45d0-b15a-d2f4bbcb7140" />
<img width="899" height="197" alt="image-1" src="https://github.com/user-attachments/assets/e56ca017-be8a-4555-ba97-9ff7c6206024" />
##Register Validation##
1.failed account creation:<img width="945" height="472" alt="image" src="https://github.com/user-attachments/assets/f01a48f7-6bbc-423d-a3bb-b190639f74ff" />
2.passed test
<img width="959" height="476" alt="image" src="https://github.com/user-attachments/assets/ef84c0ab-0044-4ae2-9b08-e5cd593328b5" />
##login validation##
<img width="948" height="466" alt="image" src="https://github.com/user-attachments/assets/4ad43472-28fd-422d-a2d5-1ec83390a016" />
 Same Failed path but solved are:
 1. routing failed but solved :
 2. <img width="952" height="199" alt="image" src="https://github.com/user-attachments/assets/d5124cde-f59e-45ef-9267-f6b12a0c6b46" />
not found file but fixed after.
<img width="469" height="170" alt="image" src="https://github.com/user-attachments/assets/6bfa99b6-727c-4f70-87fd-d23294c59181" />
<img width="929" height="140" alt="image" src="https://github.com/user-attachments/assets/9c0fbd83-e116-4f24-932b-b37bb33905e6" />
 fatal errors on customer statement
<img width="956" height="130" alt="image" src="https://github.com/user-attachments/assets/7ca58f1e-c861-4732-a9b0-5367d0fc5d51" />
wrong path of css (errors:public/style.css and corrected: public/css/style.css.
failed :<img width="938" height="466" alt="image" src="https://github.com/user-attachments/assets/e8de93e7-dbc6-4300-b255-d0720777755c" />
passed corrected: public/css/style.css.
<img width="953" height="475" alt="image" src="https://github.com/user-attachments/assets/7af40a21-c8dd-4752-a14b-85537a8cf02b" />
 test in genera of (authtest,index,securitytest,transactiontest
<img width="860" height="278" alt="image" src="https://github.com/user-attachments/assets/5107a968-beb7-4281-a691-0612e81c1fb7" />
server errors
<img width="833" height="224" alt="Screenshot 2026-11-22 081155" src="https://github.com/user-attachments/assets/6eca52ca-d328-414a-bc3d-02410028ef98" />
same undefined variable cousing this issues
<img width="926" height="439" alt="Screenshot 2026-11-22 081454" src="https://github.com/user-attachments/assets/46b76271-d4cb-4b30-9ca8-df431820168d" />
<img width="932" height="466" alt="Screenshot 2026-11-22 081536" src="https://github.com/user-attachments/assets/d29fa96c-2593-438a-bf09-507c1e66a501" />










 










# BIT-Y3-G2--224007101---MINIBANK-
 An Online Banking Mini System which helps customers to register, deposit, withdraw, view balances, transfer funds, and see transaction history

