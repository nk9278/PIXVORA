<?php
class SearchController {

    public function index($args = []) {
        $categories = Category::getAll();

        // Process SEO-friendly query segment, fallback to ?q= parameter
        $urlQuery = $args['query'] ?? '';
        $getQuery = $_GET['q'] ?? '';

        $rawQuery = !empty($urlQuery) ? str_replace('-', ' ', urldecode($urlQuery)) : trim(Security::cleanInput($getQuery));
        $query = Security::esc($rawQuery);

        // Gather Filters
        $filters = [
            'category_slug' => Security::cleanInput($_GET['category'] ?? ''),
            'orientation'   => Security::cleanInput($_GET['orientation'] ?? ''),
            'color'         => Security::cleanInput($_GET['color'] ?? ''),
            'is_wallpaper'  => isset($_GET['format']) && $_GET['format'] === 'wallpaper' ? 1 : '',
            'is_png'        => isset($_GET['format']) && $_GET['format'] === 'png' ? 1 : ''
        ];

        // Gather Sort
        $sort = Security::cleanInput($_GET['sort'] ?? 'latest');

        // Execute Search
        $results = Image::search($query, $filters, $sort);

        // SEO Meta
        $displayQuery = empty($query) ? 'All Images' : ucwords($query);
        $meta_title = "{$displayQuery} - Free Images, PNGs & Wallpapers | Pixvora";
        $meta_description = "Download high-quality free images, transparent PNGs, and 4K wallpapers for '{$displayQuery}'.";
        $canonical_url = BASE_URL . "/search/" . strtolower(str_replace(' ', '-', $displayQuery)) . "/";

        $content_view = APP_DIR . '/views/search/index.php';
        require_once APP_DIR . '/views/layouts/main.php';
    }

    public function suggest() {
        $q = trim(Security::cleanInput($_GET['q'] ?? ''));
        if (empty($q)) {
            echo json_encode([]);
            exit;
        }

        $results = Image::suggest($q, 5);

        // Format for JSON
        $suggestions = [];
        foreach ($results as $res) {
            $suggestions[] = [
                'title' => Security::esc($res['title']),
                'url' => BASE_URL . '/image/' . $res['slug'] . '/',
                'thumb' => BASE_URL . '/' . $res['filepath_thumbnail']
            ];
        }

        header('Content-Type: application/json');
        echo json_encode($suggestions);
        exit;
    }
}
