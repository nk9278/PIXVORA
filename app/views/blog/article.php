<div class="container" style="padding-top: var(--space-lg); max-width:1200px;">

    <!-- Top Banner Ad Placeholder -->
    <div style="margin-bottom: var(--space-xl); padding: 20px; background: var(--clr-soft-white); text-align:center; border-radius: 8px;">
        <span class="text-muted" style="font-size:0.9rem;">AdSense Top Banner Placement</span>
    </div>

    <!-- Article Header -->
    <header style="text-align: center; max-width: 800px; margin: 0 auto var(--space-xl);">
        <a href="<?= BASE_URL ?>/blog/category/<?= strtolower(str_replace(' ', '-', $post['category'])) ?>" style="font-size:0.85rem; font-weight:600; color:var(--clr-accent-red); text-transform:uppercase; letter-spacing:1px; text-decoration:none; margin-bottom:15px; display:inline-block;">
            <?= Security::esc($post['category']) ?>
        </a>
        <h1 style="font-size: clamp(2.5rem, 5vw, 4rem); line-height: 1.2; margin-bottom: 20px;"><?= Security::esc($post['title']) ?></h1>

        <div style="display:flex; justify-content:center; align-items:center; gap:15px; color:var(--clr-text-muted); font-size:0.95rem;">
            <span>By <strong><?= Security::esc($post['author_name']) ?></strong></span>
            <span>&bull;</span>
            <span><?= date('F j, Y', strtotime($post['created_at'])) ?></span>
            <span>&bull;</span>
            <span><?= number_format($post['views']) ?> views</span>
        </div>
    </header>

    <?php if(!empty($post['featured_image'])): ?>
    <div style="border-radius:var(--radius-lg); overflow:hidden; margin-bottom:var(--space-xl); box-shadow:var(--shadow-soft);">
        <img src="<?= BASE_URL ?>/<?= Security::esc($post['featured_image']) ?>" alt="<?= Security::esc($post['featured_image_alt'] ?? $post['title']) ?>" style="width:100%; max-height:600px; object-fit:cover; display:block;">
    </div>
    <?php endif; ?>

    <div class="search-layout">

        <!-- Left Sidebar: Table of Contents -->
        <aside class="search-sidebar" style="display:none; @media(min-width:1024px){display:block;}">
            <div style="position:sticky; top:100px;">
                <h4 style="font-size:0.9rem; text-transform:uppercase; letter-spacing:1px; margin-bottom:15px; color:var(--clr-text-muted);">Table of Contents</h4>
                <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:10px; border-left:2px solid var(--clr-border);">
                    <?php if(!empty($toc)): ?>
                        <?php foreach($toc as $item): ?>
                            <li style="padding-left:15px; <?= $item['level'] == 3 ? 'margin-left:10px; font-size:0.9rem;' : 'font-size:0.95rem; font-weight:500;' ?>">
                                <a href="#<?= $item['id'] ?>" style="color:var(--clr-text-main); text-decoration:none; transition:0.2s;" onmouseover="this.style.color='var(--clr-accent-red)'" onmouseout="this.style.color='var(--clr-text-main)'"><?= Security::esc($item['text']) ?></a>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li style="padding-left:15px; font-size:0.9rem; color:var(--clr-text-muted);">No headings found.</li>
                    <?php endif; ?>
                </ul>

                <!-- Sidebar AdSense Placeholder -->
                <div style="margin-top: 40px; padding: 20px; background: var(--clr-soft-white); text-align:center; border-radius: 8px; min-height:250px; display:flex; align-items:center; justify-content:center;">
                    <span class="text-muted" style="font-size:0.9rem;">Sidebar Ad Placement</span>
                </div>
            </div>
        </aside>

        <!-- Main Article Content -->
        <article class="search-results-area" style="font-size: 1.15rem; line-height: 1.8; color: #333;">

            <div class="blog-content">
                <!-- Using raw content here assuming TinyMCE generated safe HTML inside the admin panel -->
                <?= $post['content'] ?>
            </div>

            <!-- In-Content AdSense Placeholder -->
            <div style="margin: 40px 0; padding: 20px; background: var(--clr-soft-white); text-align:center; border-radius: 8px;">
                <span class="text-muted" style="font-size:0.9rem;">In-Content Ad Placement</span>
            </div>

            <!-- Tags -->
            <?php if(!empty($post['tags'])): ?>
            <div style="margin-top: 40px; display:flex; flex-wrap:wrap; gap:10px; align-items:center;">
                <span style="font-weight:600; font-size:1rem; margin-right:10px;">Tags:</span>
                <?php
                $tags = array_map('trim', explode(',', $post['tags']));
                foreach($tags as $tag):
                    if(empty($tag)) continue;
                    $tagSlug = strtolower(str_replace(' ', '-', $tag));
                ?>
                    <a href="<?= BASE_URL ?>/tag/<?= urlencode($tagSlug) ?>" class="pill" style="font-size:0.9rem; padding:6px 12px;"><?= Security::esc($tag) ?></a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <!-- Social Share -->
            <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid var(--clr-border); display:flex; align-items:center; gap:15px;">
                <span style="font-weight:600; font-size:1rem;">Share this article:</span>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($canonical_url) ?>" target="_blank" class="btn btn-outline" style="padding:8px 12px; border-radius:8px;"><i data-lucide="facebook" style="width:18px;"></i></a>
                <a href="https://twitter.com/intent/tweet?url=<?= urlencode($canonical_url) ?>&text=<?= urlencode($post['title']) ?>" target="_blank" class="btn btn-outline" style="padding:8px 12px; border-radius:8px;"><i data-lucide="twitter" style="width:18px;"></i></a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode($canonical_url) ?>&title=<?= urlencode($post['title']) ?>" target="_blank" class="btn btn-outline" style="padding:8px 12px; border-radius:8px;"><i data-lucide="linkedin" style="width:18px;"></i></a>
            </div>

        </article>
    </div>

    <!-- Related Content AdSense Placeholder -->
    <div style="margin: 40px 0; padding: 20px; background: var(--clr-soft-white); text-align:center; border-radius: 8px;">
        <span class="text-muted" style="font-size:0.9rem;">Related Content Ad Placement</span>
    </div>

    <!-- Related Blogs -->
    <?php if(!empty($relatedPosts)): ?>
    <div style="margin-top: var(--space-xl); padding-top: var(--space-xl); border-top: 1px solid var(--clr-border);">
        <h2 style="margin-bottom: var(--space-lg); text-align:center;">You might also like</h2>
        <div style="display:grid; grid-template-columns:1fr; gap:var(--space-lg); @media(min-width:768px){grid-template-columns:repeat(3, 1fr);}">
            <?php foreach ($relatedPosts as $rel): ?>
                <a href="<?= BASE_URL ?>/blog/<?= Security::esc($rel['slug']) ?>/" class="blog-card" style="display:flex; flex-direction:column; text-decoration:none; color:inherit;">
                    <?php if(!empty($rel['featured_image'])): ?>
                        <img src="<?= BASE_URL ?>/<?= Security::esc($rel['featured_image']) ?>" alt="<?= Security::esc($rel['title']) ?>" class="blog-card-image" loading="lazy" style="height:150px;">
                    <?php endif; ?>
                    <div class="blog-card-content" style="flex:1;">
                        <span style="font-size:0.75rem; font-weight:600; color:var(--clr-accent-red); text-transform:uppercase; margin-bottom:8px; display:block;"><?= Security::esc($rel['category']) ?></span>
                        <h4 style="font-size: 1.1rem; margin-bottom: 0; line-height:1.3;"><?= Security::esc($rel['title']) ?></h4>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

</div>

<style>
/* Blog Typography & Content Styling */
.blog-content h2 { margin-top: 40px; margin-bottom: 20px; font-size: 2rem; }
.blog-content h3 { margin-top: 30px; margin-bottom: 15px; font-size: 1.5rem; }
.blog-content p { margin-bottom: 20px; color: #444; }
.blog-content img { max-width: 100%; height: auto; border-radius: var(--radius-md); margin: 30px 0; }
.blog-content a { color: var(--clr-accent-red); text-decoration: underline; }
.blog-content ul, .blog-content ol { margin-bottom: 20px; padding-left: 20px; }
.blog-content li { margin-bottom: 10px; }
.blog-content blockquote { border-left: 4px solid var(--clr-accent-red); padding-left: 20px; margin: 30px 0; font-style: italic; color: #666; }
</style>