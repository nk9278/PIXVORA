<?php
class Cleanup {
    /**
     * Purges stale cache and log files automatically
     * Intended to be called via Cron or low-probability background hook
     */
    public static function run() {
        self::clearStaleQueryCache();
        self::clearOldLogs();
    }

    private static function clearStaleQueryCache() {
        $cacheDir = APP_DIR . '/cache/query';
        if (!is_dir($cacheDir)) return;

        $files = glob($cacheDir . '/*.cache');
        $now = time();

        foreach ($files as $file) {
            // If file is older than 24 hours, delete it to save inodes
            if (is_file($file) && ($now - filemtime($file)) > 86400) {
                unlink($file);
            }
        }
    }

    private static function clearOldLogs() {
        $logDir = APP_DIR . '/logs';
        if (!is_dir($logDir)) return;

        $files = glob($logDir . '/*.log');
        $now = time();

        foreach ($files as $file) {
            // Keep logs for 30 days max
            if (is_file($file) && ($now - filemtime($file)) > (30 * 86400)) {
                unlink($file);
            }
        }
    }
}
