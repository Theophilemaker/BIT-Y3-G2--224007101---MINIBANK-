<?php 
// public/admin/accounts.php
require_once '../../app/Views/layouts/admin_header.php'; 

$db = Database::getInstance();

// Fetch all accounts
$accounts = $db->query("
    SELECT a.*, c.first_name, c.last_name, c.customer_number 
    FROM accounts a 
    JOIN customers c ON a.customer_id = c.id
    ORDER BY a.balance DESC
")->fetchAll();

// Calculate statistics
$totalAccounts = count($accounts);
$totalBalance = 0;
$activeCount = 0;
$frozenCount = 0;

foreach($accounts as $acc) {
    if($acc['status'] === 'active') {
        $totalBalance += $acc['balance'];
        $activeCount++;
    } elseif($acc['status'] === 'frozen') {
        $frozenCount++;
    }
}
?>

<!-- Summary Cards (Same as before) -->
<div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-left: 5px solid var(--primary-blue);">
        <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0; text-transform: uppercase; font-weight: 600;">Total Accounts</p>
        <h2 style="color: var(--primary-navy); margin: 0; font-size: 2rem;"><?= number_format($totalAccounts) ?></h2>
    </div>
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-left: 5px solid #28a745;">
        <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0; text-transform: uppercase; font-weight: 600;">Total Deposited Balance</p>
        <h2 style="color: var(--primary-navy); margin: 0; font-size: 1.6rem;"><?= formatRWF($totalBalance) ?></h2>
    </div>
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-left: 5px solid #17a2b8;">
        <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0; text-transform: uppercase; font-weight: 600;">Active Accounts</p>
        <h2 style="color: var(--primary-navy); margin: 0; font-size: 2rem;"><?= number_format($activeCount) ?></h2>
    </div>
    <div style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-left: 5px solid #ffc107;">
        <p style="color: #666; font-size: 0.9rem; margin: 0 0 5px 0; text-transform: uppercase; font-weight: 600;">Frozen Accounts</p>
        <h2 style="color: var(--primary-navy); margin: 0; font-size: 2rem;"><?= number_format($frozenCount) ?></h2>
    </div>
</div>

<!-- Accounts Table -->
<div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; flex-wrap: wrap; gap: 15px;">
        <h3 style="color: var(--primary-navy); margin: 0; font-size: 1.3rem;">All Bank Accounts</h3>
        <div style="position: relative; width: 300px;">
            <i class="fas fa-search" style="position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #999;"></i>
            <input type="text" id="searchInput" placeholder="Search by Account # or Name..." style="width: 100%; padding: 10px 15px 10px 40px; border: 1px solid #ddd; border-radius: 25px; outline: none; font-size: 0.9rem;">
        </div>
    </div>
    
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; min-width: 900px;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid #eee; background: #f9f9f9;">
                    <th style="padding: 15px; color: #555;">Account #</th>
                    <th style="padding: 15px; color: #555;">Owner</th>
                    <th style="padding: 15px; color: #555;">Type</th>
                    <th style="padding: 15px; color: #555; text-align: right;">Balance</th>
                    <th style="padding: 15px; color: #555; text-align: center;">Status</th>
                    <th style="padding: 15px; color: #555; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody id="accountsTableBody">
                <?php foreach($accounts as $a): ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 15px; font-weight: 600; color: var(--primary-blue); font-family: monospace;">
                        <?= htmlspecialchars($a['account_number']) ?>
                    </td>
                    <td style="padding: 15px; font-weight: 500;">
                        <?= htmlspecialchars($a['first_name'] . ' ' . $a['last_name']) ?>
                    </td>
                    <td style="padding: 15px;"><?= htmlspecialchars($a['account_type']) ?></td>
                    <td style="padding: 15px; font-weight: bold; color: #28a745; text-align: right;">
                        <?= formatRWF($a['balance']) ?>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <?php 
                            $statusColor = $a['status'] == 'active' ? '#d4edda' : ($a['status'] == 'frozen' ? '#fff3cd' : '#f8d7da');
                            $textColor = $a['status'] == 'active' ? '#155724' : ($a['status'] == 'frozen' ? '#856404' : '#721c24');
                        ?>
                        <span style="background: <?= $statusColor ?>; color: <?= $textColor ?>; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                            <?= ucfirst($a['status']) ?>
                        </span>
                    </td>
                    <td style="padding: 15px; text-align: center;">
                        <!-- Action Buttons -->
                        <?php if($a['status'] === 'active'): ?>
                            <!-- Freeze Button -->
                            <form action="../../routes/web.php?action=update_account_status" method="POST" style="display: inline;">
                                <input type="hidden" name="csrf_token" value="<?= generateCSRF() ?>">
                                <input type="hidden" name="account_id" value="<?= $a['id'] ?>">
                                <input type="hidden" name="status" value="frozen">
                                <button type="submit" style="background: none; border: none; color: #ffc107; cursor: pointer; margin-right: 10px;" title="Freeze Account">
                                    <i class="fas fa-lock fa-lg"></i>
                                </button>
                            </form>
                        <?php else: ?>
                            <!-- Activate Button -->
                            <form action="../../routes/web.php?action=update_account_status" method="POST" style="display: inline;">
                                <input type="hidden" name="csrf_token" value="<?= generateCSRF() ?>">
                                <input type="hidden" name="account_id" value="<?= $a['id'] ?>">
                                <input type="hidden" name="status" value="active">
                                <button type="submit" style="background: none; border: none; color: #28a745; cursor: pointer; margin-right: 10px;" title="Activate Account">
                                    <i class="fas fa-unlock fa-lg"></i>
                                </button>
                            </form>
                        <?php endif; ?>

                        <!-- Delete Button -->
                       <!-- Delete Button -->
<form action="../../routes/web.php?action=delete_account" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this account? This cannot be undone.');">
    <input type="hidden" name="csrf_token" value="<?= generateCSRF() ?>">
    <input type="hidden" name="account_id" value="<?= $a['id'] ?>">
    <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer;" title="Delete Account">
        <i class="fas fa-trash fa-lg"></i>
    </button>
</form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#accountsTableBody tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>

<?php require_once '../../app/Views/layouts/footer.php'; ?>