<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <h1>Premium AI Assets & Free Stock Images</h1>
        <p>Download copyright-free visuals, transparent PNGs, and 4K wallpapers. High-quality assets for modern creators.</p>

        <div class="search-box">
            <input type="text" class="search-input" placeholder="Search for images, transparent PNGs, wallpapers...">
        </div>

        <div class="category-scroll" style="margin-top: 30px; justify-content: center;">
            <span style="font-weight: 500; align-self: center; margin-right: 10px;">Trending:</span>
            <?php foreach (array_slice($categories, 0, 8) as $cat): ?>
                <a href="<?= BASE_URL ?>/<?= Security::esc($cat['slug']) ?>/" class="pill"><?= Security::esc($cat['name']) ?></a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- AdSense Header Placeholder -->
<div class="container" style="margin: 20px auto; text-align: center; background: #eaeaea; padding: 20px; border-radius: 8px;">
    <span class="text-muted">Advertisement Placement</span>
</div>

<!-- Latest Uploads Section -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2>Latest Free Assets</h2>
            <a href="#" class="btn btn-outline">View All</a>
        </div>

        <div class="masonry-grid">
            <?php if (!empty($latestImages)): ?>
                <?php foreach ($latestImages as $img): ?>
                    <div class="image-card">
                        <img src="<?= BASE_URL ?>/<?= Security::esc($img['filepath_thumbnail']) ?>" alt="<?= Security::esc($img['alt_text']) ?>" loading="lazy">
                        <div class="image-overlay">
                            <span><?= Security::esc($img['title']) ?></span>
                            <a href="<?= BASE_URL ?>/image/<?= Security::esc($img['slug']) ?>/" class="btn btn-primary" style="padding: 6px 12px; font-size: 0.8rem;">Download</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Mock Data for initial view -->
                <?php for($i=1; $i<=8; $i++): ?>
                    <div class="image-card" style="height: <?= rand(250, 450) ?>px; background: #e0e0e0;">
                        <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#999;">Image Placeholder <?= $i ?></div>
                        <div class="image-overlay">
                            <span>Premium Asset <?= $i ?></span>
                            <a href="#" class="btn btn-primary" style="padding: 6px 12px; font-size: 0.8rem;">Download</a>
                        </div>
                    </div>
                <?php endfor; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- SEO Content Block for Homepage -->
<section class="section" style="background: var(--clr-white); border-top: 1px solid var(--clr-border);">
    <div class="container">
        <div style="max-width: 800px; margin: 0 auto; text-align: center;">
            <h2 style="margin-bottom: 20px;">The Premium AI Asset Platform</h2>
            <p style="color: var(--clr-text-muted); margin-bottom: 20px;">
                Pixvora is your ultimate destination for high-quality, copyright-free visuals. Whether you're looking for <strong>free AI images</strong>, <strong>transparent PNG downloads</strong>, or <strong>4K mobile wallpapers</strong>, our curated platform offers a minimal, premium experience tailored for modern creators.
            </p>
            <p style="color: var(--clr-text-muted);">
                Our library includes assets perfect for social media, business presentations, ecommerce sites, and more. All our resources are optimized for speed and structured for seamless discovery, ensuring you find exactly what you need for your next creative project.
            </p>
        </div>
    </div>
</section>