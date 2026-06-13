<?php
class Category {
    public static function getAll() {
        return Database::fetchAll("SELECT * FROM categories ORDER BY name ASC");
    }

    public static function getBySlug($slug) {
        return Database::fetch("SELECT * FROM categories WHERE slug = :slug", [':slug' => $slug]);
    }

    public static function getTotalCount() {
        $res = Database::fetch("SELECT COUNT(*) as cnt FROM categories");
        return $res['cnt'] ?? 0;
    }
}
