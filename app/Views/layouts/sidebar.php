<?php
// app/Views/layouts/sidebar.php
$activePage = basename($_SERVER['PHP_SELF'], ".php");
?>
<div class="sidebar">
    <!-- Sidebar Logo -->
    <div class="logo text-white p-3" style="display: flex; align-items: center; gap: 10px; padding: 20px; border-bottom: 1px solid rgba(255,255,255,0.1);">
        <i class="fas fa-university" style="font-size: 1.8rem;"></i>
        <h3 style="font-size: 1.2rem; margin: 0;"><?= $settings['site_name'] ?? 'MiniBank' ?></h3>
    </div>
    
    <!-- Sidebar Menu -->
    <ul class="sidebar-menu" style="padding: 20px 0; flex: 1; overflow-y: auto; display: flex; flex-direction: column; height: calc(100vh - 80px);">
        
        <!-- Home Page Link -->
        <li>
            <!-- Linking to the public homepage (up two directories) -->
            <a href="<?= BASE_URL ?>index.php"><i class="fas fa-home"></i> Home</a>
        </li>

        <li class="<?= $activePage == 'dashboard' ? 'active' : '' ?>">
            <a href="<?= BASE_URL ?>customer/dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
        </li>
        
        <li class="<?= $activePage == 'deposit' ? 'active' : '' ?>">
            <a href="<?= BASE_URL ?>customer/deposit.php"><i class="fas fa-plus-circle"></i> Deposit</a>
        </li>
        <li class="<?= $activePage == 'accounts' ? 'active' : '' ?>">
            <a href="<?= BASE_URL ?>customer/accounts.php"><i class="fas fa-wallet"></i> My Accounts</a>
        </li>
        <li class="<?= $activePage == 'withdraw' ? 'active' : '' ?>">
            <a href="<?= BASE_URL ?>customer/withdraw.php"><i class="fas fa-minus-circle"></i> Withdraw</a>
        </li>
        
        <li class="<?= $activePage == 'transfer' ? 'active' : '' ?>">
            <a href="<?= BASE_URL ?>customer/transfer.php"><i class="fas fa-exchange-alt"></i> Transfer Money</a>
        </li>

        <li class="<?= $activePage == 'history' ? 'active' : '' ?>">
            <a href="<?= BASE_URL ?>customer/history.php"><i class="fas fa-history"></i> Transaction History</a>
        </li>
        
        <li class="<?= $activePage == 'statement' ? 'active' : '' ?>">
            <a href="<?= BASE_URL ?>customer/statement.php"><i class="fas fa-file-pdf"></i> Statements</a>
        </li>
        
        <li class="<?= $activePage == 'profile' ? 'active' : '' ?>">
            <a href="<?= BASE_URL ?>customer/profile.php"><i class="fas fa-user"></i> My Profile</a>
        </li>
        
        <!-- Logout pinned to bottom -->
        <li style="margin-top: auto; border-top: 1px solid rgba(255,255,255,0.1);">
            <a href="<?= BASE_URL ?>logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </li>
    </ul>
</div>