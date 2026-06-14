<?php
class Cache {
    private static $cacheDir = null;

    private static function init() {
        if (self::$cacheDir === null) {
            self::$cacheDir = ROOT_DIR . '/cache/query';
            if (!is_dir(self::$cacheDir)) {
                mkdir(self::$cacheDir, 0755, true);
            }
        }
    }

    public static function get($key, $ttlSeconds = 3600) {
        self::init();
        $file = self::$cacheDir . '/' . md5($key) . '.cache';

        if (file_exists($file) && (time() - filemtime($file) < $ttlSeconds)) {
            $data = file_get_contents($file);
            return unserialize($data);
        }
        return false;
    }

    public static function set($key, $data) {
        self::init();
        $file = self::$cacheDir . '/' . md5($key) . '.cache';
        file_put_contents($file, serialize($data), LOCK_EX);
    }

    public static function clear() {
        self::init();
        $files = glob(self::$cacheDir . '/*');
        foreach ($files as $file) {
            if (is_file($file)) unlink($file);
        }
    }
}
