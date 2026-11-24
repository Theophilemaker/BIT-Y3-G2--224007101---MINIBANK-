<?php
$pageTitle = "Transaction History";
$activePage = "history";
require_once '../../app/Views/layouts/header.php';
require_once '../../app/Config/config.php';

$db = Database::getInstance();
$stmt = $db->prepare("
    SELECT t.*, a.account_number 
    FROM transactions t 
    JOIN accounts a ON t.account_id = a.id 
    JOIN customers c ON a.customer_id = c.id 
    WHERE c.user_id = ? 
    ORDER BY t.created_at DESC
");
$stmt->execute([$user['id']]);
$transactions = $stmt->fetchAll();
?>
<div class="card">
    <div class="flex-between">
        <h3>Transaction History</h3>
        <a href="statement.php" class="btn btn-primary" style="font-size: 0.9rem;"><i class="fas fa-file-pdf"></i> Download PDF</a>
    </div>
    
    <table style="width: 100%; margin-top: 20px; border-collapse: collapse;">
        <thead>
            <tr style="text-align: left; border-bottom: 2px solid #eee; background: #f9f9f9;">
                <th style="padding: 12px;">Date</th>
                <th style="padding: 12px;">Reference</th>
                <th style="padding: 12px;">Type</th>
                <th style="padding: 12px;">Amount</th>
                <th style="padding: 12px;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($transactions)): ?>
                <tr><td colspan="5" style="text-align: center; padding: 20px;">No transactions found.</td></tr>
            <?php else: ?>
                <?php foreach($transactions as $tx): ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px;"><?= date('M d, Y H:i', strtotime($tx['created_at'])) ?></td>
                    <td style="padding: 12px; font-family: monospace;"><?= $tx['reference'] ?></td>
                    <td style="padding: 12px; text-transform: capitalize;"><?= $tx['transaction_type'] ?></td>
                    <td style="padding: 12px; font-weight: bold; color: <?= in_array($tx['transaction_type'], ['deposit']) ? '#28a745' : '#dc3545' ?>;">
                        <?= in_array($tx['transaction_type'], ['deposit']) ? '+' : '-' ?><?= formatRWF($tx['amount']) ?>
                    </td>
                    <td style="padding: 12px;">
                        <span style="background: <?= $tx['status'] == 'completed' ? '#d4edda' : '#f8d7da' ?>; color: <?= $tx['status'] == 'completed' ? '#155724' : '#721c24' ?>; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">
                            <?= ucfirst($tx['status']) ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php require_once '../../app/Views/layouts/footer.php'; ?>