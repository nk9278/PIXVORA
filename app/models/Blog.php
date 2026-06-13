<?php
class Blog {

    public static function create($data) {
        $sql = "INSERT INTO blogs (
            title, slug, content, category, tags, featured_image, author_name, status,
            meta_title, meta_description, focus_keywords, canonical_url,
            og_title, og_description, twitter_title, twitter_description, featured_image_alt
        ) VALUES (
            :title, :slug, :content, :category, :tags, :featured_image, :author_name, :status,
            :meta_title, :meta_description, :focus_keywords, :canonical_url,
            :og_title, :og_description, :twitter_title, :twitter_description, :featured_image_alt
        )";
        Database::query($sql, $data);
        return Database::lastInsertId();
    }

    public static function update($id, $data) {
        $data[':id'] = $id;
        $sql = "UPDATE blogs SET
            title = :title, slug = :slug, content = :content, category = :category,
            tags = :tags, featured_image = :featured_image, author_name = :author_name, status = :status,
            meta_title = :meta_title, meta_description = :meta_description, focus_keywords = :focus_keywords,
            canonical_url = :canonical_url, og_title = :og_title, og_description = :og_description,
            twitter_title = :twitter_title, twitter_description = :twitter_description, featured_image_alt = :featured_image_alt
            WHERE id = :id";
        return Database::query($sql, $data);
    }

    public static function getLatest($limit = 10, $onlyPublished = true) {
        $sql = "SELECT * FROM blogs " . ($onlyPublished ? "WHERE status = 'published'" : "") . " ORDER BY created_at DESC LIMIT " . (int)$limit;
        return Database::fetchAll($sql);
    }

    public static function getBySlug($slug, $onlyPublished = true) {
        $sql = "SELECT * FROM blogs WHERE slug = :slug " . ($onlyPublished ? "AND status = 'published'" : "") . " LIMIT 1";
        return Database::fetch($sql, [':slug' => $slug]);
    }

    public static function getByCategory($category, $limit = 10) {
        $sql = "SELECT * FROM blogs WHERE category = :category AND status = 'published' ORDER BY created_at DESC LIMIT " . (int)$limit;
        return Database::fetchAll($sql, [':category' => $category]);
    }

    public static function getRelated($excludeId, $category = '', $limit = 3) {
        $sql = "SELECT * FROM blogs WHERE id != :id AND status = 'published' ";
        $params = [':id' => $excludeId];

        if (!empty($category)) {
            $sql .= " AND category = :cat ";
            $params[':cat'] = $category;
        }

        $sql .= " ORDER BY created_at DESC LIMIT " . (int)$limit;
        return Database::fetchAll($sql, $params);
    }

    public static function incrementViews($id) {
        Database::query("UPDATE blogs SET views = views + 1 WHERE id = :id", [':id' => $id]);
    }
}
