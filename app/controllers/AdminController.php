<?php
class AdminController {
    public function login() {
        if (Security::isLoggedIn()) {
            header('Location: ' . BASE_URL . '/admin/upload');
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
                if ($admin) {
                    session_regenerate_id(true); // Prevent session fixation
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_username'] = $admin['username'];
                    $_SESSION['last_activity'] = time();
                    header('Location: ' . BASE_URL . '/admin/upload');
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

    public function upload() {
        Security::requireAdmin();
        $categories = Category::getAll();
        $success = '';
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!Security::verifyCsrfToken($_POST['csrf_token'] ?? '')) {
                $error = 'Invalid security token.';
            } else if (!isset($_FILES['image'])) {
                $error = 'No image selected.';
            } else {
                // Process image
                $processResult = ImageProcessor::processUpload($_FILES['image']);

                if (!$processResult['status']) {
                    $error = $processResult['error'];
                } else {
                    // Gather SEO data
                    $slug = empty($_POST['slug']) ? $this->generateSlug($_POST['title']) : $this->generateSlug($_POST['slug']);

                    $data = [
                        ':category_id' => $_POST['category_id'] ?: null,
                        ':subcategory_id' => $_POST['subcategory_id'] ?: null,
                        ':title' => Security::cleanInput($_POST['title']),
                        ':slug' => $slug,
                        ':meta_title' => Security::cleanInput($_POST['meta_title']),
                        ':meta_description' => Security::cleanInput($_POST['meta_description']),
                        ':alt_text' => Security::cleanInput($_POST['alt_text']),
                        ':focus_keywords' => Security::cleanInput($_POST['focus_keywords']),
                        ':tags' => Security::cleanInput($_POST['tags']),
                        ':caption' => Security::cleanInput($_POST['caption']),
                        ':canonical_url' => Security::cleanInput($_POST['canonical_url']),
                        ':og_title' => Security::cleanInput($_POST['og_title']),
                        ':og_description' => Security::cleanInput($_POST['og_description']),
                        ':twitter_title' => Security::cleanInput($_POST['twitter_title']),
                        ':twitter_description' => Security::cleanInput($_POST['twitter_description']),
                        ':short_seo_description' => Security::cleanInput($_POST['short_seo_description']),

                        // File details
                        ':filename' => $processResult['filename'],
                        ':filepath_original' => str_replace('public/', '', $processResult['original_path']),
                        ':filepath_webp' => str_replace('public/', '', $processResult['webp_path']),
                        ':filepath_thumbnail' => str_replace('public/', '', $processResult['thumb_path']),
                        ':mime_type' => $processResult['mime_type'],
                        ':file_size' => $processResult['file_size'],
                        ':width' => $processResult['width'],
                        ':height' => $processResult['height'],
                        ':is_transparent' => $processResult['is_transparent']
                    ];

                    try {
                        Image::create($data);
                        $success = 'Image uploaded and processed successfully.';
                    } catch (Exception $e) {
                        $error = 'Database error: ' . $e->getMessage();
                    }
                }
            }
        }

        $content_view = APP_DIR . '/views/admin/upload.php';
        require_once APP_DIR . '/views/layouts/admin.php';
    }

    private function generateSlug($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        return empty($text) ? 'n-a' : $text;
    }
}
