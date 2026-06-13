<?php
class ImageGenerator {

    // Defined target formats & dimensions to prevent arbitrary generation abuse
    private static $formats = [
        'original'          => ['w' => null, 'h' => null, 'quality' => 100],
        'instagram-post'    => ['w' => 1080, 'h' => 1080, 'quality' => 90],
        'instagram-story'   => ['w' => 1080, 'h' => 1920, 'quality' => 85],
        'youtube-thumbnail' => ['w' => 1280, 'h' => 720,  'quality' => 85],
        'mobile-wallpaper'  => ['w' => 1440, 'h' => 3200, 'quality' => 90],
        'desktop-wallpaper' => ['w' => 1920, 'h' => 1080, 'quality' => 95],
        'pinterest-pin'     => ['w' => 1000, 'h' => 1500, 'quality' => 85],
        'website-hero'      => ['w' => 1600, 'h' => 900,  'quality' => 85],
        'facebook-post'     => ['w' => 1200, 'h' => 630,  'quality' => 85],
        'linkedin-banner'   => ['w' => 1584, 'h' => 396,  'quality' => 85],
    ];

    /**
     * Generate or fetch cached optimized image version
     */
    public static function generate($image, $formatKey) {
        if (!array_key_exists($formatKey, self::$formats)) {
            return false; // Prevent malformed dimension attacks
        }

        $sourcePath = PUBLIC_DIR . '/' . $image['filepath_original'];
        if (!file_exists($sourcePath)) {
            return false;
        }

        $format = self::$formats[$formatKey];
        $slugBase = preg_replace('/-[a-z0-9]{8}$/i', '', pathinfo($image['filepath_original'], PATHINFO_FILENAME)); // Try to get base

        // Use clean slug logic for SEO-safe filenames: modern-business-office-instagram-post.webp
        $cleanBase = preg_replace('/-+/', '-', strtolower(preg_replace('/[^a-zA-Z0-9]/', '-', $image['title'])));
        $cleanBase = trim($cleanBase, '-');
        if (empty($cleanBase)) { $cleanBase = 'pixvora-image'; }

        // If format is original, we just serve original file
        if ($formatKey === 'original') {
            return [
                'path' => $sourcePath,
                'mime' => $image['mime_type'],
                'download_name' => $cleanBase . '-original.' . pathinfo($sourcePath, PATHINFO_EXTENSION)
            ];
        }

        $targetName = sprintf('%s-%s.webp', $cleanBase, $formatKey);
        $targetFolder = GENERATED_DIR . '/' . $formatKey;
        $targetPath = $targetFolder . '/' . $targetName;

        // Create specific format cache folder
        if (!is_dir($targetFolder)) {
            mkdir($targetFolder, 0755, true);
        }

        // Return cached version immediately if it exists
        if (file_exists($targetPath)) {
            return [
                'path' => $targetPath,
                'mime' => 'image/webp',
                'download_name' => $targetName
            ];
        }

        // Generate dynamically
        $sourceImage = null;
        switch ($image['mime_type']) {
            case 'image/jpeg': $sourceImage = imagecreatefromjpeg($sourcePath); break;
            case 'image/png':  $sourceImage = imagecreatefrompng($sourcePath); break;
            case 'image/webp': $sourceImage = imagecreatefromwebp($sourcePath); break;
        }

        if (!$sourceImage) {
            return false;
        }

        $origW = imagesx($sourceImage);
        $origH = imagesy($sourceImage);

        $targetW = $format['w'];
        $targetH = $format['h'];

        // Smart Cropping (Center/Fill logic)
        $origRatio = $origW / $origH;
        $targetRatio = $targetW / $targetH;

        $srcX = 0;
        $srcY = 0;
        $srcW = $origW;
        $srcH = $origH;

        if ($origRatio > $targetRatio) {
            // Source is wider than target
            $srcW = (int)($origH * $targetRatio);
            $srcX = (int)(($origW - $srcW) / 2);
        } else if ($origRatio < $targetRatio) {
            // Source is taller than target
            $srcH = (int)($origW / $targetRatio);
            $srcY = (int)(($origH - $srcH) / 2);
        }

        $newImage = imagecreatetruecolor($targetW, $targetH);

        // Preserve transparency if original is PNG
        if ($image['mime_type'] === 'image/png') {
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
            imagefilledrectangle($newImage, 0, 0, $targetW, $targetH, $transparent);
        }

        imagecopyresampled(
            $newImage, $sourceImage,
            0, 0, $srcX, $srcY,
            $targetW, $targetH, $srcW, $srcH
        );

        // Convert and compress to WebP
        imagewebp($newImage, $targetPath, $format['quality']);

        imagedestroy($sourceImage);
        imagedestroy($newImage);

        return [
            'path' => $targetPath,
            'mime' => 'image/webp',
            'download_name' => $targetName
        ];
    }
}
