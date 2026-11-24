<?php
require_once '../../app/Config/config.php';
require_once '../../app/Views/layouts/header.php';
require_once '../../app/Models/Account.php';

$accountModel = new Account();
$accounts = $accountModel->getByCustomer($user['id']);
$totalBalance = $accountModel->getTotalBalance($user['id']);
$recentTx = $accountModel->getRecentTransactions($user['id'], 5);

// Get primary account status
$primaryStatus = !empty($accounts) ? $accounts[0]['status'] : 'N/A';
?>

<!-- Welcome Banner -->
<div style="background: linear-gradient(135deg, var(--primary-navy) 0%, var(--primary-blue) 100%); color: white; padding: 30px; border-radius: 12px; margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 10px 20px rgba(6,38,92,0.2);">
    <div>
        <h2 style="margin: 0 0 10px 0; font-size: 1.8rem;">Welcome Back!</h2>
        <p style="margin: 0; opacity: 0.9; font-size: 1rem;">Here is what's happening with your accounts today.</p>
    </div>
    <i class="fas fa-chart-line fa-3x" style="opacity: 0.3;"></i>
</div>

<!-- Summary Cards -->
             <a href="accounts.php" style="display: flex; align-items: center; gap: 15px; padding: 15px; background: #eaf3ff; color: var(--primary-blue); text-decoration: none; border-radius: 8px; font-weight: 600; transition: 0.2s;">
                <i class="fas fa-wallet fa-lg"></i> View My Accounts
            </a>
