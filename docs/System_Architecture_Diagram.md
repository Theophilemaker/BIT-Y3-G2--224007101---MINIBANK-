# System Architecture Diagram

```text
[ Browser (Client) ]
        |
        | (HTTP POST / GET)
        v
[ routes/web.php ] <-- Central Router
        |
        |---> (Auth) ------------> [ AuthController ] ---> [ User Model ]
        |
        |---> (Transactions) ----> [ TransactionController ] 
        |                              |--> [ TransactionService ] (ACID logic)
        |                              |--> [ Account Model ]
        |
        |---> (Admin) -----------> [ AdminController ]
                                       |--> [ SettingsService ]
                                       |--> [ Logger ] ---> (storage/logs/)
        |
        v
[ MySQL Database (InnoDB) ]