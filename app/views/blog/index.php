<div class="container" style="padding-top: var(--space-lg);">

    <!-- Top Banner Ad Placeholder -->
    <div style="margin-bottom: var(--space-xl); padding: 20px; background: var(--clr-soft-white); text-align:center; border-radius: 8px;">
        <span class="text-muted" style="font-size:0.9rem;">AdSense Top Banner Placement</span>
    </div>

    <!-- Blog Header -->
    <div style="margin-bottom: var(--space-xl); text-align: center;">
        <h1 style="font-size: clamp(2.5rem, 5vw, 3.5rem); margin-bottom: 10px;"><?= isset($categoryName) ? Security::esc($categoryName) : 'Creator Blog' ?></h1>
        <p style="color: var(--clr-text-muted); font-size: 1.15rem; max-width:600px; margin:0 auto;">
            <?= isset($categoryName) ? "Explore all articles and guides related to {$categoryName}." : 'Resources, tutorials, and inspiration for modern creators.' ?>
        </p>
    </div>

    <!-- Category Filters -->
    <div style="display:flex; justify-content:center; flex-wrap:wrap; gap:10px; margin-bottom: var(--space-xl);">
        <a href="<?= BASE_URL ?>/blog/" class="pill <?= !isset($categoryName) ? 'active' : '' ?>" <?= !isset($categoryName) ? 'style="background:var(--clr-black); color:var(--clr-white);"' : '' ?>>All Posts</a>
        <?php
        $blogCats = ['Design', 'Wallpapers', 'Social Media', 'PNG', 'Creator Tips', 'SEO'];
        foreach($blogCats as $c):
            $isActive = isset($categoryName) && $categoryName == $c;
        ?>
            <a href="<?= BASE_URL ?>/blog/category/<?= strtolower(str_replace(' ', '-', $c)) ?>" class="pill" <?= $isActive ? 'style="background:var(--clr-black); color:var(--clr-white);"' : '' ?>><?= $c ?></a>
        <?php endforeach; ?>
    </div>

    <!-- Blog Grid -->
    <div style="display:grid; grid-template-columns:1fr; gap:var(--space-lg); @media(min-width:768px){grid-template-columns:1fr 1fr;} @media(min-width:1024px){grid-template-columns:repeat(3, 1fr);} margin-bottom: var(--space-xl);">
        <?php if (!empty($latestPosts)): ?>
            <?php foreach ($latestPosts as $post): ?>
                <a href="<?= BASE_URL ?>/blog/<?= Security::esc($post['slug']) ?>/" class="blog-card" style="display:flex; flex-direction:column; text-decoration:none; color:inherit; height:100%;">
                    <?php if(!empty($post['featured_image'])): ?>
                        <img src="<?= BASE_URL ?>/<?= Security::esc($post['featured_image']) ?>" alt="<?= Security::esc($post['featured_image_alt'] ?? $post['title']) ?>" class="blog-card-image" loading="lazy">
                    <?php else: ?>
                        <div class="blog-card-image" style="background:#e0e0e0; display:flex; align-items:center; justify-content:center; color:#999;"><i data-lucide="image" style="width:32px; height:32px;"></i></div>
                    <?php endif; ?>
                    <div class="blog-card-content" style="flex:1; display:flex; flex-direction:column;">
                        <span style="font-size:0.8rem; font-weight:600; color:var(--clr-accent-red); text-transform:uppercase; margin-bottom:10px;"><?= Security::esc($post['category']) ?></span>
                        <h3 style="font-size: 1.3rem; margin-bottom: 10px; line-height:1.3;"><?= Security::esc($post['title']) ?></h3>
                        <p style="color:var(--clr-text-muted); font-size:0.95rem; margin-bottom:15px; flex:1;">
                            <?= Security::esc(!empty($post['meta_description']) ? $post['meta_description'] : substr(strip_tags($post['content']), 0, 120) . '...') ?>
                        </p>
                        <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid var(--clr-border); padding-top:15px; margin-top:auto;">
                            <span style="font-size:0.85rem; font-weight:500;"><?= Security::esc($post['author_name']) ?></span>
                            <span style="font-size:0.85rem; color:var(--clr-text-muted);"><?= date('M j, Y', strtotime($post['created_at'])) ?></span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="grid-column: 1 / -1; text-align:center; padding: 50px 0;">
                <i data-lucide="file-text" style="width:48px; height:48px; color:#ccc; margin-bottom:15px;"></i>
                <h3>No articles found</h3>
                <p style="color:var(--clr-text-muted);">Check back later for new content.</p>
            </div>
        <?php endif; ?>
    </div>
</div>