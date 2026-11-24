<?php
// public/customer/transfer.php
require_once '../../app/Config/config.php';
require_once '../../app/Views/layouts/header.php';
require_once '../../app/Models/Account.php';

$accounts = (new Account())->getByCustomer($user['id']);
?>

<div class="flex-row" style="gap: 20px; max-width: 900px; margin: 0 auto;">
    
    <!-- Transfer Form -->
    <div class="card" style="flex: 1.5;">
        <h3 style="color: var(--primary-navy); margin-top: 0;">Transfer Money</h3>
        <p class="text-muted" style="margin-bottom: 20px;">Send funds securely to another MiniBank account.</p>
        
        <form action="../../routes/web.php?action=transfer" method="POST" class="mt-3">
            <!-- CSRF Token -->
            <input type="hidden" name="csrf_token" value="<?= generateCSRF() ?>">
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">From Account</label>
                <select name="source_account_id" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; outline: none;" required>
                    <?php if(empty($accounts)): ?>
                        <option value="">No active accounts found</option>
                    <?php else: ?>
                        <?php foreach($accounts as $acc): ?>
                            <option value="<?= $acc['id'] ?>">
                                <?= htmlspecialchars($acc['account_number']) ?> - <?= formatRWF($acc['balance']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">To Account Number</label>
                <input type="text" name="dest_account_number" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; outline: none;" required placeholder="e.g. ACC-12345678">
            </div>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">Amount (RWF)</label>
                <input type="number" name="amount" step="0.01" min="1" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; outline: none;" required placeholder="Enter amount">
            </div>
            
            <div class="form-group" style="margin-bottom: 25px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">Description</label>
                <input type="text" name="description" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; outline: none;" placeholder="Reason for transfer" required>
            </div>
            
            <button type="submit" class="btn btn-primary w-100" style="padding: 12px; font-size: 1rem;">
                <i class="fas fa-paper-plane" style="margin-right: 8px;"></i> Send Transfer
            </button>
        </form>
    </div>
    
    <!-- Transfer Tips Sidebar -->
    <div class="card" style="flex: 1; background: #EAF3FF; border-left: 5px solid var(--primary-blue);">
        <h3 style="color: var(--primary-navy); margin-top: 0;">Transfer Tips</h3>
        <ul style="margin-top: 15px; line-height: 2; padding-left: 0; list-style: none;">
            <li style="display: flex; gap: 10px; margin-bottom: 10px;">
                <i class="fas fa-check-circle" style="color: var(--primary-blue); margin-top: 5px;"></i> 
                <span>Ensure the destination account number is exactly correct.</span>
            </li>
            <li style="display: flex; gap: 10px; margin-bottom: 10px;">
                <i class="fas fa-check-circle" style="color: var(--primary-blue); margin-top: 5px;"></i> 
                <span>Verify you have sufficient balance before sending.</span>
            </li>
            <li style="display: flex; gap: 10px; margin-bottom: 10px;">
                <i class="fas fa-check-circle" style="color: var(--primary-blue); margin-top: 5px;"></i> 
                <span>Transfers within MiniBank are secure and instant.</span>
            </li>
        </ul>
    </div>
</div>

<?php require_once '../../app/Views/layouts/footer.php'; ?>