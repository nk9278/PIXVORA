<?php
class Image {
    public static function create($data) {
        $sql = "INSERT INTO images (
            category_id, subcategory_id, title, slug, meta_title, meta_description,
            alt_text, focus_keywords, tags, caption, canonical_url, og_title,
            og_description, twitter_title, twitter_description, short_seo_description,
            image_credit, image_license, filename, filepath_original, filepath_webp, filepath_thumbnail,
            filepath_small, filepath_medium, filepath_large,
            mime_type, file_size, width, height, is_transparent, orientation, dominant_color,
            is_featured, show_on_homepage, is_trending, is_recommended, is_wallpaper, is_png
        ) VALUES (
            :category_id, :subcategory_id, :title, :slug, :meta_title, :meta_description,
            :alt_text, :focus_keywords, :tags, :caption, :canonical_url, :og_title,
            :og_description, :twitter_title, :twitter_description, :short_seo_description,
            :image_credit, :image_license, :filename, :filepath_original, :filepath_webp, :filepath_thumbnail,
            :filepath_small, :filepath_medium, :filepath_large,
            :mime_type, :file_size, :width, :height, :is_transparent, :orientation, :dominant_color,
            :is_featured, :show_on_homepage, :is_trending, :is_recommended, :is_wallpaper, :is_png
        )";

        Database::query($sql, $data);
        return Database::lastInsertId();
    }

    public static function getLatest($limit = 12) {
        return Database::fetchAll("SELECT * FROM images ORDER BY created_at DESC LIMIT " . (int)$limit);
    }

    public static function getBySlug($slug) {
        $sql = "SELECT i.*, c.name as category_name, c.slug as category_slug
                FROM images i
                LEFT JOIN categories c ON i.category_id = c.id
                WHERE i.slug = :slug LIMIT 1";
        return Database::fetch($sql, [':slug' => $slug]);
    }

    public static function getRelated($categoryId, $excludeId, $limit = 8) {
        $sql = "SELECT * FROM images WHERE category_id = :category_id AND id != :exclude_id ORDER BY created_at DESC LIMIT " . (int)$limit;
        return Database::fetchAll($sql, [':category_id' => $categoryId, ':exclude_id' => $excludeId]);
    }

    /**
     * Advanced Search Engine
     */
    public static function search($query = '', $filters = [], $sort = 'latest', $limit = 40) {
        $sql = "SELECT i.*, c.name as category_name, c.slug as category_slug
                FROM images i
                LEFT JOIN categories c ON i.category_id = c.id
                WHERE 1=1";
        $params = [];

        // 1. Text Query (Partial matching on title, tags, focus_keywords, or description)
        if (!empty($query)) {
            $sql .= " AND (i.title LIKE :q OR i.tags LIKE :q OR i.focus_keywords LIKE :q OR i.meta_description LIKE :q OR c.name LIKE :q)";
            $params[':q'] = '%' . $query . '%';
        }

        // 2. Filters
        if (!empty($filters['category_slug'])) {
            $sql .= " AND c.slug = :category_slug";
            $params[':category_slug'] = $filters['category_slug'];
        }

        if (!empty($filters['orientation'])) {
            $sql .= " AND i.orientation = :orientation";
            $params[':orientation'] = $filters['orientation'];
        }

        // Exact match on dominant_color (simplistic exact match for phase 8)
        if (!empty($filters['color'])) {
            $sql .= " AND i.dominant_color = :color";
            $params[':color'] = $filters['color'];
        }

        if (isset($filters['is_wallpaper']) && $filters['is_wallpaper'] !== '') {
            $sql .= " AND i.is_wallpaper = :is_wp";
            $params[':is_wp'] = (int)$filters['is_wallpaper'];
        }

        if (isset($filters['is_png']) && $filters['is_png'] !== '') {
            $sql .= " AND i.is_transparent = :is_png";
            $params[':is_png'] = (int)$filters['is_png'];
        }

        // 3. Sorting Options
        switch ($sort) {
            case 'popular':
            case 'downloads':
                $sql .= " ORDER BY i.downloads DESC";
                break;
            case 'trending':
                $sql .= " ORDER BY i.is_trending DESC, i.views DESC";
                break;
            case 'latest':
            default:
                $sql .= " ORDER BY i.created_at DESC";
                break;
        }

        $sql .= " LIMIT " . (int)$limit;

        return Database::fetchAll($sql, $params);
    }

    /**
     * Live Search Suggestions
     */
    public static function suggest($query, $limit = 5) {
        $sql = "SELECT title, slug, filepath_thumbnail FROM images
                WHERE title LIKE :q OR tags LIKE :q
                ORDER BY downloads DESC LIMIT " . (int)$limit;
        return Database::fetchAll($sql, [':q' => '%' . $query . '%']);
    }

    public static function getTotalCount() {
        $res = Database::fetch("SELECT COUNT(*) as cnt FROM images");
        return $res['cnt'] ?? 0;
    }

    public static function getTotalDownloads() {
        $res = Database::fetch("SELECT SUM(downloads) as total FROM images");
        return $res['total'] ?? 0;
    }

    public static function getMostDownloaded($limit = 5) {
        return Database::fetchAll("SELECT * FROM images ORDER BY downloads DESC LIMIT " . (int)$limit);
    }
}
