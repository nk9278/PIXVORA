<div class="container" style="padding-top: var(--space-lg);">

    <!-- SEO Header & Intro -->
    <div style="margin-bottom: var(--space-xl); text-align: center; max-width: 800px; margin-left: auto; margin-right: auto;">
        <h1 style="font-size: clamp(2rem, 4vw, 3rem); margin-bottom: 20px;"><?= $h1 ?></h1>
        <p style="color: var(--clr-text-muted); font-size: 1.15rem; line-height: 1.8;"><?= $seo_intro ?></p>

        <!-- Automated Internal Linking: Related Tags -->
        <div style="margin-top: 30px; display: flex; flex-wrap: wrap; gap: 10px; justify-content: center;">
            <span style="font-weight: 500; align-self: center; color: var(--clr-text-muted);">Related Searches:</span>
            <?php foreach(array_slice($popularTags, 0, 8) as $tag): ?>
                <a href="<?= BASE_URL ?>/tag/<?= urlencode(str_replace(' ', '-', strtolower($tag['name']))) ?>/" class="pill">
                    <?= Security::esc($tag['name']) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Image Grid -->
    <div class="search-layout">
        <main class="search-results-area">
            <?php if (!empty($images)): ?>
                <div class="masonry-grid">
                    <?php foreach ($images as $img): ?>
                        <div class="image-card masonry-item <?= $img['is_transparent'] ? 'checkerboard' : '' ?>">
                            <?= ImageProcessor::generatePictureTag($img) ?>
                            <div class="image-overlay">
                                <div>
                                    <span style="display:block; font-weight:600;"><?= Security::esc($img['title']) ?></span>
                                </div>
                                <a href="<?= BASE_URL ?>/image/<?= Security::esc($img['slug']) ?>/" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.9rem;"><i data-lucide="download" style="width:16px; height:16px;"></i></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- SEO Pagination Structure (Mock UI) -->
                <div style="margin-top: 40px; text-align: center;">
                    <a href="#" class="btn btn-outline">Load More Assets</a>
                </div>

            <?php else: ?>
                <div style="text-align: center; padding: var(--space-xl) 0;">
                    <i data-lucide="image-off" style="width:64px; height:64px; color:var(--clr-border); margin-bottom:20px;"></i>
                    <h2 style="margin-bottom:10px;">More assets coming soon</h2>
                    <p style="color:var(--clr-text-muted); margin-bottom:var(--space-lg);">Our AI is actively generating more content for this category.</p>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <!-- SEO Content Architecture & AdSense Placeholder -->
    <div style="margin-top: var(--space-xl); border-top: 1px solid var(--clr-border); padding-top: var(--space-xl); padding-bottom: var(--space-xl);">

        <div style="margin: 0 auto 40px auto; padding: 20px; background: var(--clr-soft-white); text-align:center; border-radius: 8px;">
            <span class="text-muted" style="font-size:0.9rem;">AdSense In-Content Placement</span>
        </div>

        <div style="max-width: 800px; margin: 0 auto;">
            <h2 style="margin-bottom: 20px;">Why download <?= Security::esc($h1) ?> from Pixvora?</h2>
            <p style="color: var(--clr-text-muted); font-size: 1.05rem; line-height: 1.8; margin-bottom: 20px;">
                Our platform provides a fast, creator-focused experience. Every asset you find in the <strong><?= Security::esc($h1) ?></strong> collection is highly optimized. We automatically convert images to WebP formats for faster loading, and provide smart cropping tools so you can download the exact ratio you need for Instagram, YouTube, or your desktop wallpaper.
            </p>
            <p style="color: var(--clr-text-muted); font-size: 1.05rem; line-height: 1.8;">
                Additionally, if you need a cutout, our one-click transparent PNG engine automatically removes the background from the subject, saving you hours of editing time. Everything is completely free for commercial use, so you can build your projects without worrying about complex licensing agreements.
            </p>

            <h3 style="margin-top: 40px; margin-bottom: 20px;">Explore More Categories</h3>
            <div style="display:flex; flex-wrap:wrap; gap:10px;">
                <?php foreach(array_slice($categories, 0, 10) as $cat): ?>
                    <a href="<?= BASE_URL ?>/category/<?= Security::esc($cat['slug']) ?>/" class="pill" style="border-color: #ddd;">
                        <?= Security::esc($cat['name']) ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</div>
