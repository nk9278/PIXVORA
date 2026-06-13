<?php
class Admin {
    public static function authenticate($username, $password) {
        $sql = "SELECT * FROM admins WHERE username = :username LIMIT 1";
        $admin = Database::fetch($sql, [':username' => $username]);

        if ($admin && Security::verifyPassword($password, $admin['password_hash'])) {
            // Update last login
            Database::query("UPDATE admins SET last_login = CURRENT_TIMESTAMP WHERE id = :id", [':id' => $admin['id']]);
            return $admin;
        }
        return false;
    }
}
