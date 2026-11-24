<?php
// public/admin/dashboard.php
require_once __DIR__ . '/../../app/Config/config.php';
require_once __DIR__ . '/../../app/Core/Auth.php';
require_once __DIR__ . '/../../app/Core/Logger.php';

// 1. Ensure only admins can see this page
Auth::check();
if ($_SESSION['role'] !== 'admin') {
    Logger::log("Unauthorized access attempt to Admin Dashboard", 'SECURITY');
    header('Location: ' . BASE_URL . 'login.php');
    exit;
}

// 2. Load Settings (THIS FIXES THE ERROR)
$settings = getSettings();

// 3. Fetch real statistics from the database
$db = Database::getInstance();

$totalCustomers = $db->query("SELECT COUNT(*) FROM users WHERE role = 'customer'")->fetchColumn();
$totalAccounts = $db->query("SELECT COUNT(*) FROM accounts")->fetchColumn();
$totalBalance = $db->query("SELECT SUM(balance) FROM accounts")->fetchColumn() ?? 0;

// Format total balance to Millions (e.g., RWF 12.5M) or full amount
function formatMillions($amount) {
    if ($amount >= 1000000) {
        return 'RWF ' . number_format($amount / 1000000, 1) . 'M';
    }
    return 'RWF ' . number_format($amount, 2);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - <?= $settings['site_name'] ?? 'MiniBank Rwanda' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="dashboard-body">
    
    <!-- Admin Sidebar -->
    <div class="sidebar">
        <div class="logo text-white p-3" style="display: flex; align-items: center; gap: 10px; padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.1);">
            <i class="fas fa-university" style="font-size: 1.8rem;"></i>
            <h3 style="font-size: 1.2rem; margin: 0;"><?= $settings['site_name'] ?? 'MiniBank' ?></h3>
        </div>
        <ul class="sidebar-menu" style="padding: 20px 0;">
            <li class="active"><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="customers.php"><i class="fas fa-users"></i> Customers</a></li>
            <li><a href="accounts.php"><i class="fas fa-wallet"></i> Accounts</a></li>
            <li><a href="transactions.php"><i class="fas fa-exchange-alt"></i> Transactions</a></li>
            <li><a href="settings.php"><i class="fas fa-cog"></i> System Settings</a></li>
            <li style="margin-top: auto; border-top: 1px solid rgba(255,255,255,0.1);">
                <a href="<?= BASE_URL ?>logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header class="top-nav" style="background: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <h4 style="color: var(--primary-navy); margin: 0;">Admin Dashboard</h4>
            <div class="admin-profile" style="display: flex; align-items: center; gap: 10px; font-weight: 600;">
                <i class="fas fa-bell"></i>
                <span><?= $_SESSION['email'] ?></span>
            </div>
        </header>

        <div class="content-wrapper" style="padding: 30px; background: #f4f7f6;">
            
            <?php require_once '../../app/Views/partials/alerts.php'; ?>

            <!-- Stats Grid -->
            <div class="stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
                <div class="stat-card" style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-left: 5px solid var(--primary-blue);">
                    <h4 style="color: #666; font-size: 0.9rem; margin-bottom: 10px; text-transform: uppercase;">Total Customers</h4>
                    <h2 style="color: var(--primary-navy); font-size: 2rem; margin: 0;"><?= number_format($totalCustomers) ?></h2>
                </div>
                <div class="stat-card" style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-left: 5px solid var(--primary-blue);">
                    <h4 style="color: #666; font-size: 0.9rem; margin-bottom: 10px; text-transform: uppercase;">Total Accounts</h4>
                    <h2 style="color: var(--primary-navy); font-size: 2rem; margin: 0;"><?= number_format($totalAccounts) ?></h2>
                </div>
                <div class="stat-card" style="background: white; padding: 25px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); border-left: 5px solid var(--primary-blue);">
                    <h4 style="color: #666; font-size: 0.9rem; margin-bottom: 10px; text-transform: uppercase;">Total Balance</h4>
                    <h2 style="color: var(--primary-navy); font-size: 2rem; margin: 0;"><?= formatMillions($totalBalance) ?></h2>
                </div>
            </div>

            <!-- Settings Form -->
            <div class="card" style="background: white; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
                <h3 style="color: var(--primary-navy); margin-top: 0;">System Settings (Logo & Slogan Control)</h3>
                <p style="color: #666; margin-bottom: 20px;">Update the brand identity across the entire application.</p>
                
                <form action="<?= BASE_URL ?>routes/web.php?action=update_settings" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= generateCSRF() ?>">
                    
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">Site Name</label>
                        <input type="text" name="site_name" value="<?= htmlspecialchars($settings['site_name'] ?? 'MiniBank Rwanda') ?>" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px;" required>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">Site Slogan</label>
                        <input type="text" name="site_slogan" value="<?= htmlspecialchars($settings['site_slogan'] ?? 'Bank Smart. Live Better.') ?>" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px;" required>
                    </div>
                    
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">Logo Image URL</label>
                        <input type="text" name="logo_url" value="<?= htmlspecialchars($settings['logo_url'] ?? 'assets/images/logo.png') ?>" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px;">
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="padding: 12px 25px;">Save Settings</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>