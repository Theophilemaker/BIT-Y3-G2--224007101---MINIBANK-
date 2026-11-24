<?php
// app/Services/StatementCleanup.php
class StatementCleanup {
    public static function run() {
        $dir = __DIR__ . '/../../storage/statements/';
        if (!is_dir($dir)) return;

        $files = glob($dir . '*.pdf');
        $now = time();
        
        foreach ($files as $file) {
            // Delete PDFs older than 24 hours (86400 seconds)
            if (is_file($file) && ($now - filemtime($file)) > 86400) {
                unlink($file);
            }
        }
    }
}
?>