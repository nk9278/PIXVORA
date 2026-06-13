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

                <!-- Main Download Button Trigger -->
                <button id="openDownloadModalBtn" class="btn btn-primary" style="width:100%; display:flex; justify-content:center; align-items:center; gap:10px; font-size:1.1rem; padding: 15px;">
                    <i data-lucide="download"></i> Download Image
                </button>
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

<!-- Advanced Download Modal -->
<div id="downloadModal" class="modal-overlay">
    <div class="download-modal">
        <button id="closeDownloadModalBtn" class="modal-close-btn" aria-label="Close modal">
            <i data-lucide="x"></i>
        </button>

        <!-- Preview Pane -->
        <div class="modal-preview-pane">
            <div class="modal-preview-img-wrapper <?= $image['is_transparent'] ? 'checkerboard' : '' ?>" id="dynamicPreviewWrapper">
                <img src="<?= BASE_URL ?>/<?= $image['filepath_medium'] ?? $image['filepath_original'] ?>" alt="Preview">
            </div>
            <div style="position:absolute; bottom:15px; background:rgba(0,0,0,0.6); color:#fff; padding:5px 12px; border-radius:50px; font-size:0.8rem;" id="previewBadge">Original</div>
        </div>

        <!-- Selection Pane -->
        <div class="modal-content-pane">
            <h2 style="margin-top:0; font-size:1.5rem; margin-bottom:5px;">Download Options</h2>
            <p style="color:var(--clr-text-muted); font-size:0.9rem; margin-bottom:var(--space-md);">Select a format to automatically crop and optimize this image.</p>

            <div class="ratio-grid" id="ratioOptions">
                <!-- Original -->
                <div class="ratio-card active" data-format="original" data-ratio="<?= $image['width'] / $image['height'] ?>" data-name="Original Image">
                    <div class="ratio-icon"><i data-lucide="image"></i></div>
                    <div>
                        <div style="font-weight:600; font-size:0.9rem;">Original</div>
                        <div style="font-size:0.8rem; color:#888;"><?= $image['width'] ?>x<?= $image['height'] ?></div>
                    </div>
                </div>
                <!-- Social Media -->
                <div class="ratio-card" data-format="instagram-post" data-ratio="1" data-name="Instagram Post">
                    <div class="ratio-icon"><i data-lucide="instagram"></i></div>
                    <div>
                        <div style="font-weight:600; font-size:0.9rem;">IG Post</div>
                        <div style="font-size:0.8rem; color:#888;">1080x1080</div>
                    </div>
                </div>
                <div class="ratio-card" data-format="instagram-story" data-ratio="0.5625" data-name="Instagram Story">
                    <div class="ratio-icon"><i data-lucide="smartphone"></i></div>
                    <div>
                        <div style="font-weight:600; font-size:0.9rem;">IG Story</div>
                        <div style="font-size:0.8rem; color:#888;">1080x1920</div>
                    </div>
                </div>
                <div class="ratio-card" data-format="youtube-thumbnail" data-ratio="1.777" data-name="YouTube Thumbnail">
                    <div class="ratio-icon"><i data-lucide="youtube"></i></div>
                    <div>
                        <div style="font-weight:600; font-size:0.9rem;">YT Thumb</div>
                        <div style="font-size:0.8rem; color:#888;">1280x720</div>
                    </div>
                </div>
                <div class="ratio-card" data-format="pinterest-pin" data-ratio="0.666" data-name="Pinterest Pin">
                    <div class="ratio-icon"><i data-lucide="pin"></i></div>
                    <div>
                        <div style="font-weight:600; font-size:0.9rem;">Pinterest</div>
                        <div style="font-size:0.8rem; color:#888;">1000x1500</div>
                    </div>
                </div>
                <div class="ratio-card" data-format="linkedin-banner" data-ratio="4" data-name="LinkedIn Banner">
                    <div class="ratio-icon"><i data-lucide="linkedin"></i></div>
                    <div>
                        <div style="font-weight:600; font-size:0.9rem;">LinkedIn</div>
                        <div style="font-size:0.8rem; color:#888;">1584x396</div>
                    </div>
                </div>
                <!-- Wallpapers -->
                <div class="ratio-card" data-format="mobile-wallpaper" data-ratio="0.45" data-name="Mobile Wallpaper">
                    <div class="ratio-icon"><i data-lucide="smartphone"></i></div>
                    <div>
                        <div style="font-weight:600; font-size:0.9rem;">Mobile WP</div>
                        <div style="font-size:0.8rem; color:#888;">1440x3200</div>
                    </div>
                </div>
                <div class="ratio-card" data-format="desktop-wallpaper" data-ratio="1.777" data-name="Desktop Wallpaper">
                    <div class="ratio-icon"><i data-lucide="monitor"></i></div>
                    <div>
                        <div style="font-weight:600; font-size:0.9rem;">Desktop WP</div>
                        <div style="font-size:0.8rem; color:#888;">1920x1080</div>
                    </div>
                </div>
            </div>

            <div style="margin-top:auto; padding-top:var(--space-md); border-top:1px solid var(--clr-border);">
                <a href="<?= BASE_URL ?>/download/<?= Security::esc($image['slug']) ?>/original" id="finalDownloadBtn" class="btn btn-primary" style="width:100%; display:flex; justify-content:center; align-items:center; gap:10px; padding:15px; font-size:1.1rem;">
                    <i data-lucide="download"></i> Download <span id="btnFormatName">Original</span>
                </a>
                <p style="text-align:center; font-size:0.8rem; color:#888; margin-top:10px;">Generated instantly. Cache enabled for fast delivery.</p>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('downloadModal');
        const openBtn = document.getElementById('openDownloadModalBtn');
        const closeBtn = document.getElementById('closeDownloadModalBtn');
        const ratioCards = document.querySelectorAll('.ratio-card');
        const previewWrapper = document.getElementById('dynamicPreviewWrapper');
        const previewBadge = document.getElementById('previewBadge');
        const finalDownloadBtn = document.getElementById('finalDownloadBtn');
        const btnFormatName = document.getElementById('btnFormatName');
        const imageSlug = "<?= Security::esc($image['slug']) ?>";
        const baseUrl = "<?= BASE_URL ?>";

        function updatePreview(ratio, name, formatKey) {
            // Update UI active state
            ratioCards.forEach(c => c.classList.remove('active'));
            const activeCard = document.querySelector(`.ratio-card[data-format="${formatKey}"]`);
            if(activeCard) activeCard.classList.add('active');

            // Set wrapper aspect ratio visually (max width 280, max height 280)
            let w = 280;
            let h = 280;
            if (ratio > 1) {
                h = w / ratio;
            } else {
                w = h * ratio;
            }
            previewWrapper.style.width = `${w}px`;
            previewWrapper.style.height = `${h}px`;

            // Update Labels
            previewBadge.textContent = name;
            btnFormatName.textContent = name;

            // Update Download Link
            finalDownloadBtn.href = `${baseUrl}/download/${imageSlug}/${formatKey}`;
        }

        openBtn.addEventListener('click', () => {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            // Trigger initial layout calculation
            const initialCard = document.querySelector('.ratio-card.active');
            updatePreview(parseFloat(initialCard.dataset.ratio), initialCard.dataset.name, initialCard.dataset.format);
        });

        const closeModal = () => {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        };

        closeBtn.addEventListener('click', closeModal);
        modal.addEventListener('click', (e) => {
            if (e.target === modal) closeModal();
        });

        ratioCards.forEach(card => {
            card.addEventListener('click', () => {
                updatePreview(
                    parseFloat(card.dataset.ratio),
                    card.dataset.name,
                    card.dataset.format
                );
            });
        });

        // Trigger download UX enhancements (close modal on click)
        finalDownloadBtn.addEventListener('click', () => {
            setTimeout(closeModal, 500);
        });
    });
</script>