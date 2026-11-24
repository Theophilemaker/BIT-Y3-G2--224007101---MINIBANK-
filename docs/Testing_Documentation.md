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
 







