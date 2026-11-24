<?php 
// public/admin/transactions.php

// Load the shared admin header (handles AdminMiddleware security and layout automatically)
require_once '../../app/Views/layouts/admin_header.php'; 

$db = Database::getInstance();

// Fetch all transactions with account details
$txs = $db->query("
    SELECT t.*, a.account_number 
    FROM transactions t 
    JOIN accounts a ON t.account_id = a.id 
    ORDER BY t.created_at DESC LIMIT 100
")->fetchAll();

// Calculate statistics
$totalDeposits = 0;
$totalWithdrawals = 0;
$totalTransfers = 0;

foreach($txs as $tx) {
    if($tx['transaction_type'] === 'deposit') {
        $totalDeposits += $tx['amount'];
    } elseif($tx['transaction_type'] === 'withdrawal') {
        $totalWithdrawals += $tx['amount'];
    } elseif($tx['transaction_type'] === 'transfer') {
        $totalTransfers += $tx['amount'];
    }
}
?>

<!-- Summary Cards -->
<div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px;">
    
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-left: 5px solid #28a745; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0; text-transform: uppercase; font-weight: 600;">Total Deposits</p>
            <h2 style="color: var(--primary-navy); margin: 0; font-size: 1.6rem;"><?= formatRWF($totalDeposits) ?></h2>
        </div>
        <div style="background: #eafaf1; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #28a745;">
            <i class="fas fa-arrow-down fa-lg"></i>
        </div>
    </div>

    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-left: 5px solid #dc3545; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0; text-transform: uppercase; font-weight: 600;">Total Withdrawals</p>
            <h2 style="color: var(--primary-navy); margin: 0; font-size: 1.6rem;"><?= formatRWF($totalWithdrawals) ?></h2>
        </div>
        <div style="background: #fdf2f2; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #dc3545;">
            <i class="fas fa-arrow-up fa-lg"></i>
        </div>
    </div>

    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-left: 5px solid #0866E8; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0; text-transform: uppercase; font-weight: 600;">Total Transfers</p>
            <h2 style="color: var(--primary-navy); margin: 0; font-size: 1.6rem;"><?= formatRWF($totalTransfers) ?></h2>
        </div>
        <div style="background: #eaf3ff; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #0866E8;">
            <i class="fas fa-exchange-alt fa-lg"></i>
        </div>
    </div>
</div>

<!-- Transactions Table -->
<div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
        <h3 style="color: var(--primary-navy); margin: 0; font-size: 1.3rem;">System Transaction Ledger</h3>
        
        <div style="position: relative; width: 300px;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #999;"></i>
            <input type="text" id="searchInput" placeholder="Search by Ref, Account, or Type..." 
                   style="width: 100%; padding: 10px 15px 10px 40px; border: 1px solid #ddd; border-radius: 25px; outline: none; font-size: 0.9rem;">
        </div>
    </div>
    
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid #eee; background: #f9f9f9;">
                    <th style="padding: 15px; color: #555; font-weight: 600;">Date & Time</th>
                    <th style="padding: 15px; color: #555; font-weight: 600;">Reference</th>
                    <th style="padding: 15px; color: #555; font-weight: 600;">Account #</th>
                    <th style="padding: 15px; color: #555; font-weight: 600;">Description</th>
                    <th style="padding: 15px; color: #555; font-weight: 600;">Type</th>
                    <th style="padding: 15px; color: #555; font-weight: 600; text-align: right;">Amount</th>
                </tr>
            </thead>
            <tbody id="transactionsTableBody">
                <?php if(empty($txs)): ?>
                    <tr><td colspan="6" style="text-align: center; padding: 30px; color: #888;">No transactions found in the system.</td></tr>
                <?php else: ?>
                    <?php foreach($txs as $tx): ?>
                    <tr style="border-bottom: 1px solid #eee; transition: background 0.2s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='white'">
                        <td style="padding: 15px; color: #555; font-size: 0.9rem;">
                            <?= date('M d, Y H:i A', strtotime($tx['created_at'])) ?>
                        </td>
                        <td style="padding: 15px; font-family: monospace; color: #666; font-size: 0.9rem;">
                            <?= htmlspecialchars($tx['reference']) ?>
                        </td>
                        <td style="padding: 15px; font-weight: 600; color: var(--primary-blue);">
                            <?= htmlspecialchars($tx['account_number']) ?>
                        </td>
                        <td style="padding: 15px; color: #666; font-size: 0.9rem;">
                            <?= htmlspecialchars($tx['description']) ?>
                        </td>
                        <td style="padding: 15px;">
                            <?php 
                                $typeColor = 'background: #eee; color: #333;';
                                if($tx['transaction_type'] == 'deposit') $typeColor = 'background: #eafaf1; color: #28a745;';
                                if($tx['transaction_type'] == 'withdrawal') $typeColor = 'background: #fdf2f2; color: #dc3545;';
                                if($tx['transaction_type'] == 'transfer') $typeColor = 'background: #eaf3ff; color: #0866E8;';
                            ?>
                            <span style="<?= $typeColor ?> padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; text-transform: capitalize;">
                                <?= htmlspecialchars($tx['transaction_type']) ?>
                            </span>
                        </td>
                        <td style="padding: 15px; font-weight: bold; text-align: right; color: <?= in_array($tx['transaction_type'], ['deposit']) ? '#28a745' : '#dc3545' ?>;">
                            <?= in_array($tx['transaction_type'], ['deposit']) ? '+' : '-' ?><?= formatRWF($tx['amount']) ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Live Search Script -->
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#transactionsTableBody tr');
        
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            if (text.includes(filter)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

<?php require_once '../../app/Views/layouts/footer.php'; ?>