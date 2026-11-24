<?php 
require_once '../app/Config/config.php'; 
$settings = getSettings(); 

// Set the exact contact details requested
$supportEmail = 'niragire_224007101@stud.ur.ac.rw';
$supportPhone = '+250 793473101';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $settings['site_name'] ?? 'MiniBank Rwanda' ?> - <?= $settings['site_slogan'] ?? 'Bank Smart. Live Better.' ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container flex-between">
            <div class="logo">
                <i class="fas fa-university"></i>
                <h2><?= $settings['site_name'] ?? 'MiniBank Rwanda' ?></h2>
            </div>
            <ul class="nav-links">
                <li><a href="#" class="active">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#security">Security</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            <div class="nav-buttons">
                <a href="login.php" class="btn btn-outline">Login</a>
                <a href="register.php" class="btn btn-primary">Register</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero" style="background: linear-gradient(rgba(6, 38, 92, 0.85), rgba(6, 38, 92, 0.85)), url('<?= BASE_URL ?>assets/images/kigali-convention.jpg') center/cover;">
        <div class="container hero-content">
            <h1> Trusted Mini-Bank<br>in Rwanda</h1>
            <p>Bank Smart. Live Better.<br>Secure, modern and reliable banking services at your fingertips.</p>
            <div class="hero-buttons">
                <a href="register.php" class="btn btn-primary btn-lg"><i class="fas fa-user-plus"></i> Open Account</a>
                <a href="#about" class="btn btn-outline btn-lg"><i class="fas fa-play"></i> Learn More</a>
            </div>
        </div>
    </header>

    <!-- 5 Service Cards -->
    <div class="container overlapping-cards">
        <h2 class="section-title">Our Core Services</h2>
        <div class="card-row">
            <div class="service-card"><i class="fas fa-wallet"></i><h3>Account Management</h3><p>Manage your accounts effortlessly.</p></div>
            <div class="service-card"><i class="fas fa-exchange-alt"></i><h3>Money Transfer</h3><p>Send and receive funds instantly.</p></div>
            <div class="service-card"><i class="fas fa-hand-holding-usd"></i><h3>Deposits & Withdrawals</h3><p>Easy and secure transactions.</p></div>
            <div class="service-card"><i class="fas fa-file-pdf"></i><h3>PDF Statements</h3><p>Download your bank statements.</p></div>
            <div class="service-card"><i class="fas fa-headset"></i><h3>24/7 Support</h3><p>We are here for you anytime.</p></div>
        </div>
    </div>

    <!-- Why Choose Us Section -->
    <section id="about" class="section bg-light">
        <div class="container text-center">
            <h2>Why Choose <?= $settings['site_name'] ?? 'MiniBank Rwanda' ?>?</h2>
            <div class="underline"></div>
            
            <div class="features-grid" style="margin-top: 40px; text-align: left;">
                <div class="feature-card"><i class="fas fa-shield-alt"></i><h3>Secure Banking</h3><p>Protected by advanced authentication and encryption standards.</p></div>
                <div class="feature-card"><i class="fas fa-bolt"></i><h3>Fast Transactions</h3><p>Instant processing for transfers, deposits, and withdrawals.</p></div>
                <div class="feature-card"><i class="fas fa-layer-group"></i><h3>Multiple Services</h3><p>All your banking needs in one centralized platform.</p></div>
                <div class="feature-card"><i class="fas fa-clock"></i><h3>24/7 Support</h3><p>Our dedicated team is always ready to assist you.</p></div>
                <div class="feature-card"><i class="fas fa-mobile-alt"></i><h3>Mobile Friendly</h3><p>Access your account seamlessly on any device.</p></div>
                <div class="feature-card"><i class="fas fa-bell"></i><h3>Instant Notifications</h3><p>Receive real-time alerts for every transaction.</p></div>
                <div class="feature-card"><i class="fas fa-balance-scale"></i><h3>Double-Entry Security</h3><p>Every transaction is securely logged for perfect accuracy.</p></div>
                <div class="feature-card"><i class="fas fa-credit-card"></i><h3>Virtual Cards</h3><p>Generate secure virtual cards for safe online shopping and subscriptions.</p></div>
            </div>
        </div>
    </section>

    <!-- DETAILED SERVICES SECTION -->
    <section id="services" class="section" style="padding: 80px 0;">
        <div class="container">
            <div class="text-center">
                <h2>Banking Services</h2>
                <div class="underline"></div>
                <p style="color: #666; max-width: 700px; margin: 0 auto 40px;">Experience a full suite of digital banking tools designed to make your life easier, faster, and more secure.</p>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border-left: 5px solid var(--primary-blue);">
                    <h3 style="color: var(--primary-navy); margin-bottom: 10px;"><i class="fas fa-piggy-bank" style="color: var(--primary-blue); margin-right: 10px;"></i> Smart Savings</h3>
                    <p style="color: #666; line-height: 1.6;">Create multiple savings accounts, track your progress, and manage your funds with our intuitive dashboard.</p>
                </div>
                <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border-left: 5px solid var(--primary-blue);">
                    <h3 style="color: var(--primary-navy); margin-bottom: 10px;"><i class="fas fa-money-check-alt" style="color: var(--primary-blue); margin-right: 10px;"></i> Instant Transfers</h3>
                    <p style="color: #666; line-height: 1.6;">Send money to any account number within MiniBank instantly. Safe, reliable, and zero hidden fees.</p>
                </div>
                <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border-left: 5px solid var(--primary-blue);">
                    <h3 style="color: var(--primary-navy); margin-bottom: 10px;"><i class="fas fa-file-invoice-dollar" style="color: var(--primary-blue); margin-right: 10px;"></i> Digital Statements</h3>
                    <p style="color: #666; line-height: 1.6;">Generate, view, and download professional PDF bank statements for any date range instantly.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECURITY SECTION -->
    <section id="security" class="section bg-light" style="padding: 80px 0;">
        <div class="container flex-row" style="align-items: center; gap: 50px;">
            <div style="flex: 1;">
                <h2 style="color: var(--primary-navy);">Your Security is Our Priority</h2>
                <div class="underline" style="margin-left: 0;"></div>
                <p style="color: #555; line-height: 1.8; margin-bottom: 20px;">We utilize industry-standard security protocols to ensure your data and funds are always protected. Our systems are built on trust and reliability.</p>
                <ul style="list-style: none; padding: 0; line-height: 2.5; color: var(--text-dark); font-weight: 500;">
                    <li><i class="fas fa-check-circle" style="color: #28a745; margin-right: 10px;"></i> Secure Password Hashing (Bcrypt)</li>
                    <li><i class="fas fa-check-circle" style="color: #28a745; margin-right: 10px;"></i> CSRF Protection on all forms</li>
                    <li><i class="fas fa-check-circle" style="color: #28a745; margin-right: 10px;"></i> SQL Injection Prevention (PDO)</li>
                    <li><i class="fas fa-check-circle" style="color: #28a745; margin-right: 10px;"></i> Session Hijacking Protection</li>
                    <li><i class="fas fa-check-circle" style="color: #28a745; margin-right: 10px;"></i> Activity & Audit Logging</li>
                </ul>
            </div>
            <div style="flex: 1; text-align: center;">
                <i class="fas fa-shield-alt" style="font-size: 15rem; color: var(--primary-blue); opacity: 0.1;"></i>
            </div>
        </div>
    </section>

    <!-- CONTACT SECTION WITH FORM -->
    <section id="contact" class="section" style="padding: 80px 0;">
        <div class="container">
            <div class="text-center">
                <h2>Contact Us</h2>
                <div class="underline"></div>
                <p style="color: #666; margin-bottom: 40px;">Have a question? We're here to help. Send us a message and we'll respond as soon as possible.</p>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 40px; background: white; border-radius: 15px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); overflow: hidden;">
                
                <!-- Contact Info Side -->
                <div style="background: var(--primary-navy); padding: 40px; color: white;">
                    <h3 style="margin-top: 0; margin-bottom: 20px;">Contact Information</h3>
                    <p style="color: #b0c4de; margin-bottom: 30px;">Reach out to us through any of these channels.</p>
                    
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px;">
                        <i class="fas fa-map-marker-alt" style="font-size: 1.5rem; color: var(--primary-blue);"></i>
                        <div>
                            <h4 style="margin: 0; font-size: 1rem;">Location</h4>
                            <p style="margin: 0; color: #b0c4de; font-size: 0.9rem;">Huye, Rwanda</p>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px;">
                        <i class="fas fa-phone" style="font-size: 1.5rem; color: var(--primary-blue);"></i>
                        <div>
                            <h4 style="margin: 0; font-size: 1rem;">Phone</h4>
                            <!-- FIXED PHP SYNTAX HERE -->
                            <p style="margin: 0; color: #b0c4de; font-size: 0.9rem;"><?= $supportPhone ?></p>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <i class="fas fa-envelope" style="font-size: 1.5rem; color: var(--primary-blue);"></i>
                        <div>
                            <h4 style="margin: 0; font-size: 1rem;">Email</h4>
                            <!-- FIXED EMAIL HERE -->
                            <p style="margin: 0; color: #b0c4de; font-size: 0.9rem; word-break: break-all;"><?= $supportEmail ?></p>
                        </div>
                    </div>
                </div>

                <!-- Contact Form Side -->
                <div style="padding: 40px;">
                    <?php if(isset($_SESSION['success'])): ?>
                        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                        </div>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['error'])): ?>
                        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">
                            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>

                    <form action="../routes/web.php?action=contact" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= generateCSRF() ?>">
                        
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: var(--text-dark);">Your Name</label>
                                <input type="text" name="name" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; outline: none;">
                            </div>
                            <div>
                                <label style="display: block; margin-bottom: 5px; font-weight: 600; color: var(--text-dark);">Your Email</label>
                                <input type="email" name="email" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; outline: none;">
                            </div>
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: var(--text-dark);">Subject</label>
                            <input type="text" name="subject" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; outline: none;">
                        </div>
                        <div style="margin-bottom: 20px;">
                            <label style="display: block; margin-bottom: 5px; font-weight: 600; color: var(--text-dark);">Message</label>
                            <textarea name="message" rows="5" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; outline: none; resize: vertical;"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 1rem;">Send Message <i class="fas fa-paper-plane" style="margin-left: 5px;"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Public Footer -->
    <footer style="background: var(--primary-navy); color: white; padding: 60px 0 20px;">
        <div class="container" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px;">
            <div>
                <div class="logo" style="margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-university" style="font-size: 2rem;"></i>
                    <h3 style="margin: 0;"><?= $settings['site_name'] ?? 'MiniBank Rwanda' ?></h3>
                </div>
                <p style="color: #b0c4de; font-size: 0.9rem; line-height: 1.6;">
                    <?= $settings['site_slogan'] ?? 'Bank Smart. Live Better.' ?><br>
                    Secure, modern and reliable banking services at your fingertips.
                </p>
            </div>
            <div>
                <h4 style="margin-bottom: 15px;">Quick Links</h4>
                <ul style="list-style: none; line-height: 2;">
                    <li><a href="#" style="color: #b0c4de; text-decoration: none;">Home</a></li>
                    <li><a href="#about" style="color: #b0c4de; text-decoration: none;">About Us</a></li>
                    <li><a href="#services" style="color: #b0c4de; text-decoration: none;">Services</a></li>
                    <li><a href="#security" style="color: #b0c4de; text-decoration: none;">Security</a></li>
                </ul>
            </div>
            <div>
                <h4 style="margin-bottom: 15px;">Banking Links</h4>
                <ul style="list-style: none; line-height: 2;">
                    <li><a href="login.php" style="color: #b0c4de; text-decoration: none;">Accounts</a></li>
                    <li><a href="login.php" style="color: #b0c4de; text-decoration: none;">Transfers</a></li>
                    <li><a href="login.php" style="color: #b0c4de; text-decoration: none;">Statements</a></li>
                    <li><a href="login.php" style="color: #b0c4de; text-decoration: none;">Notifications</a></li>
                </ul>
            </div>
            <div>
                <h4 style="margin-bottom: 15px;">Support</h4>
                <ul style="list-style: none; line-height: 2; color: #b0c4de; font-size: 0.9rem;">
                    <li><i class="fas fa-map-marker-alt" style="margin-right: 8px;"></i> Huye, Rwanda</li>
                    <!-- FIXED FOOTER DETAILS -->
                    <li><i class="fas fa-phone" style="margin-right: 8px;"></i> <?= $supportPhone ?></li>
                    <li><i class="fas fa-envelope" style="margin-right: 8px;"></i> <?= $supportEmail ?></li>
                </ul>
                <div style="display: flex; gap: 15px; margin-top: 15px;">
                    <a href="#" style="color: white;"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" style="color: white;"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" style="color: white;"><i class="fab fa-youtube fa-lg"></i></a>
                    <a href="#" style="color: white;"><i class="fab fa-linkedin fa-lg"></i></a>
                </div>
            </div>
        </div>
        <div class="container" style="text-align: center; border-top: 1px solid rgba(255,255,255,0.1); margin-top: 40px; padding-top: 20px; color: #b0c4de; font-size: 0.85rem;">
            <p>&copy; <?= date('Y') ?> <?= $settings['site_name'] ?? 'MiniBank Rwanda' ?>. All rights reserved.</p>
        </div>
    </footer>

    <script src="<?= BASE_URL ?>assets/js/main.js"></script>
</body>
</html>