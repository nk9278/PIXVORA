-- Phase 3 Expanded Schema
-- Phase 3 & 4 Expanded Schema
-- Pixvora Database Schema

CREATE DATABASE IF NOT EXISTS pixvora CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pixvora;

-- Admin Users Table
CREATE TABLE IF NOT EXISTS `admins` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `last_login` TIMESTAMP NULL,
    `failed_logins` INT DEFAULT 0,
    `lockout_time` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin
INSERT INTO `admins` (`username`, `password_hash`, `email`)
VALUES ('admin', '$2y$12$8vg7n1L/qY5kWdGjpmKpqeBMxQpnGTG2rvNdtXniTOljgjOF5cvaS', 'admin@trypixvora.com');

-- Categories Table
CREATE TABLE IF NOT EXISTS `categories` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `parent_id` INT NULL,
    `name` VARCHAR(100) NOT NULL,
    `slug` VARCHAR(100) NOT NULL UNIQUE,
    `meta_title` VARCHAR(255) NULL,
    `meta_description` TEXT NULL,
    `seo_content` TEXT NULL,
    `category_image` VARCHAR(255) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`parent_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Preload main categories
INSERT INTO `categories` (`name`, `slug`) VALUES
('Business', 'business'), ('Food', 'food'), ('Festivals', 'festivals'),
('Spiritual', 'spiritual'), ('Fashion', 'fashion'), ('Technology', 'technology'),
('Health', 'health'), ('Travel', 'travel'), ('Wallpapers', 'wallpapers'),
('Social Media', 'social-media'), ('Transparent PNG', 'transparent-png'),
('Ecommerce', 'ecommerce'), ('Gaming', 'gaming'), ('Luxury', 'luxury'), ('Nature', 'nature');

-- Images Table (Phase 4 fully expanded)
CREATE TABLE IF NOT EXISTS `images` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `category_id` INT NULL,
    `subcategory_id` INT NULL,

    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `meta_title` VARCHAR(255) NULL,
    `meta_description` TEXT NULL,
    `alt_text` VARCHAR(255) NULL,
    `focus_keywords` VARCHAR(255) NULL,
    `tags` VARCHAR(255) NULL,
    `caption` TEXT NULL,
    `canonical_url` VARCHAR(255) NULL,
    `og_title` VARCHAR(255) NULL,
    `og_description` TEXT NULL,
    `twitter_title` VARCHAR(255) NULL,
    `twitter_description` TEXT NULL,
    `short_seo_description` TEXT NULL,
    `image_credit` VARCHAR(255) NULL,
    `image_license` VARCHAR(255) NULL,

    `filename` VARCHAR(255) NOT NULL,
    `filepath_original` VARCHAR(255) NOT NULL,
    `filepath_webp` VARCHAR(255) NOT NULL,
    `filepath_thumbnail` VARCHAR(255) NOT NULL,
    `filepath_small` VARCHAR(255) NULL,
    `filepath_medium` VARCHAR(255) NULL,
    `filepath_large` VARCHAR(255) NULL,

    `mime_type` VARCHAR(50) NOT NULL,
    `file_size` INT NOT NULL,
    `width` INT NOT NULL,
    `height` INT NOT NULL,
    `is_transparent` BOOLEAN DEFAULT FALSE,
    `orientation` VARCHAR(20) DEFAULT 'square',
    `dominant_color` VARCHAR(7) NULL,

    `is_featured` BOOLEAN DEFAULT FALSE,
    `show_on_homepage` BOOLEAN DEFAULT TRUE,
    `is_trending` BOOLEAN DEFAULT FALSE,
    `is_recommended` BOOLEAN DEFAULT FALSE,
    `is_wallpaper` BOOLEAN DEFAULT FALSE,
    `is_png` BOOLEAN DEFAULT FALSE,

    `downloads` INT DEFAULT 0,
    `views` INT DEFAULT 0,

    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`subcategory_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `blogs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL UNIQUE,
    `content` LONGTEXT,
    `meta_title` VARCHAR(255),
    `meta_description` TEXT,
    `featured_image` VARCHAR(255),
    `tags` VARCHAR(255),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `settings` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `setting_key` VARCHAR(100) NOT NULL UNIQUE,
    `setting_value` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Note: In a real deploy, we would `ALTER TABLE images ADD COLUMN...` but for this phase we assume this is the schema format for new fields in Image table like orientation, is_featured, etc.
