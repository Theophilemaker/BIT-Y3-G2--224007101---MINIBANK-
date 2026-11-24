# Data Flow Diagram (DFD)

## Level 0: Context Diagram
This shows the entire system as a single process interacting with external entities.

```text
       [ CUSTOMER ]                     [ ADMINISTRATOR ]
            |                                   |
            | (Registers, Transfers,            | (Manages Users, 
            |  Deposits, Views Statements)      |  Views Reports, Updates Settings)
            |                                   |
            v                                   v
  +-------------------------------------------------------+
  |                                                       |
  |               MINIBANK RWANDA SYSTEM                  |
  |                                                       |
  +-------------------------------------------------------+
            |                                   |
            | (Sends Notifications,             | (Displays System Stats,
            |  Returns Balances)                |  Shows Customer Data)
            v                                   v
      [ DATABASE (MySQL) ]              [ LOG FILES (Storage) ]