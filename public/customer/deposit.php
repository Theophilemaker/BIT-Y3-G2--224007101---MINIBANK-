<?php
$pageTitle = "Deposit Funds";
$activePage = "deposit";
require_once '../../app/Views/layouts/header.php';
require_once '../../app/Models/Account.php';
$accounts = (new Account())->getByCustomer($user['id']);
?>
<div class="card" style="max-width: 600px; margin: 0 auto;">
    <h3>Deposit Funds</h3>
    <p class="text-muted">Add simulated funds to your account.</p>
    
    <?php if(isset($_SESSION['success'])): ?>
        <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin: 15px 0;"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if(isset($_SESSION['error'])): ?>
        <div style="background: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin: 15px 0;"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>actions/deposit_action.php" method="POST" class="mt-3">
        <input type="hidden" name="csrf_token" value="<?= generateCSRF() ?>">
        <div class="form-group">
            <label>Select Account</label>
            <select name="account_id" class="form-control" required>
                <?php foreach($accounts as $acc): ?>
                    <option value="<?= $acc['id'] ?>"><?= $acc['account_number'] ?> (<?= formatRWF($acc['balance']) ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Amount (RWF)</label>
            <input type="number" name="amount" step="0.01" min="1" class="form-control" required placeholder="e.g. 50000">
        </div>
        <div class="form-group">
            <label>Description</label>
            <input type="text" name="description" class="form-control" placeholder="e.g. Monthly savings" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Confirm Deposit</button>
    </form>
</div>
<?php require_once '../../app/Views/layouts/footer.php'; ?>