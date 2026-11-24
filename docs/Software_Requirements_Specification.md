# Software Requirements Specification (SRS)
## Project: MiniBank Rwanda
**Version:** 1.0
**Author and developer:** Niragire Theophile (Academic Project)  
**Date:** 24 november 2026

## 1. Introduction
MiniBank Rwanda is a web-based academic banking simulation system designed to demonstrate secure financial workflows, database integrity, and modern UI/UX design. It does not process real money but mimics the exact logic of a commercial bank.

## 2. Functional Requirements
### 2.1 Customer Module
- **FR1:** Customers must be able to register with his/her full name,phone number,address a unique email and secure password.
- **FR2:** Customers can log in  with unique email and passsword securely and are redirected to their dashboard.
- **FR3:** Customers can view their total balance and individual account balances.
- **FR4:** Customers can open multiple accounts (Savings or Current).
- **FR5:** Customers can deposit simulated funds into their accounts.
- **FR6:** Customers can withdraw funds only if they have sufficient balance.
- **FR7:** Customers can transfer funds to other accounts using a unique account number.
- **FR8:** Customers can view a filterable transaction history.
- **FR9:** Customers can generate and print PDF statements.

### 2.2 Administrator Module
- **AR1:** Admins have a separate login that redirects to the Admin Panel.
- **AR2:** Admins can view system-wide statistics (Total Customers, Total Accounts, Total Bank Balance).
- **AR3:** Admins can Add, Edit, Suspend, and Delete Customers.
- **AR4:** Admins can Freeze, Activate, or Delete Bank Accounts.
- **AR5:** Admins can view all transactions in the system.
- **AR6:** Admins can update system branding (Site Name, Slogan, Logo).
- **AR7:** Admins can read and delete Contact Messages.

## 3. Non-Functional Requirements
- **NFR1 (Security):** All passwords must be hashed using Bcrypt. SQL Injection must be prevented using PDO.
- **NFR2 (Integrity):** Financial transfers must use Database Transactions (ACID) with Row Locking to prevent double-spending.
- **NFR3 (Usability):** The UI must be fully responsive (Mobile, Tablet, Desktop) and support a good color scheme.
- **NFR4 (Performance):** Heavy queries (like Admin Reports) must be fast and paginated.
- **NFR5 (Reliability):** The system must log critical errors and admin actions to `storage/logs/`.
