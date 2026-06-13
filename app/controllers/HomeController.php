<?php
class HomeController {
    public function index() {
        $categories = Category::getAll();
        $latestImages = Image::getLatest(12);

        $meta_title = "Pixvora | Premium AI Assets & Free Stock Images";
        $meta_description = "Download free AI images, premium stock photos, transparent PNGs, and mobile wallpapers. Modern creator-focused copyright-free visuals.";

        require_once APP_DIR . '/views/layouts/main.php';
    }

    public function image($args) {
        $category_slug = $args['category_slug'] ?? '';
        $image_slug = $args['image_slug'] ?? '';

        // Mock image detail view logic
        $meta_title = Security::esc(ucwords(str_replace('-', ' ', $image_slug)) . " - Pixvora");
        $meta_description = "Download this free high-quality image.";

        $content_view = APP_DIR . '/views/home/index.php'; // just to prevent 404 for now
        require_once APP_DIR . '/views/layouts/main.php';
    }

    public function category($args) {
        $slug = $args['category_slug'] ?? '';
        $category = Category::getBySlug($slug);

        if (!$category) {
            header("HTTP/1.0 404 Not Found");
            echo "Category not found.";
            return;
        }

        $meta_title = Security::esc($category['meta_title'] ?? $category['name'] . " - Pixvora");
        $meta_description = Security::esc($category['meta_description'] ?? "");

        // Mock showing images for this category
        $latestImages = [];
        $categories = [];

        require_once APP_DIR . '/views/layouts/main.php';
    }
}
