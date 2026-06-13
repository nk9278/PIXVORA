<?php
class ImageProcessor {

    /**
     * Convert dirty filename to clean SEO format
     */
    public static function cleanFilename($filename) {
        $info = pathinfo($filename);
        $name = $info['filename'];
        $ext = isset($info['extension']) ? '.' . strtolower($info['extension']) : '';

        // Lowercase, replace spaces/underscores with hyphens, remove non-alphanumeric except hyphens
        $name = strtolower($name);
        $name = preg_replace('/[\s_]+/', '-', $name);
        $name = preg_replace('/[^a-z0-9\-]/', '', $name);
        $name = preg_replace('/-+/', '-', $name);
        $name = trim($name, '-');

        if (empty($name)) {
            $name = 'image-' . bin2hex(random_bytes(4));
        }

        return $name . $ext;
    }

    public static function processUpload($file) {
        if (!isset($file['error']) || is_array($file['error'])) {
            return ['status' => false, 'error' => 'Invalid parameters.'];
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['status' => false, 'error' => 'Upload error code: ' . $file['error']];
        }

        // Validate size (15MB)
        if ($file['size'] > 15728640) {
            return ['status' => false, 'error' => 'Exceeded filesize limit (15MB).'];
        }

        // Validate MIME
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);

        $mimeToExt = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp'
        ];

        if (!array_key_exists($mime, $mimeToExt)) {
            return ['status' => false, 'error' => 'Invalid file format. Allowed: JPG, PNG, WEBP.'];
        }

        // SEO Safe Filename
        $cleanName = self::cleanFilename($file['name']);
        $nameBase = pathinfo($cleanName, PATHINFO_FILENAME);
        $uniqueId = substr(bin2hex(random_bytes(16)), 0, 8); // append short random string to prevent overwrites

        $originalName = sprintf('%s-%s.%s', $nameBase, $uniqueId, $mimeToExt[$mime]);
        $webpName = sprintf('%s-%s.webp', $nameBase, $uniqueId);
        $thumbName = sprintf('%s-%s-thumb.webp', $nameBase, $uniqueId);

        $originalPath = UPLOAD_DIR . '/' . $originalName;
        $webpPath = WEBP_DIR . '/' . $webpName;
        $thumbPath = THUMB_DIR . '/' . $thumbName;

        if (!is_dir(UPLOAD_DIR)) { mkdir(UPLOAD_DIR, 0755, true); }
        if (!is_dir(WEBP_DIR)) { mkdir(WEBP_DIR, 0755, true); }
        if (!is_dir(THUMB_DIR)) { mkdir(THUMB_DIR, 0755, true); }

        if (!move_uploaded_file($file['tmp_name'], $originalPath)) {
            return ['status' => false, 'error' => 'Failed to move uploaded file.'];
        }

        // Process GD
        $sourceImage = null;
        $isTransparent = false;

        switch ($mime) {
            case 'image/jpeg':
                $sourceImage = imagecreatefromjpeg($originalPath);
                break;
            case 'image/png':
                $sourceImage = imagecreatefrompng($originalPath);
                $isTransparent = true;
                imagepalettetotruecolor($sourceImage);
                imagealphablending($sourceImage, true);
                imagesavealpha($sourceImage, true);
                break;
            case 'image/webp':
                $sourceImage = imagecreatefromwebp($originalPath);
                break;
        }

        if (!$sourceImage) {
            unlink($originalPath);
            return ['status' => false, 'error' => 'Failed to process image file via GD.'];
        }

        $width = imagesx($sourceImage);
        $height = imagesy($sourceImage);

        $orientation = 'square';
        if ($width > $height) $orientation = 'landscape';
        else if ($height > $width) $orientation = 'portrait';

        // Auto compress WebP
        imagewebp($sourceImage, $webpPath, 85);

        // Auto Thumbnail (Max 600px)
        $thumbMaxSize = 600;
        $thumbWidth = $width;
        $thumbHeight = $height;

        if ($width > $thumbMaxSize || $height > $thumbMaxSize) {
            if ($width > $height) {
                $thumbWidth = $thumbMaxSize;
                $thumbHeight = (int)(($height / $width) * $thumbMaxSize);
            } else {
                $thumbHeight = $thumbMaxSize;
                $thumbWidth = (int)(($width / $height) * $thumbMaxSize);
            }
        }

        $thumbImage = imagecreatetruecolor($thumbWidth, $thumbHeight);
        if ($isTransparent) {
            imagealphablending($thumbImage, false);
            imagesavealpha($thumbImage, true);
            $transparent = imagecolorallocatealpha($thumbImage, 255, 255, 255, 127);
            imagefilledrectangle($thumbImage, 0, 0, $thumbWidth, $thumbHeight, $transparent);
        }

        imagecopyresampled($thumbImage, $sourceImage, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);
        imagewebp($thumbImage, $thumbPath, 75);

        imagedestroy($sourceImage);
        imagedestroy($thumbImage);

        return [
            'status' => true,
            'filename' => $originalName,
            'original_path' => 'public/uploads/originals/' . $originalName,
            'webp_path' => 'public/uploads/webp/' . $webpName,
            'thumb_path' => 'public/uploads/thumbnails/' . $thumbName,
            'mime_type' => $mime,
            'width' => $width,
            'height' => $height,
            'orientation' => $orientation,
            'file_size' => filesize($originalPath),
            'is_transparent' => $isTransparent ? 1 : 0
        ];
    }
}
