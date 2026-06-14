<?php
class AdminController {
    public function index() {
        if (Security::isLoggedIn()) {
            header('Location: ' . BASE_URL . '/admin/dashboard');
        } else {
            header('Location: ' . BASE_URL . '/admin/login');
        }
        exit();
    }

    public function login() {
        if (Security::isLoggedIn()) {
            header('Location: ' . BASE_URL . '/admin/dashboard');
            exit();
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                $error = 'Invalid security token.';
            } else {
                $username = Security::cleanInput($_POST['username'] ?? '');
                $password = $_POST['password'] ?? '';

                $admin = Admin::authenticate($username, $password);
                if ($admin === 'locked') {
                    $error = 'Account is temporarily locked due to too many failed attempts. Try again in 15 minutes.';
                } else if ($admin) {
                    session_regenerate_id(true);
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_username'] = $admin['username'];
                    $_SESSION['last_activity'] = time();
                    header('Location: ' . BASE_URL . '/admin/dashboard');
                    exit();
                } else {
                    $error = 'Invalid credentials.';
                }
            }
        }

        $content_view = APP_DIR . '/views/admin/login.php';
        require_once APP_DIR . '/views/layouts/admin.php';
    }

    public function logout() {
        session_unset();
        session_destroy();
        header('Location: ' . BASE_URL . '/admin/login');
        exit();
    }

    public function dashboard() {
        Security::requireAdmin();

        $stats = [
            'total_images' => Image::getTotalCount(),
            'total_downloads' => Image::getTotalDownloads(),
            'total_categories' => Category::getTotalCount(),
            'latest_images' => Image::getLatest(5),
            'top_images' => Image::getMostDownloaded(5)
        ];

        $content_view = APP_DIR . '/views/admin/dashboard.php';
        require_once APP_DIR . '/views/layouts/admin.php';
    }

    public function upload() {
        Security::requireAdmin();
        $categories = Category::getAll();
        $success = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
            $isAjax = $isAjax || isset($_POST['ajax']);

            if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                $error = 'Invalid security token.';
                if ($isAjax) { echo json_encode(['status' => false, 'error' => $error]); exit; }
            } else if (!isset($_FILES['image'])) {
                $error = 'No image selected.';
                if ($isAjax) { echo json_encode(['status' => false, 'error' => $error]); exit; }
            } else {
                $processResult = ImageProcessor::processUpload($_FILES['image']);

                if (!$processResult['status']) {
                    $error = $processResult['error'];
                } else {
                    $slug = empty($_POST['slug']) ? ImageProcessor::cleanFilename($_POST['title']) : ImageProcessor::cleanFilename($_POST['slug']);
                    // strip extension from generated slug if present
                    $slug = preg_replace('/\.[^.]+$/', '', $slug);

                    $data = [
                        ':category_id' => !empty($_POST['category_id']) ? $_POST['category_id'] : null,
                        ':subcategory_id' => !empty($_POST['subcategory_id']) ? $_POST['subcategory_id'] : null,
                        ':title' => Security::cleanInput($_POST['title']),
                        ':slug' => $slug,
                        ':meta_title' => Security::cleanInput($_POST['meta_title'] ?? ''),
                        ':meta_description' => Security::cleanInput($_POST['meta_description'] ?? ''),
                        ':alt_text' => Security::cleanInput($_POST['alt_text'] ?? ''),
                        ':focus_keywords' => Security::cleanInput($_POST['focus_keywords'] ?? ''),
                        ':tags' => Security::cleanInput($_POST['tags'] ?? ''),
                        ':caption' => Security::cleanInput($_POST['caption'] ?? ''),
                        ':canonical_url' => Security::cleanInput($_POST['canonical_url'] ?? ''),
                        ':og_title' => Security::cleanInput($_POST['og_title'] ?? ''),
                        ':og_description' => Security::cleanInput($_POST['og_description'] ?? ''),
                        ':twitter_title' => Security::cleanInput($_POST['twitter_title'] ?? ''),
                        ':twitter_description' => Security::cleanInput($_POST['twitter_description'] ?? ''),
                        ':short_seo_description' => Security::cleanInput($_POST['short_seo_description'] ?? ''),
                        ':image_credit' => Security::cleanInput($_POST['image_credit'] ?? ''),
                        ':image_license' => Security::cleanInput($_POST['image_license'] ?? 'Free for commercial use'),

                        ':filename' => $processResult['filename'],
                        ':filepath_original' => $processResult['original_path'],
                        ':filepath_webp' => $processResult['webp_path'],
                        ':filepath_thumbnail' => $processResult['thumb_path'],
                        ':filepath_small' => $processResult['small_path'],
                        ':filepath_medium' => $processResult['medium_path'],
                        ':filepath_large' => $processResult['large_path'],
                        ':mime_type' => $processResult['mime_type'],
                        ':file_size' => $processResult['file_size'],
                        ':width' => $processResult['width'],
                        ':height' => $processResult['height'],
                        ':is_transparent' => $processResult['is_transparent'],
                        ':orientation' => $processResult['orientation'],
                        ':dominant_color' => $processResult['dominant_color'],

                        ':is_featured' => isset($_POST['is_featured']) ? 1 : 0,
                        ':show_on_homepage' => isset($_POST['show_on_homepage']) ? 1 : 0,
                        ':is_trending' => isset($_POST['is_trending']) ? 1 : 0,
                        ':is_recommended' => isset($_POST['is_recommended']) ? 1 : 0,
                        ':is_wallpaper' => isset($_POST['is_wallpaper']) ? 1 : 0,
                        ':is_png' => isset($_POST['is_png']) ? 1 : 0,
                    ];

                    try {
                        Image::create($data);
                        $success = 'Image uploaded and SEO data saved successfully.';
                        if ($isAjax) { echo json_encode(['status' => true, 'message' => $success]); exit; }
                    } catch (Exception $e) {
                        $error = 'Database error: ' . $e->getMessage();
                        if ($isAjax) { echo json_encode(['status' => false, 'error' => $error]); exit; }
                    }
                }

                if ($isAjax && !empty($error)) { echo json_encode(['status' => false, 'error' => $error]); exit; }
            }
        }

        $content_view = APP_DIR . '/views/admin/upload.php';
        require_once APP_DIR . '/views/layouts/admin.php';
    }

    public function bulkUpload() {
        Security::requireAdmin();
        $categories = Category::getAll();

        $content_view = APP_DIR . '/views/admin/bulk_upload.php';
        require_once APP_DIR . '/views/layouts/admin.php';
    }

    public function manageImages() {
        Security::requireAdmin();
        $images = Image::getLatest(50); // mock limit
        $content_view = APP_DIR . '/views/admin/manage_images.php';
        require_once APP_DIR . '/views/layouts/admin.php';
    }

    public function categories() {
        Security::requireAdmin();
        $categories = Category::getAll();
        $content_view = APP_DIR . '/views/admin/manage_categories.php';
        require_once APP_DIR . '/views/layouts/admin.php';
    }

    public function seoSettings() {
        Security::requireAdmin();
        $content_view = APP_DIR . '/views/admin/seo_settings.php';
        require_once APP_DIR . '/views/layouts/admin.php';
    }

    public function manageBlog() {
        Security::requireAdmin();
        $posts = Blog::getLatest(50, false); // Get drafts too
        $content_view = APP_DIR . '/views/admin/manage_blog.php';
        require_once APP_DIR . '/views/layouts/admin.php';
    }

    public function editBlog() {
        Security::requireAdmin();

        $error = '';
        $success = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                $error = 'Invalid security token.';
            } else {
                $slug = empty($_POST['slug']) ? ImageProcessor::cleanFilename($_POST['title']) : ImageProcessor::cleanFilename($_POST['slug']);

                $data = [
                    ':title' => Security::cleanInput($_POST['title']),
                    ':slug' => $slug,
                    ':content' => $_POST['content'] ?? '', // TinyMCE content allows HTML
                    ':category' => Security::cleanInput($_POST['category']),
                    ':tags' => Security::cleanInput($_POST['tags']),
                    ':featured_image' => Security::cleanInput($_POST['featured_image']),
                    ':author_name' => Security::cleanInput($_POST['author_name']),
                    ':status' => Security::cleanInput($_POST['status']),
                    ':meta_title' => Security::cleanInput($_POST['meta_title']),
                    ':meta_description' => Security::cleanInput($_POST['meta_description']),
                    ':focus_keywords' => Security::cleanInput($_POST['focus_keywords']),
                    ':canonical_url' => Security::cleanInput($_POST['canonical_url']),
                    ':og_title' => Security::cleanInput($_POST['og_title']),
                    ':og_description' => Security::cleanInput($_POST['og_description']),
                    ':twitter_title' => Security::cleanInput($_POST['twitter_title']),
                    ':twitter_description' => Security::cleanInput($_POST['twitter_description']),
                    ':featured_image_alt' => Security::cleanInput($_POST['featured_image_alt'])
                ];

                try {
                    Blog::create($data);
                    $success = 'Blog post saved successfully.';
                } catch (Exception $e) {
                    $error = 'Database error: ' . $e->getMessage();
                }
            }
        }

        $content_view = APP_DIR . '/views/admin/edit_blog.php';
        require_once APP_DIR . '/views/layouts/admin.php';
    }
}
