<div class="container" style="padding-top: var(--space-lg);">

    <!-- Search Header -->
    <div style="margin-bottom: var(--space-xl); text-align: center;">
        <h1 style="font-size: clamp(2rem, 4vw, 3rem); margin-bottom: 10px;">
            <?= empty($query) ? 'All Images' : 'Results for "' . Security::esc($query) . '"' ?>
        </h1>
        <p style="color: var(--clr-text-muted); font-size: 1.1rem;"><?= count($results) ?> premium assets found</p>
    </div>

    <div class="search-layout">
        <!-- Filter Sidebar -->
        <aside class="search-sidebar">
            <div class="glass" style="padding: 20px; border-radius: var(--radius-md);">
                <form id="filterForm" method="GET" action="<?= BASE_URL ?>/search">
                    <input type="hidden" name="q" value="<?= Security::esc($query) ?>">

                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
                        <h3 style="margin:0; font-size: 1.2rem;"><i data-lucide="sliders-horizontal" style="width:18px; vertical-align:middle;"></i> Filters</h3>
                        <a href="<?= BASE_URL ?>/search?q=<?= urlencode($query) ?>" style="font-size:0.85rem; color:var(--clr-text-muted); text-decoration:underline;">Clear</a>
                    </div>

                    <div class="filter-group">
                        <h4>Sort By</h4>
                        <select name="sort" class="form-control" onchange="this.form.submit()">
                            <option value="latest" <?= $sort == 'latest' ? 'selected' : '' ?>>Latest</option>
                            <option value="popular" <?= $sort == 'popular' ? 'selected' : '' ?>>Most Popular</option>
                            <option value="trending" <?= $sort == 'trending' ? 'selected' : '' ?>>Trending</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <h4>Category</h4>
                        <select name="category" class="form-control" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            <?php foreach($categories as $cat): ?>
                                <option value="<?= $cat['slug'] ?>" <?= ($filters['category_slug'] ?? '') == $cat['slug'] ? 'selected' : '' ?>><?= Security::esc($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-group">
                        <h4>Format</h4>
                        <div style="display:flex; flex-direction:column; gap:10px;">
                            <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                                <input type="radio" name="format" value="" <?= empty($filters['is_wallpaper']) && empty($filters['is_png']) ? 'checked' : '' ?> onchange="this.form.submit()"> Any Format
                            </label>
                            <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                                <input type="radio" name="format" value="wallpaper" <?= !empty($filters['is_wallpaper']) ? 'checked' : '' ?> onchange="this.form.submit()"> 4K Wallpaper
                            </label>
                            <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                                <input type="radio" name="format" value="png" <?= !empty($filters['is_png']) ? 'checked' : '' ?> onchange="this.form.submit()"> Transparent PNG
                            </label>
                        </div>
                    </div>

                    <div class="filter-group">
                        <h4>Orientation</h4>
                        <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                            <button type="submit" name="orientation" value="landscape" class="btn btn-outline <?= ($filters['orientation'] ?? '') == 'landscape' ? 'active' : '' ?>" style="padding:8px;">Landscape</button>
                            <button type="submit" name="orientation" value="portrait" class="btn btn-outline <?= ($filters['orientation'] ?? '') == 'portrait' ? 'active' : '' ?>" style="padding:8px;">Portrait</button>
                            <button type="submit" name="orientation" value="square" class="btn btn-outline <?= ($filters['orientation'] ?? '') == 'square' ? 'active' : '' ?>" style="padding:8px; grid-column:span 2;">Square</button>
                        </div>
                    </div>

                    <div class="filter-group">
                        <h4>Dominant Color</h4>
                        <div class="color-filters">
                            <?php
                            $colors = ['#ff0000', '#00ff00', '#0000ff', '#000000', '#ffffff', '#ffff00', '#800080'];
                            foreach($colors as $c):
                                $isActive = ($filters['color'] ?? '') == $c;
                            ?>
                                <button type="submit" name="color" value="<?= $c ?>" class="color-circle <?= $isActive ? 'active' : '' ?>" style="background-color: <?= $c ?>;" aria-label="Filter by color <?= $c ?>"></button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </form>
            </div>
        </aside>

        <!-- Results Area -->
        <main class="search-results-area">
            <?php if (!empty($results)): ?>
                <div class="masonry-grid">
                    <?php foreach ($results as $img): ?>
                        <div class="image-card masonry-item <?= $img['is_transparent'] ? 'checkerboard' : '' ?>">
                            <?= ImageProcessor::generatePictureTag($img) ?>
                            <div class="image-overlay">
                                <div>
                                    <span style="display:block; font-weight:600;"><?= Security::esc($img['title']) ?></span>
                                    <span style="font-size: 0.8rem; opacity:0.8;"><?= Security::esc($img['category_name']) ?></span>
                                </div>
                                <a href="<?= BASE_URL ?>/image/<?= Security::esc($img['slug']) ?>/" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.9rem;"><i data-lucide="download" style="width:16px; height:16px;"></i></a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- Empty State -->
                <div style="text-align: center; padding: var(--space-xl) 0;">
                    <i data-lucide="search-x" style="width:64px; height:64px; color:var(--clr-border); margin-bottom:20px;"></i>
                    <h2 style="margin-bottom:10px;">No results found</h2>
                    <p style="color:var(--clr-text-muted); margin-bottom:var(--space-lg);">We couldn't find any images matching your exact filters.</p>

                    <h3 style="font-size:1.1rem; margin-bottom:15px;">Trending Searches</h3>
                    <div style="display:flex; flex-wrap:wrap; gap:10px; justify-content:center;">
                        <a href="<?= BASE_URL ?>/search/business-office" class="pill">Business Office</a>
                        <a href="<?= BASE_URL ?>/search/transparent-png" class="pill">Transparent PNG</a>
                        <a href="<?= BASE_URL ?>/search/mobile-wallpaper" class="pill">Mobile Wallpaper</a>
                        <a href="<?= BASE_URL ?>/search/luxury" class="pill">Luxury Background</a>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>
