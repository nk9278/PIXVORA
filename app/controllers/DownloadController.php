<?php
class DownloadController {

    public function process($args) {
        $slug = $args['slug'] ?? '';
        $format = $args['format'] ?? 'original';

        // 1. Fetch image
        $image = Image::getBySlug($slug);
        if (!$image) {
            header("HTTP/1.0 404 Not Found");
            echo "404 - Image not found.";
            return;
        }

        // 2. Generate or fetch cached file via ImageGenerator
        $result = ImageGenerator::generate($image, $format);

        if (!$result || !file_exists($result['path'])) {
            header("HTTP/1.0 500 Internal Server Error");
            echo "Failed to process image format.";
            return;
        }

        // 3. Update download statistics (Background process logic approximation)
        Database::query("UPDATE images SET downloads = downloads + 1 WHERE id = :id", [':id' => $image['id']]);

        // 4. Output optimized file for instant download
        $filePath = $result['path'];
        $downloadName = $result['download_name'];
        $mime = $result['mime'];
        $filesize = filesize($filePath);

        // Security & Cache Headers
        header('Content-Type: ' . $mime);
        header('Content-Disposition: attachment; filename="' . $downloadName . '"');
        header('Content-Length: ' . $filesize);
        header('Cache-Control: public, max-age=31536000'); // 1 year cache
        header('Pragma: public');
        header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');
        header('X-Content-Type-Options: nosniff');

        // Clear output buffer and read file
        while (ob_get_level()) {
            ob_end_clean();
        }
        readfile($filePath);
        exit();
    }
}