<div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
    
    <div class="stat-card" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-left: 5px solid #0866E8;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <h4 style="color: #666; font-size: 0.9rem; text-transform: uppercase; margin-bottom: 10px;">Total Balance</h4>
                <h2 style="color: var(--primary-navy); font-size: 1.8rem; margin: 0;"><?= formatRWF($totalBalance) ?></h2>
            </div>
            <i class="fas fa-wallet" style="font-size: 2rem; color: #0866E8; opacity: 0.2;"></i>
        </div>
    </div>

    <div class="stat-card" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-left: 5px solid #28a745;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <h4 style="color: #666; font-size: 0.9rem; text-transform: uppercase; margin-bottom: 10px;">My Accounts</h4>
                <h2 style="color: var(--primary-navy); font-size: 1.8rem; margin: 0;"><?= count($accounts) ?> <span style="font-size: 1rem; color: #888; font-weight: normal;">Active</span></h2>
            </div>
            <i class="fas fa-credit-card" style="font-size: 2rem; color: #28a745; opacity: 0.2;"></i>
        </div>
    </div>

    <div class="stat-card" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-left: 5px solid #ffc107;">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <h4 style="color: #666; font-size: 0.9rem; text-transform: uppercase; margin-bottom: 10px;">Account Status</h4>
                <h2 style="color: var(--primary-navy); font-size: 1.8rem; margin: 0; text-transform: capitalize;"><?= $primaryStatus ?></h2>
            </div>
            <i class="fas fa-shield-check" style="font-size: 2rem; color: #ffc107; opacity: 0.2;"></i>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
    
    <!-- Recent Transactions Table -->
    <div style="background: white; border-radius: 12px; padding: 25px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3 style="margin: 0; color: var(--primary-navy);">Recent Transactions</h3>
            <a href="history.php" style="color: var(--primary-blue); text-decoration: none; font-size: 0.9rem; font-weight: 600;">View All <i class="fas fa-arrow-right"></i></a>
        </div>
        
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid #eee;">
                    <th style="padding: 12px 0; color: #666; font-weight: 600;">Date</th>
                    <th style="padding: 12px 0; color: #666; font-weight: 600;">Type</th>
                    <th style="padding: 12px 0; color: #666; font-weight: 600;">Amount</th>
                    <th style="padding: 12px 0; color: #666; font-weight: 600;">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($recentTx)): ?>
                    <tr><td colspan="4" style="text-align: center; padding: 30px; color: #888;">No recent transactions found.</td></tr>
                <?php else: ?>
                    <?php foreach($recentTx as $tx): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px 0; color: var(--text-dark);"><?= date('M d, Y', strtotime($tx['created_at'])) ?></td>
                        <td style="padding: 15px 0; text-transform: capitalize; color: var(--text-dark);"><?= $tx['transaction_type'] ?></td>
                        <td style="padding: 15px 0; font-weight: 600; color: <?= $tx['transaction_type'] == 'deposit' ? '#28a745' : '#dc3545' ?>;">
                            <?= $tx['transaction_type'] == 'deposit' ? '+' : '-' ?><?= formatRWF($tx['amount']) ?>
                        </td>
                        <td style="padding: 15px 0;">
                            <span style="background: <?= $tx['status'] == 'completed' ? '#d4edda' : '#f8d7da' ?>; color: <?= $tx['status'] == 'completed' ? '#155724' : '#721c24' ?>; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                <?= ucfirst($tx['status']) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Quick Actions -->
    <div style="background: white; border-radius: 12px; padding: 25px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
        <h3 style="margin: 0 0 20px 0; color: var(--primary-navy);">Quick Actions</h3>
        <div style="display: flex; flex-direction: column; gap: 15px;">
            
            <!-- NEW: Open Account Button -->
            <button onclick="document.getElementById('openAccountModal').style.display='flex'" style="display: flex; align-items: center; gap: 15px; padding: 15px; background: #f0f4ff; color: var(--primary-navy); border: none; border-radius: 8px; font-weight: 600; cursor: pointer; text-align: left; transition: 0.2s;">
                <i class="fas fa-plus-square fa-lg" style="color: var(--primary-blue);"></i> Open New Account
            </button>

            <a href="deposit.php" style="display: flex; align-items: center; gap: 15px; padding: 15px; background: #eaf3ff; color: var(--primary-blue); text-decoration: none; border-radius: 8px; font-weight: 600; transition: 0.2s;">
                <i class="fas fa-plus-circle fa-lg"></i> Deposit Funds
            </a>
            <a href="withdraw.php" style="display: flex; align-items: center; gap: 15px; padding: 15px; background: #fdf2f2; color: #dc3545; text-decoration: none; border-radius: 8px; font-weight: 600; transition: 0.2s;">
                <i class="fas fa-minus-circle fa-lg"></i> Withdraw Funds
            </a>
            <a href="transfer.php" style="display: flex; align-items: center; gap: 15px; padding: 15px; background: #eafaf1; color: #28a745; text-decoration: none; border-radius: 8px; font-weight: 600; transition: 0.2s;">
                <i class="fas fa-exchange-alt fa-lg"></i> Transfer Money
            </a>
            <a href="statement.php" style="display: flex; align-items: center; gap: 15px; padding: 15px; background: #f4f6f8; color: var(--primary-navy); text-decoration: none; border-radius: 8px; font-weight: 600; transition: 0.2s;">
                <i class="fas fa-file-pdf fa-lg"></i> Download Statement
            </a>
        </div>
    </div>

</div>

<!-- NEW: Open New Account Modal -->
<div id="openAccountModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; padding: 30px; border-radius: 12px; width: 90%; max-width: 400px; position: relative; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
        <span onclick="document.getElementById('openAccountModal').style.display='none'" style="position: absolute; top: 15px; right: 20px; font-size: 1.5rem; color: #666; cursor: pointer;">&times;</span>
        
        <div style="text-align: center; margin-bottom: 20px;">
            <i class="fas fa-wallet fa-3x" style="color: var(--primary-blue); margin-bottom: 10px;"></i>
            <h3 style="color: var(--primary-navy); margin: 0;">Open New Account</h3>
            <p style="color: #666; font-size: 0.9rem; margin-top: 5px;">Select the type of account you want to open.</p>
        </div>

        <form action="../../routes/web.php?action=create_account" method="POST">
            <input type="hidden" name="csrf_token" value="<?= generateCSRF() ?>">
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">Account Type</label>
                <select name="account_type" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; outline: none;" required>
                    <option value="Savings">Savings Account</option>
                    <option value="Current">Current Account</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 12px;">Create Account</button>
        </form>
    </div>
</div>

<?php require_once '../../app/Views/layouts/footer.php'; ?>