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




