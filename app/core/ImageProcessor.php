<?php
class ImageProcessor {

    /**
     * Process uploaded image: Validate, compress, convert to WebP, generate thumbnails
     * @param array $file $_FILES['image']
     * @return array Result with status and paths or error message
     */
    public static function processUpload($file) {
        if (!isset($file['error']) || is_array($file['error'])) {
            return ['status' => false, 'error' => 'Invalid parameters.'];
        }

        switch ($file['error']) {
            case UPLOAD_ERR_OK:
                break;
            case UPLOAD_ERR_NO_FILE:
                return ['status' => false, 'error' => 'No file sent.'];
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return ['status' => false, 'error' => 'Exceeded filesize limit.'];
            default:
                return ['status' => false, 'error' => 'Unknown errors.'];
        }

        // Check file size (e.g., 10MB limit)
        if ($file['size'] > 10485760) {
            return ['status' => false, 'error' => 'Exceeded filesize limit (10MB).'];
        }

        // Validate MIME type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $ext = array_search(
            $finfo->file($file['tmp_name']),
            ALLOWED_MIME_TYPES,
            true
        );

        if (false === $ext) {
            return ['status' => false, 'error' => 'Invalid file format. Allowed: JPG, PNG, WebP.'];
        }

        // Safe filename generation
        // Derive extension from MIME type to prevent malicious extensions
        $mimeToExt = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp'
        ];
        $finfoMime = $finfo->file($file['tmp_name']);
        $safeExt = $mimeToExt[$finfoMime] ?? 'bin';

        $filenameBase = bin2hex(random_bytes(16)); // Secure random name

        $originalName = sprintf('%s.%s', $filenameBase, $safeExt);
        $webpName = sprintf('%s.webp', $filenameBase);
        $thumbName = sprintf('%s_thumb.webp', $filenameBase);

        $originalPath = UPLOAD_DIR . '/' . $originalName;
        $webpPath = WEBP_DIR . '/' . $webpName;
        $thumbPath = THUMB_DIR . '/' . $thumbName;

        // Ensure directories exist
        if (!is_dir(UPLOAD_DIR)) { mkdir(UPLOAD_DIR, 0755, true); }
        if (!is_dir(WEBP_DIR)) { mkdir(WEBP_DIR, 0755, true); }
        if (!is_dir(THUMB_DIR)) { mkdir(THUMB_DIR, 0755, true); }

        // Move uploaded file securely
        if (!move_uploaded_file($file['tmp_name'], $originalPath)) {
            return ['status' => false, 'error' => 'Failed to move uploaded file.'];
        }

        // Create images using GD
        $mime = $finfo->file($originalPath);
        $sourceImage = null;
        $isTransparent = false;

        switch ($mime) {
            case 'image/jpeg':
                $sourceImage = imagecreatefromjpeg($originalPath);
                break;
            case 'image/png':
                $sourceImage = imagecreatefrompng($originalPath);
                $isTransparent = true; // Assuming PNGs could be transparent
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
            return ['status' => false, 'error' => 'Failed to process image file.'];
        }

        // Get dimensions
        $width = imagesx($sourceImage);
        $height = imagesy($sourceImage);

        // Convert and compress to WebP
        imagewebp($sourceImage, $webpPath, 85); // 85 quality

        // Generate Thumbnail (max 600px width/height)
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
        imagewebp($thumbImage, $thumbPath, 75); // Lower quality for thumbnail

        // Free memory
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
            'file_size' => filesize($originalPath),
            'is_transparent' => $isTransparent ? 1 : 0
        ];
    }
}
