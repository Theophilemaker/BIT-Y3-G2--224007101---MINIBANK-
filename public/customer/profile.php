<?php
// public/customer/profile.php
require_once '../../app/Config/config.php';
require_once '../../app/Views/layouts/header.php';
require_once '../../app/Models/User.php'; // <-- FIXED: Missing required class
require_once '../../app/Models/Account.php';

$userModel = new User();
$accountModel = new Account();

$profile = $userModel->getProfile($user['id']);
$accounts = $accountModel->getByCustomer($user['id']);
$totalBalance = $accountModel->getTotalBalance($user['id']);
?>

<div style="max-width: 900px; margin: 0 auto;">
    <!-- Profile Header -->
    <div style="background: linear-gradient(135deg, var(--primary-navy) 0%, var(--primary-blue) 100%); border-radius: 15px; padding: 40px; color: white; display: flex; align-items: center; gap: 30px; margin-bottom: 30px; box-shadow: 0 10px 30px rgba(6,38,92,0.2);">
        <div style="width: 100px; height: 100px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 3rem; font-weight: bold; border: 3px solid white;">
            <?= strtoupper(substr($profile['first_name'], 0, 1) . substr($profile['last_name'], 0, 1)) ?>
        </div>
        <div>
            <h2 style="margin: 0 0 5px 0; font-size: 2rem;"><?= htmlspecialchars($profile['first_name'] . ' ' . $profile['last_name']) ?></h2>
            <p style="margin: 0; opacity: 0.9; font-size: 1.1rem;"><i class="fas fa-id-card"></i> <?= htmlspecialchars($profile['customer_number']) ?></p>
            <p style="margin: 5px 0 0 0; opacity: 0.8;"><i class="fas fa-envelope"></i> <?= htmlspecialchars($profile['email']) ?></p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 20px;">
        <!-- Personal Information -->
        <div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
            <h3 style="color: var(--primary-navy); margin-top: 0; border-bottom: 2px solid #eee; padding-bottom: 10px;">Personal Information</h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 20px;">
                <div>
                    <p style="color: #666; font-size: 0.85rem; margin-bottom: 5px;">First Name</p>
                    <p style="font-weight: 600; color: var(--text-dark); margin: 0;"><?= htmlspecialchars($profile['first_name']) ?></p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.85rem; margin-bottom: 5px;">Last Name</p>
                    <p style="font-weight: 600; color: var(--text-dark); margin: 0;"><?= htmlspecialchars($profile['last_name']) ?></p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.85rem; margin-bottom: 5px;">Phone Number</p>
                    <p style="font-weight: 600; color: var(--text-dark); margin: 0;"><?= htmlspecialchars($profile['phone'] ?? 'N/A') ?></p>
                </div>
                <div>
                    <p style="color: #666; font-size: 0.85rem; margin-bottom: 5px;">Address</p>
                    <p style="font-weight: 600; color: var(--text-dark); margin: 0;"><?= htmlspecialchars($profile['address'] ?? 'N/A') ?></p>
                </div>
            </div>
        </div>

        <!-- Account Summary -->
        <div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
            <h3 style="color: var(--primary-navy); margin-top: 0; border-bottom: 2px solid #eee; padding-bottom: 10px;">Account Summary</h3>
            <div style="margin-top: 20px; text-align: center;">
                <p style="color: #666; font-size: 0.9rem; margin-bottom: 5px;">Total Bank Balance</p>
                <h2 style="color: #28a745; font-size: 2rem; margin: 0 0 15px 0;"><?= formatRWF($totalBalance) ?></h2>
                <p style="color: #666; font-size: 0.9rem;">Active Accounts: <strong><?= count($accounts) ?></strong></p>
            </div>
            <a href="statement.php" class="btn btn-primary" style="display: block; text-align: center; margin-top: 20px; text-decoration: none;"><i class="fas fa-file-pdf"></i> View Statements</a>
        </div>
    </div>
</div>

<?php require_once '../../app/Views/layouts/footer.php'; ?>