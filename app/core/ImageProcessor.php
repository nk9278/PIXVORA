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

    /**
     * Generate responsive srcset markup
     */
    public static function generatePictureTag($imageArray, $classes = '', $isLcp = false) {
        // Fallbacks if data doesn't exist
        $thumb = $imageArray['filepath_thumbnail'] ?? '';
        $small = $imageArray['filepath_small'] ?? $thumb;
        $medium = $imageArray['filepath_medium'] ?? $small;
        $large = $imageArray['filepath_large'] ?? $medium;
        $original = $imageArray['filepath_webp'] ?? $large;

        $alt = Security::esc($imageArray['alt_text'] ?? $imageArray['title'] ?? 'Image');
        $color = Security::esc($imageArray['dominant_color'] ?? '#e0e0e0');

        $loading = $isLcp ? 'eager' : 'lazy';
        $fetchpriority = $isLcp ? 'fetchpriority="high"' : '';

        // Output explicit width/height to prevent Cumulative Layout Shift (CLS)
        $w = $imageArray['width'] ?? '';
        $h = $imageArray['height'] ?? '';
        $dimensions = ($w && $h) ? "width=\"{$w}\" height=\"{$h}\"" : '';

        return '
        <picture>
            <source media="(min-width: 1200px)" srcset="' . BASE_URL . '/' . $large . ' 1x, ' . BASE_URL . '/' . $original . ' 2x" type="image/webp">
            <source media="(min-width: 768px)" srcset="' . BASE_URL . '/' . $medium . ' 1x, ' . BASE_URL . '/' . $large . ' 2x" type="image/webp">
            <source media="(max-width: 767px)" srcset="' . BASE_URL . '/' . $small . ' 1x, ' . BASE_URL . '/' . $medium . ' 2x" type="image/webp">
            <img src="' . BASE_URL . '/' . $small . '"
                 alt="' . $alt . '"
                 class="' . $classes . '"
                 loading="' . $loading . '"
                 decoding="async"
                 ' . $fetchpriority . '
                 ' . $dimensions . '
                 style="background-color: ' . $color . '; width: 100%; height: auto; display: block; object-fit: cover;">
        </picture>';
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

        $smallPath = RESPONSIVE_DIR . '/' . sprintf('%s-%s-small.webp', $nameBase, $uniqueId);
        $mediumPath = RESPONSIVE_DIR . '/' . sprintf('%s-%s-medium.webp', $nameBase, $uniqueId);
        $largePath = RESPONSIVE_DIR . '/' . sprintf('%s-%s-large.webp', $nameBase, $uniqueId);

        if (!is_dir(UPLOAD_DIR)) { mkdir(UPLOAD_DIR, 0755, true); }
        if (!is_dir(WEBP_DIR)) { mkdir(WEBP_DIR, 0755, true); }
        if (!is_dir(THUMB_DIR)) { mkdir(THUMB_DIR, 0755, true); }
        if (!is_dir(RESPONSIVE_DIR)) { mkdir(RESPONSIVE_DIR, 0755, true); }

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

        // Generate responsive sizes (Thumbnail: 300, Small: 600, Medium: 1200, Large: 1600)
        $sizes = [
            'thumb'  => ['max' => 300, 'path' => $thumbPath, 'quality' => 70],
            'small'  => ['max' => 600, 'path' => $smallPath, 'quality' => 75],
            'medium' => ['max' => 1200, 'path' => $mediumPath, 'quality' => 80],
            'large'  => ['max' => 1600, 'path' => $largePath, 'quality' => 80]
        ];

        $thumbImageRef = null;

        foreach ($sizes as $key => $config) {
            $maxSize = $config['max'];
            $newWidth = $width;
            $newHeight = $height;

            if ($width > $maxSize || $height > $maxSize) {
                if ($width > $height) {
                    $newWidth = $maxSize;
                    $newHeight = (int)(($height / $width) * $maxSize);
                } else {
                    $newHeight = $maxSize;
                    $newWidth = (int)(($width / $height) * $maxSize);
                }
            }

            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            if ($isTransparent) {
                imagealphablending($newImage, false);
                imagesavealpha($newImage, true);
                $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);
            }

            imagecopyresampled($newImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagewebp($newImage, $config['path'], $config['quality']);

            // Keep reference to thumbnail to calculate dominant color
            if ($key === 'thumb') {
                $thumbImageRef = $newImage;
            } else {
                imagedestroy($newImage);
            }
        }

        // Calculate dominant color from thumbnail
        $dominantColor = '#ffffff';
        if ($thumbImageRef && !$isTransparent) {
            // Downscale to 1x1 pixel to easily get average color
            $pixel = imagecreatetruecolor(1, 1);
            imagecopyresampled($pixel, $thumbImageRef, 0, 0, 0, 0, 1, 1, imagesx($thumbImageRef), imagesy($thumbImageRef));
            $rgb = imagecolorat($pixel, 0, 0);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;
            $dominantColor = sprintf("#%02x%02x%02x", $r, $g, $b);
            imagedestroy($pixel);
        }

        if ($thumbImageRef) {
            imagedestroy($thumbImageRef);
        }
        imagedestroy($sourceImage);

        return [
            'status' => true,
            'filename' => $originalName,
            'original_path' => 'public/uploads/originals/' . $originalName,
            'webp_path' => 'public/uploads/webp/' . $webpName,
            'thumb_path' => 'public/uploads/thumbnails/' . $thumbName,
            'small_path' => 'public/uploads/responsive/' . basename($smallPath),
            'medium_path' => 'public/uploads/responsive/' . basename($mediumPath),
            'large_path' => 'public/uploads/responsive/' . basename($largePath),
            'mime_type' => $mime,
            'width' => $width,
            'height' => $height,
            'orientation' => $orientation,
            'dominant_color' => $dominantColor,
            'file_size' => filesize($originalPath),
            'is_transparent' => $isTransparent ? 1 : 0
        ];
    }
}
