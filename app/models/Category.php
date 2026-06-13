<?php
class Category {
    public static function getAll() {
        $cacheKey = 'categories_all';
        $data = Cache::get($cacheKey, 86400); // cache for 24 hours
        if ($data !== false) return $data;

        $data = Database::fetchAll("SELECT * FROM categories ORDER BY name ASC");
        Cache::set($cacheKey, $data);
        return $data;
    }

    public static function getBySlug($slug) {
        return Database::fetch("SELECT * FROM categories WHERE slug = :slug", [':slug' => $slug]);
    }

    public static function getTotalCount() {
        $res = Database::fetch("SELECT COUNT(*) as cnt FROM categories");
        return $res['cnt'] ?? 0;
    }
}
