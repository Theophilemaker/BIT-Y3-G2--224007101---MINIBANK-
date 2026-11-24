<?php
// public/customer/statement.php
require_once '../../app/Config/config.php';
require_once '../../app/Views/layouts/header.php';
require_once '../../app/Models/User.php';
require_once '../../app/Models/Account.php';
require_once '../../app/Models/Transaction.php';

$userModel = new User();
$accountModel = new Account();
$txModel = new Transaction();

// Fetch data with fallbacks to prevent "bool" errors
$profile = $userModel->getProfile($user['id']) ?: [];
$accounts = $accountModel->getByCustomer($user['id']) ?: [];

$firstName = $profile['first_name'] ?? 'Customer';
$lastName = $profile['last_name'] ?? '';
$custNumber = $profile['customer_number'] ?? 'N/A';
?>

<!-- Custom Print Styles -->
<style>
    @media print {
        .sidebar, .top-nav, .no-print, .dashboard-footer { display: none !important; }
        .main-content { margin: 0 !important; width: 100% !important; padding: 0 !important; }
        .content-wrapper { padding: 0 !important; }
        body { background: white !important; }
        .print-container { box-shadow: none !important; border: none !important; padding: 0 !important; }
        .print-header { border-bottom: 2px solid #000 !important; }
    }
</style>

<div style="max-width: 900px; margin: 0 auto;">
    
    <!-- Print Button -->
    <div class="no-print" style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center;">
        <h3 style="color: var(--primary-navy); margin: 0;">Account Statements</h3>
        <button onclick="window.print()" class="btn btn-primary"><i class="fas fa-print"></i> Download / Print PDF</button>
    </div>

    <!-- The Printable Document -->
    <div class="print-container" style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.08);">
        
        <!-- Document Header -->
        <div class="print-header" style="display: flex; justify-content: space-between; border-bottom: 3px solid var(--primary-navy); padding-bottom: 20px; margin-bottom: 30px;">
            <div>
                <h1 style="color: var(--primary-navy); margin: 0; font-size: 2rem; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-university"></i> <?= $settings['site_name'] ?? 'MiniBank Rwanda' ?>
                </h1>
                <p style="color: #666; margin: 5px 0 0 0;">Huye, Rwanda | <?= $settings['contact_email'] ?? 'niragire_224007101@stud.ur.ac.rw' ?></p>
            </div>
            <div style="text-align: right;">
                <h3 style="margin: 0; color: var(--text-dark);">Official Statement</h3>
                <p style="color: #666; margin: 5px 0 0 0;">Generated: <?= date('M d, Y H:i') ?></p>
            </div>
        </div>

        <!-- Customer Info -->
        <div style="display: flex; justify-content: space-between; margin-bottom: 30px; background: #f9f9f9; padding: 20px; border-radius: 8px; border: 1px solid #eee;">
            <div>
                <p style="color: #666; font-size: 0.85rem; margin: 0 0 5px 0; text-transform: uppercase;">Customer Name</p>
                <p style="font-weight: bold; font-size: 1.1rem; margin: 0; color: var(--primary-navy);">
                    <?= htmlspecialchars(trim($firstName . ' ' . $lastName)) ?>
                </p>
            </div>
            <div>
                <p style="color: #666; font-size: 0.85rem; margin: 0 0 5px 0; text-transform: uppercase;">Customer Number</p>
                <p style="font-weight: bold; font-size: 1.1rem; margin: 0; color: var(--primary-navy);">
                    <?= htmlspecialchars($custNumber) ?>
                </p>
            </div>
            <div>
                <p style="color: #666; font-size: 0.85rem; margin: 0 0 5px 0; text-transform: uppercase;">Currency</p>
                <p style="font-weight: bold; font-size: 1.1rem; margin: 0; color: var(--primary-navy);">RWF</p>
            </div>
        </div>

        <!-- Accounts Loop -->
        <?php if(empty($accounts)): ?>
            <p style="text-align: center; color: #888; padding: 20px;">No accounts found for this customer.</p>
        <?php else: ?>
            <?php foreach($accounts as $acc): 
                $transactions = $txModel->getByAccount($acc['id']) ?: [];
            ?>
                <div style="margin-bottom: 40px;">
                    <div style="display: flex; justify-content: space-between; align-items: end; margin-bottom: 15px;">
                        <div>
                            <h4 style="color: var(--primary-navy); margin: 0; font-size: 1.2rem;">
                                <?= htmlspecialchars($acc['account_number'] ?? 'N/A') ?> 
                                <span style="font-size: 0.9rem; color: #666; font-weight: normal;">(<?= htmlspecialchars($acc['account_type'] ?? 'N/A') ?>)</span>
                            </h4>
                        </div>
                        <div style="text-align: right;">
                            <p style="color: #666; font-size: 0.85rem; margin: 0;">Closing Balance</p>
                            <h3 style="color: #28a745; margin: 0;"><?= formatRWF($acc['balance'] ?? 0) ?></h3>
                        </div>
                    </div>

                    <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                        <thead>
                            <tr style="background: var(--primary-navy); color: white;">
                                <th style="padding: 12px; text-align: left; border: 1px solid var(--primary-navy);">Date</th>
                                <th style="padding: 12px; text-align: left; border: 1px solid var(--primary-navy);">Reference</th>
                                <th style="padding: 12px; text-align: left; border: 1px solid var(--primary-navy);">Description</th>
                                <th style="padding: 12px; text-align: right; border: 1px solid var(--primary-navy);">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($transactions)): ?>
                                <tr><td colspan="4" style="text-align: center; padding: 20px; color: #888; border: 1px solid #ddd;">No transactions for this account.</td></tr>
                            <?php else: ?>
                                <?php foreach($transactions as $tx): ?>
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #ddd;"><?= date('Y-m-d H:i', strtotime($tx['created_at'])) ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd; font-family: monospace;"><?= htmlspecialchars($tx['reference']) ?></td>
                                    <td style="padding: 10px; border: 1px solid #ddd; text-transform: capitalize;">
                                        <?= htmlspecialchars($tx['transaction_type']) ?> - <?= htmlspecialchars($tx['description']) ?>
                                    </td>
                                    <?php 
                                        $isIncome = ($tx['transaction_type'] == 'deposit') || (strpos($tx['reference'], 'IN') !== false);
                                        $sign = $isIncome ? '+' : '-';
                                        $color = $isIncome ? '#28a745' : '#dc3545';
                                    ?>
                                    <td style="padding: 10px; border: 1px solid #ddd; text-align: right; font-weight: bold; color: <?= $color ?>;">
                                        <?= $sign ?><?= formatRWF($tx['amount']) ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <!-- Footer Note -->
        <div style="margin-top: 50px; border-top: 1px solid #eee; padding-top: 20px; text-align: center; color: #888; font-size: 0.85rem;">
            <p>This is a computer-generated document. No signature is required.</p>
            <p><strong><?= $settings['site_name'] ?? 'MiniBank Rwanda' ?></strong> - <?= $settings['site_slogan'] ?? 'Bank Smart. Live Better.' ?></p>
        </div>
    </div>
</div>

<?php require_once '../../app/Views/layouts/footer.php'; ?>