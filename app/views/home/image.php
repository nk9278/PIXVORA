<div class="container" style="padding-top: var(--space-md);">
    <!-- Breadcrumbs -->
    <nav aria-label="breadcrumb" style="font-size: 0.9rem; color: var(--clr-text-muted); margin-bottom: var(--space-md);">
        <a href="<?= BASE_URL ?>/" style="color: var(--clr-black);">Home</a> &rsaquo;
        <a href="<?= BASE_URL ?>/<?= Security::esc($image['category_slug'] ?? 'misc') ?>/" style="color: var(--clr-black);"><?= Security::esc($image['category_name'] ?? 'Uncategorized') ?></a> &rsaquo;
        <span aria-current="page"><?= Security::esc($image['title']) ?></span>
    </nav>

    <div class="image-detail-layout">
        <!-- Left: Image Preview & Details -->
        <main class="image-detail-main">
            <!-- Large Image Preview -->
            <div class="image-preview-container <?= $image['is_transparent'] ? 'checkerboard' : '' ?>" style="background-color: <?= Security::esc($image['dominant_color'] ?? '#f0f0f0') ?>;">
                <?= ImageProcessor::generatePictureTag($image, 'detail-img') ?>
            </div>

            <!-- Header and Social Share -->
            <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-top: var(--space-lg); flex-wrap:wrap; gap:20px;">
                <h1 style="font-size: 2rem; margin:0;"><?= Security::esc($image['title']) ?></h1>

                <div class="social-share" style="display:flex; gap:10px;">
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($canonical_url) ?>" target="_blank" class="btn btn-outline" style="padding:8px 12px;" aria-label="Share on Facebook"><i data-lucide="facebook" style="width:18px;"></i></a>
                    <a href="https://twitter.com/intent/tweet?url=<?= urlencode($canonical_url) ?>&text=<?= urlencode($image['title']) ?>" target="_blank" class="btn btn-outline" style="padding:8px 12px;" aria-label="Share on Twitter"><i data-lucide="twitter" style="width:18px;"></i></a>
                    <a href="https://pinterest.com/pin/create/button/?url=<?= urlencode($canonical_url) ?>&media=<?= urlencode($og_image) ?>&description=<?= urlencode($image['title']) ?>" target="_blank" class="btn btn-outline" style="padding:8px 12px;" aria-label="Share on Pinterest"><i data-lucide="bookmark" style="width:18px;"></i></a>
                </div>
            </div>

            <!-- SEO Content Block (Description / Caption) -->
            <div class="seo-content-block" style="margin-top: var(--space-md); font-size: 1.05rem; color: var(--clr-text-main); line-height: 1.8;">
                <p><?= Security::esc(!empty($image['caption']) ? $image['caption'] : (!empty($image['short_seo_description']) ? $image['short_seo_description'] : "Download this high-quality free image of {$image['title']}. Perfect for commercial use, presentations, websites, and creative projects. Optimized for fast loading and superior visual quality.")) ?></p>
            </div>

            <!-- Tags -->
            <?php if(!empty($image['tags'])): ?>
            <div class="tags-section" style="margin-top: var(--space-lg);">
                <h3 style="font-size:1.1rem; margin-bottom:15px;">Related Tags</h3>
                <div style="display:flex; flex-wrap:wrap; gap:10px;">
                    <?php
                    $tags = array_map('trim', explode(',', $image['tags']));
                    foreach($tags as $tag):
                        if(empty($tag)) continue;
                        $tagSlug = strtolower(str_replace(' ', '-', $tag));
                    ?>
                        <a href="<?= BASE_URL ?>/search?tag=<?= urlencode($tagSlug) ?>" class="pill" style="background:var(--clr-soft-white);"><?= Security::esc($tag) ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <!-- AdSense In-Content Placeholder -->
            <div style="margin: 40px 0; padding: 20px; background: var(--clr-border); text-align:center; border-radius: 8px;">
                <span class="text-muted" style="font-size:0.9rem;">Advertisement Placeholder</span>
            </div>

        </main>

        <!-- Right: Download Sidebar -->
        <aside class="image-detail-sidebar">
            <div class="download-card glass" style="padding: 25px; border-radius: var(--radius-md); position:sticky; top: 100px;">

                <!-- Main Download Button -->
                <a href="<?= BASE_URL ?>/<?= $image['filepath_original'] ?>" download class="btn btn-primary" style="width:100%; display:flex; justify-content:center; align-items:center; gap:10px; font-size:1.1rem; padding: 15px;">
                    <i data-lucide="download"></i> Download Free
                </a>
                <p style="text-align:center; font-size:0.85rem; color:var(--clr-text-muted); margin-top:10px;">
                    <i data-lucide="check-circle" style="width:12px; height:12px; vertical-align:middle;"></i> <?= Security::esc($image['image_license'] ?: 'Free for commercial use') ?>
                </p>

                <hr style="border:none; border-top:1px solid var(--clr-border); margin: 25px 0;">

                <h3 style="font-size:1.1rem; margin-bottom:15px;">Image Information</h3>
                <ul class="meta-list" style="list-style:none; padding:0; margin:0; font-size:0.95rem; display:flex; flex-direction:column; gap:12px; color:var(--clr-text-muted);">
                    <li style="display:flex; justify-content:space-between;">
                        <span>Resolution</span> <span style="color:var(--clr-black); font-weight:500;"><?= $image['width'] ?> &times; <?= $image['height'] ?></span>
                    </li>
                    <li style="display:flex; justify-content:space-between;">
                        <span>Format</span> <span style="color:var(--clr-black); font-weight:500;"><?= strtoupper(pathinfo($image['filepath_original'], PATHINFO_EXTENSION)) ?></span>
                    </li>
                    <li style="display:flex; justify-content:space-between;">
                        <span>Size</span> <span style="color:var(--clr-black); font-weight:500;"><?= number_format($image['file_size'] / 1024 / 1024, 2) ?> MB</span>
                    </li>
                    <li style="display:flex; justify-content:space-between;">
                        <span>Orientation</span> <span style="color:var(--clr-black); font-weight:500; text-transform:capitalize;"><?= $image['orientation'] ?></span>
                    </li>
                    <li style="display:flex; justify-content:space-between;">
                        <span>Downloads</span> <span style="color:var(--clr-black); font-weight:500;"><?= number_format($image['downloads']) ?></span>
                    </li>
                    <li style="display:flex; justify-content:space-between;">
                        <span>Published</span> <span style="color:var(--clr-black); font-weight:500;"><?= date('M d, Y', strtotime($image['created_at'])) ?></span>
                    </li>
                </ul>

                <?php if(!empty($image['is_transparent'])): ?>
                <div style="margin-top:20px; background: rgba(0,0,0,0.03); padding:10px; border-radius:6px; text-align:center; font-size:0.9rem;">
                    <strong><i data-lucide="layers" style="width:14px; vertical-align:middle;"></i> Transparent PNG</strong>
                </div>
                <?php endif; ?>

                <?php if(!empty($image['is_wallpaper'])): ?>
                <div style="margin-top:10px; background: rgba(0,0,0,0.03); padding:10px; border-radius:6px; text-align:center; font-size:0.9rem;">
                    <strong><i data-lucide="image" style="width:14px; vertical-align:middle;"></i> 4K Wallpaper</strong>
                </div>
                <?php endif; ?>
            </div>
        </aside>
    </div>
</div>

<!-- Related Images Section -->
<section class="section" style="background: var(--clr-white); margin-top:var(--space-xl);">
    <div class="container">
        <div class="section-header">
            <h2>Related <?= Security::esc($image['category_name'] ?? 'Images') ?></h2>
            <a href="<?= BASE_URL ?>/<?= Security::esc($image['category_slug'] ?? 'misc') ?>/" class="btn btn-outline">Explore Category</a>
        </div>

        <div class="masonry-grid">
            <?php if (!empty($relatedImages)): ?>
                <?php foreach ($relatedImages as $rel): ?>
                    <div class="image-card masonry-item">
                        <?= ImageProcessor::generatePictureTag($rel) ?>
                        <div class="image-overlay">
                            <div>
                                <span style="display:block; font-weight:600;"><?= Security::esc($rel['title']) ?></span>
                            </div>
                            <a href="<?= BASE_URL ?>/<?= Security::esc($image['category_slug'] ?? 'misc') ?>/<?= Security::esc($rel['slug']) ?>/" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.9rem;"><i data-lucide="download" style="width:16px; height:16px;"></i></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">No related images found yet.</p>
            <?php endif; ?>
        </div>
    </div>
</section>