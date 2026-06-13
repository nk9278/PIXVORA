<?php
class BlogController {

    public function index() {
        $latestPosts = Blog::getLatest(12);

        $meta_title = "Creator Blog & Design Resources | Pixvora";
        $meta_description = "Read our latest articles, tutorials, and insights for modern creators. Free business backgrounds, SEO tips, and transparent PNG design guides.";
        $canonical_url = BASE_URL . "/blog/";

        $content_view = APP_DIR . '/views/blog/index.php';
        require_once APP_DIR . '/views/layouts/main.php';
    }

    public function category($args) {
        $categorySlug = $args['category'] ?? '';
        $categoryName = ucwords(str_replace('-', ' ', $categorySlug));

        $latestPosts = Blog::getByCategory($categoryName, 12);

        $meta_title = "{$categoryName} Articles & Guides | Pixvora Blog";
        $meta_description = "Explore all articles and guides related to {$categoryName} on the Pixvora Creator Blog.";
        $canonical_url = BASE_URL . "/blog/category/" . Security::esc($categorySlug) . "/";

        $content_view = APP_DIR . '/views/blog/index.php';
        require_once APP_DIR . '/views/layouts/main.php';
    }

    public function article($args) {
        $slug = $args['slug'] ?? '';
        $post = Blog::getBySlug($slug);

        if (!$post) {
            header("HTTP/1.0 404 Not Found");
            echo "404 - Article not found.";
            return;
        }

        // Analytics
        Blog::incrementViews($post['id']);

        // Fetch Related
        $relatedPosts = Blog::getRelated($post['id'], $post['category'], 3);

        // SEO Variables
        $meta_title = !empty($post['meta_title']) ? $post['meta_title'] : "{$post['title']} | Pixvora Blog";
        $meta_description = !empty($post['meta_description']) ? $post['meta_description'] : substr(strip_tags($post['content']), 0, 160) . '...';
        $canonical_url = !empty($post['canonical_url']) ? $post['canonical_url'] : BASE_URL . "/blog/{$slug}/";

        $og_title = !empty($post['og_title']) ? $post['og_title'] : $meta_title;
        $og_description = !empty($post['og_description']) ? $post['og_description'] : $meta_description;
        $og_image = !empty($post['featured_image']) ? BASE_URL . '/' . $post['featured_image'] : '';

        $twitter_title = !empty($post['twitter_title']) ? $post['twitter_title'] : $og_title;
        $twitter_description = !empty($post['twitter_description']) ? $post['twitter_description'] : $og_description;

        $is_image_page = true; // Signals main.php to use og:type="article"

        // Schema Markup
        $schema = [
            "@context" => "https://schema.org",
            "@graph" => [
                [
                    "@type" => "Article",
                    "headline" => $post['title'],
                    "image" => $og_image,
                    "datePublished" => date('c', strtotime($post['created_at'])),
                    "dateModified" => date('c', strtotime($post['updated_at'])),
                    "author" => [
                        "@type" => "Person",
                        "name" => $post['author_name'] ?: 'Pixvora Team'
                    ],
                    "publisher" => [
                        "@type" => "Organization",
                        "name" => "Pixvora",
                        "logo" => [
                            "@type" => "ImageObject",
                            "url" => BASE_URL . "/assets/img/logo.png"
                        ]
                    ]
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
                            "name" => "Blog",
                            "item" => BASE_URL . "/blog/"
                        ],
                        [
                            "@type" => "ListItem",
                            "position" => 3,
                            "name" => $post['title'],
                            "item" => $canonical_url
                        ]
                    ]
                ]
            ]
        ];
        $schema_markup = json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);

        // Auto-Generate Table of Contents
        $toc = [];
        $content = preg_replace_callback('/<h([2-3])>(.*?)<\/h\1>/', function($matches) use (&$toc) {
            $level = $matches[1];
            $text = strip_tags($matches[2]);
            $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text), '-'));
            $toc[] = ['level' => $level, 'text' => $text, 'id' => $slug];
            return "<h{$level} id=\"{$slug}\">{$matches[2]}</h{$level}>";
        }, $post['content'] ?? '');

        $content_view = APP_DIR . '/views/blog/article.php';
        require_once APP_DIR . '/views/layouts/main.php';
    }
}
