<?php
class Admin {
    public static function authenticate($username, $password) {
        $sql = "SELECT * FROM admins WHERE username = :username LIMIT 1";
        $admin = Database::fetch($sql, [':username' => $username]);

        if (!$admin) {
            return false;
        }

        // Basic brute-force protection
        if ($admin['lockout_time'] && strtotime($admin['lockout_time']) > time()) {
            return 'locked';
        }

        if (Security::verifyPassword($password, $admin['password_hash'])) {
            Database::query("UPDATE admins SET last_login = CURRENT_TIMESTAMP, failed_logins = 0, lockout_time = NULL WHERE id = :id", [':id' => $admin['id']]);
            return $admin;
        } else {
            // Increment failed logins
            $failed = $admin['failed_logins'] + 1;
            $lockout = ($failed >= 5) ? date('Y-m-d H:i:s', time() + 900) : null; // 15 min lockout
            Database::query("UPDATE admins SET failed_logins = :f, lockout_time = :l WHERE id = :id", [':f' => $failed, ':l' => $lockout, ':id' => $admin['id']]);
        }
        return false;
    }
}
