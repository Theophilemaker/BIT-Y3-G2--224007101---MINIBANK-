<?php 
// public/admin/messages.php
require_once '../../app/Views/layouts/admin_header.php'; 

$db = Database::getInstance();

// Handle message deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    if (validateCSRF($_POST['csrf_token'] ?? '')) {
        $stmt = $db->prepare("DELETE FROM contact_messages WHERE id = ?");
        $stmt->execute([(int)$_POST['delete_id']]);
        Response::withMessage('admin/messages.php', 'success', 'Message deleted successfully.');
    }
}

// Fetch all messages
$messages = $db->query("SELECT * FROM contact_messages ORDER BY created_at DESC")->fetchAll();
?>

<div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h3 style="color: var(--primary-navy); margin: 0;">Contact Messages</h3>
        <span style="background: #eaf3ff; color: var(--primary-blue); padding: 5px 15px; border-radius: 20px; font-weight: 600; font-size: 0.9rem;">
            Total: <?= count($messages) ?>
        </span>
    </div>
    
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; min-width: 800px;">
            <thead>
                <tr style="text-align: left; border-bottom: 2px solid #eee; background: #f9f9f9;">
                    <th style="padding: 15px; color: #555;">Date</th>
                    <th style="padding: 15px; color: #555;">Sender</th>
                    <th style="padding: 15px; color: #555;">Subject</th>
                    <th style="padding: 15px; color: #555;">Message</th>
                    <th style="padding: 15px; color: #555; text-align: center;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($messages)): ?>
                    <tr><td colspan="5" style="text-align: center; padding: 40px; color: #888;">No messages found.</td></tr>
                <?php else: ?>
                    <?php foreach($messages as $msg): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 15px; color: #666; font-size: 0.9rem; white-space: nowrap;">
                            <?= date('M d, Y H:i', strtotime($msg['created_at'])) ?>
                        </td>
                        <td style="padding: 15px;">
                            <div style="font-weight: 600; color: var(--text-dark);"><?= htmlspecialchars($msg['name']) ?></div>
                            <div style="font-size: 0.8rem; color: var(--primary-blue);"><?= htmlspecialchars($msg['email']) ?></div>
                        </td>
                        <td style="padding: 15px; font-weight: 500;">
                            <?= htmlspecialchars($msg['subject']) ?>
                        </td>
                        <td style="padding: 15px; color: #555; max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="<?= htmlspecialchars($msg['message']) ?>">
                            <?= htmlspecialchars($msg['message']) ?>
                        </td>
                        <td style="padding: 15px; text-align: center;">
                            <form action="messages.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                <input type="hidden" name="csrf_token" value="<?= generateCSRF() ?>">
                                <input type="hidden" name="delete_id" value="<?= $msg['id'] ?>">
                                <button type="submit" style="background: none; border: none; color: #dc3545; cursor: pointer; transition: 0.2s;" onmouseover="this.style.color='#a71d2a'" onmouseout="this.style.color='#dc3545'">
                                    <i class="fas fa-trash fa-lg"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../../app/Views/layouts/footer.php'; ?>