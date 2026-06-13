<?php
class Image {
    public static function create($data) {
        $sql = "INSERT INTO images (
            category_id, subcategory_id, title, slug, meta_title, meta_description,
            alt_text, focus_keywords, tags, caption, canonical_url, og_title,
            og_description, twitter_title, twitter_description, short_seo_description,
            image_credit, image_license, filename, filepath_original, filepath_webp, filepath_thumbnail,
            mime_type, file_size, width, height, is_transparent, orientation,
            is_featured, show_on_homepage, is_trending, is_recommended, is_wallpaper, is_png
        ) VALUES (
            :category_id, :subcategory_id, :title, :slug, :meta_title, :meta_description,
            :alt_text, :focus_keywords, :tags, :caption, :canonical_url, :og_title,
            :og_description, :twitter_title, :twitter_description, :short_seo_description,
            :image_credit, :image_license, :filename, :filepath_original, :filepath_webp, :filepath_thumbnail,
            :mime_type, :file_size, :width, :height, :is_transparent, :orientation,
            :is_featured, :show_on_homepage, :is_trending, :is_recommended, :is_wallpaper, :is_png
        )";

        Database::query($sql, $data);
        return Database::lastInsertId();
    }

    public static function getLatest($limit = 12) {
        return Database::fetchAll("SELECT * FROM images ORDER BY created_at DESC LIMIT " . (int)$limit);
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
