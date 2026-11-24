# Database Design Document

## 1. Overview
The database `mini_banking_system` uses the **InnoDB** storage engine to support transactions and foreign key constraints. All monetary values use `DECIMAL(18,2)` to prevent floating-point errors.

## 2. Entity Relationship Diagram (ERD)

```text
[users] 
  id (PK)
  email
  password_hash
  role (admin, customer)
  status (active, suspended)
     |
     | 1:1
     v
[customers]
  id (PK)
  user_id (FK -> users.id)
  customer_number
  first_name
  last_name
  phone
  address
     |
     | 1:N
     v
[accounts]
  id (PK)
  customer_id (FK -> customers.id)
  account_number
  account_type (Savings, Current)
  balance (DECIMAL 18,2)
  status (active, frozen, closed)
     |
     | 1:N
     v
[transactions]
  id (PK)
  reference
  account_id (FK -> accounts.id)
  related_account_id (FK -> accounts.id)
  transaction_type (deposit, withdrawal, transfer)
  amount (DECIMAL 18,2)
  description
  status (completed, failed)
  created_at