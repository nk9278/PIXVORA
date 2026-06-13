<?php
class HomeController {
    public function index() {
        $categories = Category::getAll();
        $latestImages = Image::getLatest(8);

        $meta_title = "Pixvora | Premium AI Assets & Free Stock Images";
        $meta_description = "Download free AI images, premium stock photos, transparent PNGs, and mobile wallpapers. Modern creator-focused copyright-free visuals.";

        require_once APP_DIR . '/views/layouts/main.php';
    }

    public function image($args) {
        $category_slug = $args['category_slug'] ?? '';
        $image_slug = $args['image_slug'] ?? '';

        $image = Image::getBySlug($image_slug);

        if (!$image) {
            header("HTTP/1.0 404 Not Found");
            echo "404 - Image not found.";
            return;
        }

        // Increase view count
        Database::query("UPDATE images SET views = views + 1 WHERE id = :id", [':id' => $image['id']]);

        // Fetch related images
        $relatedImages = Image::getRelated($image['category_id'], $image['id'], 12);

        // SEO Variables Fallbacks
        $meta_title = !empty($image['meta_title']) ? $image['meta_title'] : "{$image['title']} - Free Download | Pixvora";
        $meta_description = !empty($image['meta_description']) ? $image['meta_description'] : "Download {$image['title']} for free. High quality AI generated images and assets from Pixvora.";
        $canonical_url = !empty($image['canonical_url']) ? $image['canonical_url'] : BASE_URL . "/{$category_slug}/{$image_slug}/";

        $og_title = !empty($image['og_title']) ? $image['og_title'] : $meta_title;
        $og_description = !empty($image['og_description']) ? $image['og_description'] : $meta_description;
        $og_image = BASE_URL . '/' . ($image['filepath_large'] ?? $image['filepath_original']);

        $twitter_title = !empty($image['twitter_title']) ? $image['twitter_title'] : $og_title;
        $twitter_description = !empty($image['twitter_description']) ? $image['twitter_description'] : $og_description;

        $is_image_page = true;

        // Structured Data Generation (ImageObject & BreadcrumbList)
        $schema = [
            "@context" => "https://schema.org",
            "@graph" => [
                [
                    "@type" => "ImageObject",
                    "contentUrl" => $og_image,
                    "creator" => [
                        "@type" => "Organization",
                        "name" => "Pixvora"
                    ],
                    "creditText" => !empty($image['image_credit']) ? $image['image_credit'] : "Pixvora Platform",
                    "copyrightNotice" => !empty($image['image_license']) ? $image['image_license'] : "Free for commercial use",
                    "description" => $meta_description,
                    "name" => $image['title'],
                    "uploadDate" => date('c', strtotime($image['created_at']))
                ],
                [
                    "@type" => "BreadcrumbList",
                    "itemListElement" => [
                        [
                            "@type" => "ListItem",
                            "position" => 1,
                            "name" => "Home",
                            "item" => BASE_URL . "/"
                        ],
                        [
                            "@type" => "ListItem",
                            "position" => 2,
                            "name" => $image['category_name'] ?? 'Uncategorized',
                            "item" => BASE_URL . "/" . ($image['category_slug'] ?? 'misc') . "/"
                        ],
                        [
                            "@type" => "ListItem",
                            "position" => 3,
                            "name" => $image['title'],
                            "item" => $canonical_url
                        ]
                    ]
                ]
            ]
        ];
        $schema_markup = json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

        $content_view = APP_DIR . '/views/home/image.php';
        require_once APP_DIR . '/views/layouts/main.php';
    }

    public function category($args) {
        $category_slug = $args['category_slug'] ?? '';
        echo "Phase 2: Category View for $category_slug (Coming soon in Phase 3)";
    }

    public function legal($args) {
        $pageTitle = $args['page'] ?? 'Legal Information';
        $meta_title = "{$pageTitle} | Pixvora";
        $meta_description = "Read our {$pageTitle} to understand how Pixvora operates, our licensing terms, and our commitment to providing free, high-quality AI assets.";

        $content_view = APP_DIR . '/views/home/legal.php';
        require_once APP_DIR . '/views/layouts/main.php';
    }
}
