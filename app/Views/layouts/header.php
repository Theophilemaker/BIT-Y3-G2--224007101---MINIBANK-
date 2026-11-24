<?php
// app/Views/layouts/header.php
require_once __DIR__ . '/../../Config/config.php';
require_once __DIR__ . '/../../Core/Auth.php';
Auth::check();
$user = Auth::user();
$settings = getSettings();
$activePage = basename($_SERVER['PHP_SELF'], ".php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ucfirst($activePage) ?> - <?= $settings['site_name'] ?? 'MiniBank Rwanda' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="dashboard-body">
    
    <!-- Load Sidebar -->
    <?php require_once __DIR__ . '/sidebar.php'; ?>

    <div class="main-content">
        <header class="top-nav">
            <h4>Welcome back, <?= $user['email'] ?></h4>
            <div class="admin-profile">
                <i class="fas fa-bell" style="color: #666; cursor: pointer; margin-right: 15px;"></i>
                <span style="font-weight: 600; color: var(--primary-navy);"><?= $user['email'] ?></span>
            </div>
        </header>
        
        <div class="content-wrapper">
            <?php require_once __DIR__ . '/../partials/alerts.php'; ?>