<?php
class BackgroundRemover {

    /**
     * Process background removal and generate transparent PNG
     */
    public static function process($image) {
        $sourcePath = PUBLIC_DIR . '/' . $image['filepath_original'];
        if (!file_exists($sourcePath)) {
            return ['status' => false, 'error' => 'Source image not found.'];
        }

        // Ensure directories exist
        if (!is_dir(PNG_DIR)) {
            mkdir(PNG_DIR, 0755, true);
        }

        $cacheDir = PNG_DIR . '/cache';
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0755, true);
        }

        // SEO Safe Filename
        $cleanBase = preg_replace('/-+/', '-', strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $image['title'])));
        $cleanBase = trim($cleanBase, '-');
        if (empty($cleanBase)) { $cleanBase = 'pixvora-image'; }

        $targetName = sprintf('%s-transparent-png.png', $cleanBase);
        $targetPath = $cacheDir . '/' . $targetName;

        // Cache Check (Generate Once -> Cache Forever)
        if (file_exists($targetPath)) {
            return [
                'status' => true,
                'path' => $targetPath,
                'preview_url' => BASE_URL . '/uploads/png/cache/' . $targetName,
                'download_url' => BASE_URL . '/download-png/' . $image['slug']
            ];
        }

        // Process Image using GD
        $sourceImage = null;
        switch ($image['mime_type']) {
            case 'image/jpeg': $sourceImage = imagecreatefromjpeg($sourcePath); break;
            case 'image/png':  $sourceImage = imagecreatefrompng($sourcePath); break;
            case 'image/webp': $sourceImage = imagecreatefromwebp($sourcePath); break;
        }

        if (!$sourceImage) {
            return ['status' => false, 'error' => 'Failed to load source image for processing.'];
        }

        $width = imagesx($sourceImage);
        $height = imagesy($sourceImage);

        // --- MOCK BACKGROUND REMOVAL LOGIC ---
        // In a real production environment, this would call an external API (like remove.bg)
        // or a local Python/C++ microservice running a model like U-2-Net or DIS.
        // For this purely PHP mock, we will create a transparent PNG and copy a circular/feathered mask
        // to simulate "isolation" of the foreground object to satisfy the architectural requirement.

        $newImage = imagecreatetruecolor($width, $height);

        // Setup transparency
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);
        $transparent = imagecolorallocatealpha($newImage, 0, 0, 0, 127);
        imagefill($newImage, 0, 0, $transparent);

        // Mock Segmentation: Copy a center ellipse to simulate subject isolation
        // (Just to make it visually obvious a "cutout" occurred during testing)
        $cx = $width / 2;
        $cy = $height / 2;
        $rx = $width * 0.4;
        $ry = $height * 0.45;

        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                // Check if inside ellipse
                if ((pow($x - $cx, 2) / pow($rx, 2)) + (pow($y - $cy, 2) / pow($ry, 2)) <= 1) {
                    $color = imagecolorat($sourceImage, $x, $y);
                    imagesetpixel($newImage, $x, $y, $color);
                }
            }
        }

        // Optimize and save PNG (compression level 9 for maximum size reduction while preserving quality)
        imagepng($newImage, $targetPath, 9);

        imagedestroy($sourceImage);
        imagedestroy($newImage);

        return [
            'status' => true,
            'path' => $targetPath,
            'preview_url' => BASE_URL . '/uploads/png/cache/' . $targetName,
            'download_url' => BASE_URL . '/download-png/' . $image['slug']
        ];
    }
}
