# System Design Document (SDS)
## Project: MiniBank Rwanda

## 1. System Architecture
The system follows a strict **Model-View-Controller (MVC)** pattern to separate concerns.
- **Models:** Handle database queries (e.g., `User.php`, `Account.php`).
- **Views:** Handle the UI (HTML/CSS inside `app/Views/` and `public/`).
- **Controllers:** Handle form submissions and logic routing (e.g., `AdminController.php`).
- **Services:** Handle complex business logic (e.g., `TransactionService.php`).

## 2. Routing Mechanism
All forms and dynamic actions route through a central front controller: `routes/web.php`. 
Example: A login form submits to `web.php?action=login`, which invokes `AuthController->login()`.

## 3. Database Design (ERD)
The database uses InnoDB with strict Foreign Keys.
- **users** (1) ---- (1) **customers**
- **customers** (1) ---- (N) **accounts**
- **accounts** (1) ---- (N) **transactions**
- **users** (1) ---- (N) **notifications**

## 4. Security Design
- Passwords: `password_hash()` with Bcrypt.
- Forms: CSRF token verification on every `POST` request.
- Database: PDO prepared statements.
- Access Control: `AdminMiddleware` checks `$_SESSION['role']`.