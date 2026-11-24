<?php 
require_once '../app/Config/config.php'; 
$settings = getSettings(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - <?= $settings['site_name'] ?? 'MiniBank Rwanda' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="auth-body" style="background: linear-gradient(rgba(6, 38, 92, 0.7), rgba(6, 38, 92, 0.7)), url('<?= BASE_URL ?>assets/images/kigali-convention.jpg') center/cover; align-items: flex-start; padding-top: 50px;">
    
    <div class="auth-container">
        <div class="auth-box flex-row" style="flex-direction: row-reverse;">
            <!-- Left Side Branding -->
            <div class="auth-left text-center" style="background: var(--primary-navy); color: white;">
                <i class="fas fa-university fa-4x" style="color: white; margin-bottom: 20px;"></i>
                <h2 style="color: white;">Join <?= $settings['site_name'] ?? 'MiniBank Rwanda' ?></h2>
                <p style="color: #ccc; margin-top: 10px;">Open your account today and enjoy modern banking services.</p>
                <ul style="text-align: left; margin-top: 30px; color: #ccc; line-height: 2;">
                    <li><i class="fas fa-check-circle" style="color: #28a745;"></i> Secure Registration</li>
                    <li><i class="fas fa-check-circle" style="color: #28a745;"></i> Easy Access</li>
                    <li><i class="fas fa-check-circle" style="color: #28a745;"></i> Better Banking</li>
                </ul>
            </div>
            
            <!-- Right Side Form -->
            <div class="auth-right">
                <h3 style="color: var(--primary-navy);">Create Your Account</h3>
                <p class="text-muted" style="margin-bottom: 20px;">Fill in the details below</p>
                
                <?php require_once '../app/Views/partials/alerts.php'; ?>

                <form action="../routes/web.php?action=register" method="POST">
                    <input type="hidden" name="csrf_token" value="<?= generateCSRF() ?>">
                    
                    <div class="flex-row" style="gap: 10px;">
                        <div class="input-group" style="flex: 1;">
                            <input type="text" name="first_name" placeholder="First Name" required>
                        </div>
                        <div class="input-group" style="flex: 1;">
                            <input type="text" name="last_name" placeholder="Last Name" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-phone"></i>
                        <input type="text" name="phone" placeholder="Phone Number" required>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-map-marker-alt"></i>
                        <input type="text" name="address" placeholder="Address (e.g., Kigali)" required>
                    </div>
                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 mt-2">Register Account</button>
                </form>
                
                <p class="text-center mt-3" style="font-size: 0.9rem;">
                    Already have an account? <a href="login.php" class="text-primary">Login here</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>