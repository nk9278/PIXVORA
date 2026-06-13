<?php
class SitemapController {

    public function robots() {
        header('Content-Type: text/plain');
        echo "User-agent: *\n";
        echo "Allow: /\n";
        echo "Disallow: /admin/\n";
        echo "Disallow: /api/\n";
        echo "Sitemap: " . BASE_URL . "/sitemap.xml\n";
    }

    public function index() {
        header('Content-Type: application/xml; charset=utf-8');
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        $sitemaps = [
            BASE_URL . '/sitemap-categories.xml',
            BASE_URL . '/sitemap-images.xml'
        ];

        foreach ($sitemaps as $url) {
            echo "  <sitemap>\n";
            echo "    <loc>{$url}</loc>\n";
            echo "    <lastmod>" . date('Y-m-d\TH:i:sP') . "</lastmod>\n";
            echo "  </sitemap>\n";
        }

        echo '</sitemapindex>';
    }

    public function categories() {
        header('Content-Type: application/xml; charset=utf-8');
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        $categories = Category::getAll();

        // Main static categories
        foreach ($categories as $cat) {
            echo "  <url>\n";
            echo "    <loc>" . BASE_URL . "/" . Security::esc($cat['slug']) . "/</loc>\n";
            echo "    <changefreq>daily</changefreq>\n";
            echo "    <priority>0.9</priority>\n";
            echo "  </url>\n";
        }

        // Programmatic Landing Pages (Examples)
        $landingPages = [
            'free-ai-business-images',
            'free-mobile-wallpapers',
            'free-transparent-png',
            'free-youtube-thumbnail-backgrounds'
        ];

        foreach ($landingPages as $slug) {
            echo "  <url>\n";
            echo "    <loc>" . BASE_URL . "/collection/" . $slug . "/</loc>\n";
            echo "    <changefreq>weekly</changefreq>\n";
            echo "    <priority>0.8</priority>\n";
            echo "  </url>\n";
        }

        echo '</urlset>';
    }

    public function images() {
        header('Content-Type: application/xml; charset=utf-8');
        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">' . "\n";

        // In a real app, this should be paginated if > 50,000 images
        $images = Image::getLatest(1000);

        foreach ($images as $img) {
            $catSlug = $img['category_slug'] ?? 'misc';
            $url = BASE_URL . "/image/" . Security::esc($img['slug']) . "/";
            $imgUrl = BASE_URL . "/" . Security::esc($img['filepath_large'] ?? $img['filepath_original']);
            $title = Security::esc($img['title']);

            echo "  <url>\n";
            echo "    <loc>{$url}</loc>\n";
            echo "    <lastmod>" . date('Y-m-d\TH:i:sP', strtotime($img['updated_at'])) . "</lastmod>\n";
            echo "    <changefreq>weekly</changefreq>\n";
            echo "    <priority>0.7</priority>\n";
            echo "    <image:image>\n";
            echo "      <image:loc>{$imgUrl}</image:loc>\n";
            echo "      <image:title>{$title}</image:title>\n";
            echo "    </image:image>\n";
            echo "  </url>\n";
        }

        echo '</urlset>';
    }
}
