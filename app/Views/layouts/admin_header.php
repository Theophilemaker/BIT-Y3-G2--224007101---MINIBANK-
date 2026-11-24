<?php
// app/Views/layouts/admin_header.php
require_once __DIR__ . '/../../Config/config.php';
require_once __DIR__ . '/../../Core/Auth.php';
require_once __DIR__ . '/../../Middleware/AdminMiddleware.php';

AdminMiddleware::handle();
$settings = getSettings();
$user = Auth::user();
$currentPage = basename($_SERVER['PHP_SELF'], ".php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - <?= ucfirst($currentPage) ?> | <?= $settings['site_name'] ?? 'MiniBank' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="dashboard-body">
    
    <!-- Admin Sidebar -->
    <div class="sidebar">
        <div class="logo text-white p-3" style="display: flex; align-items: center; gap: 10px; padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.1);">
            <i class="fas fa-university" style="font-size: 1.8rem;"></i>
            <h3 style="font-size: 1.2rem; margin: 0;"><?= $settings['site_name'] ?? 'Admin Panel' ?></h3>
        </div>
        
        <ul class="sidebar-menu" style="padding: 20px 0; flex: 1; overflow-y: auto; display: flex; flex-direction: column; height: calc(100vh - 80px);">
            
            <!-- Home Page Link -->
            <li>
                <a href="<?= BASE_URL ?>index.php"><i class="fas fa-home"></i> Home</a>
            </li>

            <li class="<?= $currentPage == 'dashboard' ? 'active' : '' ?>">
                <a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
            </li>
            
            <li class="<?= $currentPage == 'customers' ? 'active' : '' ?>">
                <a href="customers.php"><i class="fas fa-users"></i> Customers</a>
            </li>
            
            <li class="<?= $currentPage == 'accounts' ? 'active' : '' ?>">
                <a href="accounts.php"><i class="fas fa-wallet"></i> Accounts</a>
            </li>
            
            <li class="<?= $currentPage == 'transactions' ? 'active' : '' ?>">
                <a href="transactions.php"><i class="fas fa-exchange-alt"></i> Transactions</a>
            </li>
            
            <li class="<?= $currentPage == 'reports' ? 'active' : '' ?>">
                <a href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a>
            </li>
            
            <li class="<?= $currentPage == 'messages' ? 'active' : '' ?>">
                <a href="messages.php"><i class="fas fa-envelope"></i> Contact Messages</a>
            </li>
            
            <li class="<?= $currentPage == 'settings' ? 'active' : '' ?>">
                <a href="settings.php"><i class="fas fa-cog"></i> System Settings</a>
            </li>
            
            <!-- Logout pinned to bottom -->
            <li style="margin-top: auto; border-top: 1px solid rgba(255,255,255,0.1);">
                <a href="<?= BASE_URL ?>logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
        </ul>
    </div>
    
    <!-- Main Content Area -->
    <div class="main-content">
        <header class="top-nav" style="background: #fff; padding: 15px 30px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <h4 style="color: var(--primary-navy); margin: 0;">Admin Control Panel</h4>
            <div style="display: flex; align-items: center; gap: 10px; font-weight: 600; color: var(--text-dark);">
                <i class="fas fa-user-shield" style="color: var(--primary-blue);"></i>
                <span><?= htmlspecialchars($user['email']) ?></span>
            </div>
        </header>
        
        <div class="content-wrapper" style="padding: 30px; background: #f4f7f6; min-height: calc(100vh - 70px);">
            <?php require_once __DIR__ . '/../partials/alerts.php'; ?>