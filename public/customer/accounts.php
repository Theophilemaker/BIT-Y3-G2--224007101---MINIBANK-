<?php
// public/customer/accounts.php
require_once '../../app/Config/config.php';
require_once '../../app/Views/layouts/header.php';
require_once '../../app/Models/Account.php';

$accountModel = new Account();
$accounts = $accountModel->getByCustomer($user['id']);
$totalBalance = $accountModel->getTotalBalance($user['id']);
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h2 style="color: var(--primary-navy); margin: 0;">My Bank Accounts</h2>
    <button onclick="document.getElementById('openAccountModal').style.display='flex'" class="btn btn-primary">
        <i class="fas fa-plus"></i> Open New Account
    </button>
</div>

<!-- Total Balance Summary -->
<div style="background: linear-gradient(135deg, var(--primary-navy) 0%, var(--primary-blue) 100%); color: white; padding: 30px; border-radius: 12px; margin-bottom: 30px; box-shadow: 0 10px 20px rgba(6,38,92,0.2);">
    <p style="margin: 0; opacity: 0.9; font-size: 1rem;">Total Combined Balance</p>
    <h1 style="margin: 10px 0 0 0; font-size: 2.5rem; font-weight: 800;"><?= formatRWF($totalBalance) ?></h1>
</div>

<!-- Account Cards Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
    <?php if(empty($accounts)): ?>
        <div style="grid-column: 1 / -1; background: white; padding: 40px; text-align: center; border-radius: 12px;">
            <i class="fas fa-wallet fa-3x" style="color: #ddd; margin-bottom: 15px;"></i>
            <h3 style="color: #666; margin: 0;">No Accounts Found</h3>
            <p style="color: #888; margin-top: 5px;">You haven't opened any bank accounts yet.</p>
        </div>
    <?php else: ?>
        <?php foreach($accounts as $acc): ?>
        <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-top: 5px solid <?= $acc['status'] == 'active' ? '#28a745' : '#dc3545' ?>; position: relative; overflow: hidden;">
            
            <!-- Watermark Icon -->
            <i class="fas fa-credit-card" style="position: absolute; right: -10px; bottom: -10px; font-size: 6rem; color: #f4f7f6; opacity: 0.5; z-index: 0;"></i>

            <div style="position: relative; z-index: 1;">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                    <span style="background: var(--light-blue); color: var(--primary-blue); padding: 5px 10px; border-radius: 4px; font-size: 0.8rem; font-weight: 600;">
                        <?= htmlspecialchars($acc['account_type']) ?>
                    </span>
                    <span style="background: <?= $acc['status'] == 'active' ? '#d4edda' : '#f8d7da' ?>; color: <?= $acc['status'] == 'active' ? '#155724' : '#721c24' ?>; padding: 4px 8px; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                        <?= ucfirst($acc['status']) ?>
                    </span>
                </div>
                
                <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Account Number</p>
                <h3 style="color: var(--primary-navy); font-family: monospace; font-size: 1.2rem; margin: 0 0 20px 0; letter-spacing: 1px;">
                    <?= htmlspecialchars($acc['account_number']) ?>
                </h3>
                
                <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0;">Available Balance</p>
                <h2 style="color: var(--primary-blue); margin: 0; font-size: 1.8rem;">
                    <?= formatRWF($acc['balance']) ?>
                </h2>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Open New Account Modal (Same as Dashboard) -->
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