<?php 
// public/admin/settings.php

// Load the shared admin header (handles AdminMiddleware security and layout)
require_once '../../app/Views/layouts/admin_header.php'; 
?>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
    
    <!-- Settings Form -->
    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05);">
        <h3 style="color: var(--primary-navy); margin-top: 0; margin-bottom: 10px;">Brand Identity</h3>
        <p style="color: #666; margin-bottom: 25px; font-size: 0.9rem;">Update the core identity of the application. These changes will reflect immediately across the login page, dashboards, and public homepage.</p>
        
        <form action="../../routes/web.php?action=update_settings" method="POST">
            <input type="hidden" name="csrf_token" value="<?= generateCSRF() ?>">
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">Site Name</label>
                <input type="text" name="site_name" value="<?= htmlspecialchars($settings['site_name'] ?? 'MiniBank Rwanda') ?>" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px;" required>
            </div>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">Site Slogan</label>
                <input type="text" name="site_slogan" value="<?= htmlspecialchars($settings['site_slogan'] ?? 'Bank Smart. Live Better.') ?>" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px;" required>
            </div>
            
            <div class="form-group" style="margin-bottom: 25px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px; color: var(--text-dark);">Logo URL</label>
                <input type="text" name="logo_url" value="<?= htmlspecialchars($settings['logo_url'] ?? 'assets/images/logo.png') ?>" class="form-control" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px;">
                <small style="color: #888; display: block; margin-top: 5px;">Enter the relative path to the logo image (e.g., <code>assets/images/logo.png</code>).</small>
            </div>
            
            <button type="submit" class="btn btn-primary" style="padding: 12px 30px; font-size: 1rem;">
                <i class="fas fa-save" style="margin-right: 8px;"></i> Save Changes
            </button>
        </form>
    </div>

    <!-- Live Preview Card -->
    <div>
        <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); text-align: center; position: sticky; top: 30px;">
            <h4 style="color: var(--primary-navy); margin-top: 0; margin-bottom: 20px;">Live Preview</h4>
            
            <div style="background: #f9f9f9; border: 1px dashed #ddd; border-radius: 8px; padding: 30px 20px;">
                <!-- Logo Preview -->
                <div style="margin-bottom: 15px;">
                    <?php if(!empty($settings['logo_url'])): ?>
                        <img src="<?= BASE_URL . htmlspecialchars($settings['logo_url']) ?>" alt="Logo" style="max-height: 60px; max-width: 100%; object-fit: contain;" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                        <i class="fas fa-university fa-3x" style="color: var(--primary-blue); display: none;"></i>
                    <?php else: ?>
                        <i class="fas fa-university fa-3x" style="color: var(--primary-blue);"></i>
                    <?php endif; ?>
                </div>
                
                <!-- Name Preview -->
                <h2 style="color: var(--primary-navy); margin: 0 0 5px 0; font-size: 1.5rem;">
                    <?= htmlspecialchars($settings['site_name'] ?? 'MiniBank Rwanda') ?>
                </h2>
                
                <!-- Slogan Preview -->
                <p style="color: #666; margin: 0; font-size: 0.9rem;">
                    <?= htmlspecialchars($settings['site_slogan'] ?? 'Bank Smart. Live Better.') ?>
                </p>
            </div>
            
            <p style="color: #888; font-size: 0.8rem; margin-top: 15px; line-height: 1.5;">
                <i class="fas fa-info-circle"></i> This is how your brand will appear on the login screen and public homepage.
            </p>
        </div>
    </div>
</div>

<?php require_once '../../app/Views/layouts/footer.php'; ?>