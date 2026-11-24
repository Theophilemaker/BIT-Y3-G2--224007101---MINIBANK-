<?php 
require_once '../app/Config/config.php'; 
$settings = getSettings(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?= $settings['site_name'] ?? 'MiniBank Rwanda' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom tweaks to ensure it fits on one screen */
        .auth-body {
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden; /* Prevents scrolling */
        }
        .auth-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .auth-box {
            margin-top: 0;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }
        /* Modal Styles */
        .modal-overlay {
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.6); z-index: 1000; align-items: center; justify-content: center;
        }
        .modal-content {
            background: white; padding: 30px; border-radius: 10px; width: 90%; max-width: 400px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3); position: relative;
        }
        .close-modal {
            position: absolute; top: 15px; right: 20px; font-size: 1.5rem; color: #666; cursor: pointer;
        }
    </style>
</head>
<body class="auth-body" style="background: linear-gradient(rgba(6, 38, 92, 0.8), rgba(6, 38, 92, 0.8)), url('<?= BASE_URL ?>assets/images/kigali-convention.jpg') center/cover;">
    
    <nav class="navbar navbar-transparent" style="padding: 10px 0;">
        <div class="container flex-between">
            <div class="logo text-white">
                <i class="fas fa-university"></i>
                <h2><?= $settings['site_name'] ?? 'MiniBank Rwanda' ?></h2>
            </div>
            <ul class="nav-links text-white">
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php#about">About</a></li>
                <li><a href="index.php#services">Services</a></li>
            </ul>
        </div>
    </nav>

    <div class="auth-container">
        <div class="auth-box flex-row" style="width: 100%; max-width: 850px;">
            <!-- Left Side Branding -->
            <div class="auth-left text-center" style="padding: 30px;">
                <i class="fas fa-university fa-4x" style="color: var(--primary-blue);"></i>
                <h2 style="color: var(--primary-navy); margin-top: 15px;"><?= $settings['site_name'] ?? 'MiniBank Rwanda' ?></h2>
                <p style="color: #666; margin-top: 10px;">Secure Banking<br>for a Better Tomorrow</p>
                <div style="margin-top: 20px; color: #28a745; font-size: 0.9rem;">
                    <i class="fas fa-shield-check"></i> Bank-Grade Security
                </div>
            </div>
            
            <!-- Right Side Form -->
            <div class="auth-right" style="padding: 40px;">
                <h3 style="color: var(--primary-navy);">Login to Your Account</h3>
                <p class="text-muted" style="margin-bottom: 20px;">Access your account securely</p>
                
                <!-- Alerts placed here to avoid layout jumping -->
                <?php require_once '../app/Views/partials/alerts.php'; ?>

                <form action="../routes/web.php?action=login" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= generateCSRF() ?>">
                    
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    
                    <div class="flex-between mt-2" style="font-size: 0.9rem; margin-bottom: 20px;">
                        <label style="cursor: pointer; color: #555;"><input type="checkbox" name="remember"> Remember Me</label>
                        <a href="javascript:void(0)" onclick="document.getElementById('forgotModal').style.display='flex'" class="text-primary" style="font-weight: 600;">Forgot Password?</a>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                
                <p class="text-center mt-3" style="font-size: 0.9rem;">
                    Don't have an account? <a href="register.php" class="text-primary" style="font-weight: 600;">Register here</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div id="forgotModal" class="modal-overlay">
        <div class="modal-content">
            <span class="close-modal" onclick="document.getElementById('forgotModal').style.display='none'">&times;</span>
            <div class="text-center" style="margin-bottom: 20px;">
                <i class="fas fa-key fa-3x" style="color: var(--primary-blue); margin-bottom: 15px;"></i>
                <h3 style="color: var(--primary-navy); margin: 0;">Reset Password</h3>
            </div>
            <p class="text-muted text-center" style="margin-bottom: 20px; font-size: 0.9rem;">
                Enter your registered email address and we will send you a link to reset your password.
            </p>
            <form id="forgotForm" onsubmit="event.preventDefault(); document.getElementById('forgotSuccess').style.display='block'; this.style.display='none';">
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" placeholder="Email Address" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 mt-2">Send Reset Link</button>
            </form>
            <div id="forgotSuccess" style="display: none; text-align: center; padding: 20px 0;">
                <i class="fas fa-check-circle fa-3x" style="color: #28a745; margin-bottom: 15px;"></i>
                <h4 style="color: var(--primary-navy); margin-bottom: 10px;">Email Sent!</h4>
                <p style="color: #666; font-size: 0.9rem;">If an account exists with that email, a password reset link has been sent to it.</p>
            </div>
        </div>
    </div>

    <div class="security-badge text-white text-center" style="padding-bottom: 15px; font-size: 0.85rem;">
        <i class="fas fa-shield-alt"></i> Your security is our priority
    </div>

</body>
</html>