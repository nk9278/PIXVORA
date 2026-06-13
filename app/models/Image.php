<?php
class Image {
    public static function create($data) {
        $sql = "INSERT INTO images (
            category_id, subcategory_id, title, slug, meta_title, meta_description,
            alt_text, focus_keywords, tags, caption, canonical_url, og_title,
            og_description, twitter_title, twitter_description, short_seo_description,
            filename, filepath_original, filepath_webp, filepath_thumbnail,
            mime_type, file_size, width, height, is_transparent
        ) VALUES (
            :category_id, :subcategory_id, :title, :slug, :meta_title, :meta_description,
            :alt_text, :focus_keywords, :tags, :caption, :canonical_url, :og_title,
            :og_description, :twitter_title, :twitter_description, :short_seo_description,
            :filename, :filepath_original, :filepath_webp, :filepath_thumbnail,
            :mime_type, :file_size, :width, :height, :is_transparent
        )";

        Database::query($sql, $data);
        return Database::lastInsertId();
    }

    public static function getLatest($limit = 12) {
        return Database::fetchAll("SELECT * FROM images ORDER BY created_at DESC LIMIT " . (int)$limit);
    }
}
