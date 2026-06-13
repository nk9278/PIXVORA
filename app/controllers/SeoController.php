<?php
class SeoController {

    public function category($args) {
        $slug = $args['slug'] ?? '';
        $category = Category::getBySlug($slug);

        if (!$category) {
            header("HTTP/1.0 404 Not Found");
            echo "Category not found.";
            return;
        }

        $images = Image::search('', ['category_slug' => $slug], 'popular', 40);
        $popularTags = Tag::getPopular(15);
        $categories = Category::getAll();

        // SEO Content
        $name = Security::esc($category['name']);
        $h1 = "Download Free {$name} Images & Backgrounds";
        $seo_intro = "Explore our premium collection of copyright-free {$name} assets. Whether you're looking for high-quality transparent PNGs, 4K mobile wallpapers, or AI-generated stock photos, our {$name} category has everything you need for your next creative project.";

        $meta_title = !empty($category['meta_title']) ? $category['meta_title'] : "Free {$name} Images, Transparent PNGs & Wallpapers | Pixvora";
        $meta_description = !empty($category['meta_description']) ? $category['meta_description'] : "Download thousands of free {$name} stock images, AI backgrounds, and cutouts. High resolution, completely copyright-free assets for commercial use.";

        $canonical_url = BASE_URL . "/category/{$slug}/";
        $schema_markup = $this->generateCollectionSchema($canonical_url, $h1, $meta_description);

        $this->renderView($h1, $seo_intro, $images, $popularTags, $categories, $meta_title, $meta_description, $canonical_url, $schema_markup);
    }

    public function tag($args) {
        $slug = $args['slug'] ?? '';
        $query = str_replace('-', ' ', $slug);

        $images = Image::search($query, [], 'popular', 40);
        $popularTags = Tag::getPopular(15);
        $categories = Category::getAll();

        $name = ucwords(Security::esc($query));
        $h1 = "Free {$name} Assets";
        $seo_intro = "Discover the best free {$name} images, backgrounds, and transparent PNGs. Perfect for your social media posts, YouTube thumbnails, and web design projects. All assets are highly optimized and free to use.";

        $meta_title = "Free {$name} Images & Transparent PNGs | Pixvora";
        $meta_description = "Download free {$name} stock photos, wallpapers, and transparent PNGs. High quality assets ready for commercial use.";

        $canonical_url = BASE_URL . "/tag/{$slug}/";
        $schema_markup = $this->generateCollectionSchema($canonical_url, $h1, $meta_description);

        $this->renderView($h1, $seo_intro, $images, $popularTags, $categories, $meta_title, $meta_description, $canonical_url, $schema_markup);
    }

    public function landing($args) {
        $slug = $args['slug'] ?? '';
        $query = str_replace('-', ' ', $slug);
        $query = str_replace(['free', 'ai', 'images', 'wallpapers', 'transparent', 'png'], '', $query);
        $query = trim($query);

        $filters = [];
        if (strpos($slug, 'wallpaper') !== false) $filters['is_wallpaper'] = 1;
        if (strpos($slug, 'png') !== false) $filters['is_png'] = 1;

        $images = Image::search($query, $filters, 'popular', 40);
        $popularTags = Tag::getPopular(15);
        $categories = Category::getAll();

        $name = ucwords(str_replace('-', ' ', Security::esc($slug)));
        $h1 = "{$name}";
        $seo_intro = "Looking for {$name}? You're in the right place. Pixvora offers a growing collection of premium assets curated specifically for modern creators. Skip the subscription fees and instantly download optimized files right here.";

        $meta_title = "{$name} - Free Download | Pixvora";
        $meta_description = "High quality {$name}. Download premium assets, backgrounds, and templates instantly without watermarks.";

        $canonical_url = BASE_URL . "/collection/{$slug}/";
        $schema_markup = $this->generateCollectionSchema($canonical_url, $h1, $meta_description);

        $this->renderView($h1, $seo_intro, $images, $popularTags, $categories, $meta_title, $meta_description, $canonical_url, $schema_markup);
    }

    private function generateCollectionSchema($url, $name, $desc) {
        $schema = [
            "@context" => "https://schema.org",
            "@type" => "CollectionPage",
            "url" => $url,
            "name" => $name,
            "description" => $desc,
            "publisher" => [
                "@type" => "Organization",
                "name" => "Pixvora"
            ]
        ];
        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    }

    private function renderView($h1, $seo_intro, $images, $popularTags, $categories, $meta_title, $meta_description, $canonical_url, $schema_markup) {
        // Variables needed by the view
        $content_view = APP_DIR . '/views/seo/collection.php';
        require_once APP_DIR . '/views/layouts/main.php';
    }
}
