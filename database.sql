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
    `last_login` TIMESTAMP NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default admin (password is 'admin123' hashed using password_hash)
-- WARNING: Change this in production
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

-- Preload 15 main categories
INSERT INTO `categories` (`name`, `slug`, `meta_title`, `meta_description`) VALUES
('Business', 'business', 'Business Images & Vectors - Free AI Images & Stock Photos', 'Download free business stock images, professional corporate vectors, and high-quality workplace AI generated visuals.'),
('Food', 'food', 'Food Images & Backgrounds - Free AI Pictures', 'High resolution food photography, culinary backgrounds, and restaurant stock images.'),
('Festivals', 'festivals', 'Festival & Celebration Images - Free Downloads', 'Beautiful festival backgrounds, celebration photos, and holiday stock images.'),
('Spiritual', 'spiritual', 'Spiritual Images & Backgrounds - Free Stock', 'Peaceful spiritual backgrounds, meditation images, and religious AI generated photos.'),
('Fashion', 'fashion', 'Fashion Photography & Images - Free Stock Photos', 'High fashion photography, clothing textures, and stylish AI generated model images.'),
('Technology', 'technology', 'Technology Images & Tech Backgrounds - Free', 'Modern technology stock photos, cyber backgrounds, and futuristic AI images.'),
('Health', 'health', 'Health & Medical Images - Free Stock Photos', 'Medical backgrounds, healthcare stock images, and wellness photography.'),
('Travel', 'travel', 'Travel Images & Destination Photos - Free Stock', 'Beautiful travel destination photos, vacation backgrounds, and landmark images.'),
('Wallpapers', 'wallpapers', 'Free Wallpapers - 4K Desktop & Mobile Backgrounds', 'Download high quality 4K wallpapers for desktop, iPhone, and Android devices.'),
('Social Media', 'social-media', 'Social Media Assets & Backgrounds - Free', 'Free templates, post backgrounds, and social media icons.'),
('Transparent PNG', 'transparent-png', 'Free Transparent PNG Images - No Background', 'Download thousands of free transparent PNG images, cutouts, and isolated objects.'),
('Ecommerce', 'ecommerce', 'Ecommerce Images & Product Backgrounds - Free', 'Product photography backgrounds, online shopping images, and ecommerce assets.'),
('Gaming', 'gaming', 'Gaming Images & Backgrounds - Free 4K Stock', 'Esports backgrounds, gaming wallpapers, and futuristic tech photos.'),
('Luxury', 'luxury', 'Luxury Images & Premium Backgrounds - Free', 'Premium luxury lifestyle photos, gold textures, and high-end stock images.'),
('Nature', 'nature', 'Nature Images & Landscape Backgrounds - Free', 'Beautiful nature photography, landscape wallpapers, and outdoor stock photos.');

-- Images Table
CREATE TABLE IF NOT EXISTS `images` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `category_id` INT NULL,
    `subcategory_id` INT NULL,

    -- SEO Fields
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

    -- File details
    `filename` VARCHAR(255) NOT NULL,
    `filepath_original` VARCHAR(255) NOT NULL,
    `filepath_webp` VARCHAR(255) NOT NULL,
    `filepath_thumbnail` VARCHAR(255) NOT NULL,
    `mime_type` VARCHAR(50) NOT NULL,
    `file_size` INT NOT NULL,
    `width` INT NOT NULL,
    `height` INT NOT NULL,
    `is_transparent` BOOLEAN DEFAULT FALSE,

    -- Stats
    `downloads` INT DEFAULT 0,
    `views` INT DEFAULT 0,

    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL,
    FOREIGN KEY (`subcategory_id`) REFERENCES `categories`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tags Table (for many-to-many if needed, though simple comma-separated might suffice initially, good for normalization)
CREATE TABLE IF NOT EXISTS `tags` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(50) NOT NULL UNIQUE,
    `slug` VARCHAR(50) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `image_tags` (
    `image_id` INT NOT NULL,
    `tag_id` INT NOT NULL,
    PRIMARY KEY (`image_id`, `tag_id`),
    FOREIGN KEY (`image_id`) REFERENCES `images`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`tag_id`) REFERENCES `tags`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
