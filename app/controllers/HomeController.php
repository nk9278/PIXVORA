<?php
class HomeController {
    public function index() {
        $categories = Category::getAll();

        $meta_title = "Pixvora | Premium AI Assets & Free Stock Images";
        $meta_description = "Download free AI images, premium stock photos, transparent PNGs, and mobile wallpapers. Modern creator-focused copyright-free visuals.";

        require_once APP_DIR . '/views/layouts/main.php';
    }

    public function image($args) {
        $category_slug = $args['category_slug'] ?? '';
        $image_slug = $args['image_slug'] ?? '';
        echo "Phase 2: Image View for $image_slug (Coming soon in Phase 3)";
    }

    public function category($args) {
        $category_slug = $args['category_slug'] ?? '';
        echo "Phase 2: Category View for $category_slug (Coming soon in Phase 3)";
    }
}
