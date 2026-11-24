<?php
// public/hash_admin.php
require_once '../app/Config/config.php';

// 1. Define your new custom password
$newPassword = '15@theo20004n';
$targetEmail = 'niragire_224007101@stud.ur.ac.rw';

// 2. Generate the secure Bcrypt hash
$newHash = password_hash($newPassword, PASSWORD_DEFAULT);

echo "<div style='font-family: Arial; padding: 40px; max-width: 600px; margin: 0 auto;'>";
echo "<h2 style='color: #06265C;'>Admin Password Hash Generator</h2>";
echo "<p><strong>Target Email:</strong> " . $targetEmail . "</p>";
echo "<p><strong>New Password:</strong> " . $newPassword . "</p>";
echo "<p><strong>Generated Hash:</strong> <code style='background: #eee; padding: 5px;'>" . $newHash . "</code></p>";

// 3. Update the database automatically
try {
    $db = Database::getInstance();
    $stmt = $db->prepare("UPDATE users SET password_hash = ?, role = 'admin', status = 'active' WHERE email = ?");
    $stmt->execute([$newHash, $targetEmail]);
    
    if ($stmt->rowCount() > 0) {
        echo "<h3 style='color: green;'>✅ Success! The admin password has been updated in the database.</h3>";
        echo "<p>You can now log in at <a href='login.php'>login.php</a> with:</p>";
        echo "<ul>";
        echo "<li><strong>Email:</strong> " . $targetEmail . "</li>";
        echo "<li><strong>Password:</strong> " . $newPassword . "</li>";
        echo "</ul>";
    } else {
        echo "<h3 style='color: orange;'>⚠️ Update failed. Does the email " . $targetEmail . " exist in the database?</h3>";
    }
} catch (Exception $e) {
    echo "<h3 style='color: red;'>❌ Database Error: " . $e->getMessage() . "</h3>";
}
echo "</div>";
?>