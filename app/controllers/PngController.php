<?php
class PngController {

    /**
     * API Endpoint to trigger background removal
     * Responds with JSON containing preview and download URLs
     */
    public function generate($args) {
        // Prevent abuse: strict POST and AJAX requirement
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !$isAjax) {
            header("HTTP/1.0 403 Forbidden");
            echo json_encode(['status' => false, 'error' => 'Invalid request method.']);
            exit;
        }

        // Validate CSRF token
        $token = $_POST['csrf_token'] ?? '';
        if (!Security::verifyCsrfToken($token)) {
            header("HTTP/1.0 403 Forbidden");
            echo json_encode(['status' => false, 'error' => 'Security token invalid or expired.']);
            exit;
        }

        $slug = $args['slug'] ?? '';
        $image = Image::getBySlug($slug);

        if (!$image) {
            header("HTTP/1.0 404 Not Found");
            echo json_encode(['status' => false, 'error' => 'Image not found.']);
            exit;
        }

        // Execute architecture for background removal & caching
        $result = BackgroundRemover::process($image);

        if (!$result['status']) {
            header("HTTP/1.0 500 Internal Server Error");
            echo json_encode(['status' => false, 'error' => $result['error']]);
            exit;
        }

        // Success response
        echo json_encode([
            'status' => true,
            'preview_url' => $result['preview_url'],
            'download_url' => $result['download_url']
        ]);
        exit;
    }

    /**
     * Endpoint to download the cached transparent PNG
     */
    public function download($args) {
        $slug = $args['slug'] ?? '';
        $image = Image::getBySlug($slug);

        if (!$image) {
            header("HTTP/1.0 404 Not Found");
            echo "404 - Image not found.";
            return;
        }

        $cleanBase = preg_replace('/-+/', '-', strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $image['title'])));
        $cleanBase = trim($cleanBase, '-');
        if (empty($cleanBase)) { $cleanBase = 'pixvora-image'; }

        $targetName = sprintf('%s-transparent-png.png', $cleanBase);
        $filePath = PNG_DIR . '/cache/' . $targetName;

        if (!file_exists($filePath)) {
            header("HTTP/1.0 404 Not Found");
            echo "PNG not found. Please generate it first.";
            return;
        }

        // Track download
        Database::query("UPDATE images SET downloads = downloads + 1 WHERE id = :id", [':id' => $image['id']]);

        // Secure file delivery
        $filesize = filesize($filePath);
        header('Content-Type: image/png');
        header('Content-Disposition: attachment; filename="' . $targetName . '"');
        header('Content-Length: ' . $filesize);
        header('Cache-Control: public, max-age=31536000');
        header('Pragma: public');
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
        header('X-Content-Type-Options: nosniff');

        while (ob_get_level()) {
            ob_end_clean();
        }
        readfile($filePath);
        exit();
    }
}
