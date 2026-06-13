<?php
class Logger {
    private static function write($level, $message) {
        $logDir = APP_DIR . '/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0755, true);
        }

        $date = date('Y-m-d');
        $file = $logDir . '/' . $level . '-' . $date . '.log';
        $time = date('Y-m-d H:i:s');

        $formattedMessage = "[{$time}] {$message}" . PHP_EOL;
        file_put_contents($file, $formattedMessage, FILE_APPEND | LOCK_EX);
    }

    public static function error($message) {
        self::write('error', $message);
    }

    public static function performance($message) {
        self::write('performance', $message);
    }
}
