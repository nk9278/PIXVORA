<!-- Hero Section -->
<section class="hero">
    <div class="container">
        <div class="hero-grid">
            <div class="hero-content">
                <h1>Free Stock Images For Everyone</h1>
                <p>Download premium AI assets, copyright-free visuals, transparent PNGs, and 4K wallpapers. High-quality resources tailored for modern creators.</p>

                <div class="search-box">
                    <i data-lucide="search" style="position:absolute; left:20px; top:50%; transform:translateY(-50%); color:var(--clr-text-muted);"></i>
                    <input type="text" class="search-input" placeholder="Search free images, wallpapers, PNGs..." style="padding-left: 55px;">
                </div>

                <div style="margin-top: 20px; display: flex; flex-wrap: wrap; gap: 10px;">
                    <span style="font-weight: 500; align-self: center; color: var(--clr-text-muted);">Trending:</span>
                    <?php
                    $trending = ['Business', 'Nature', 'Technology', 'Food', 'Travel', 'Background', 'Wallpapers', 'PNG'];
                    foreach ($trending as $trend):
                    ?>
                        <a href="<?= BASE_URL ?>/search?q=<?= strtolower($trend) ?>" class="pill"><?= $trend ?></a>
                    <?php endforeach; ?>
                </div>

                <div style="margin-top: 40px;">
                    <a href="#" class="btn btn-primary" style="padding: 15px 30px; font-size: 1.1rem;">Explore Library</a>
                </div>
            </div>

            <div class="hero-visual">
                <div class="hero-visual-grid">
                    <div class="hero-visual-col">
                        <div class="hero-visual-card" style="height: 250px;">
                            <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=600&q=80" alt="Tech" loading="lazy">
                        </div>
                        <div class="hero-visual-card" style="height: 350px;">
                            <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=600&q=80" alt="Tech" loading="lazy">
                        </div>
                        <div class="hero-visual-card" style="height: 250px;">
                            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=600&q=80" alt="Business" loading="lazy">
                        </div>
                    </div>
                    <div class="hero-visual-col">
                        <div class="hero-visual-card" style="height: 350px;">
                            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=600&q=80" alt="Product" loading="lazy">
                        </div>
                        <div class="hero-visual-card" style="height: 250px;">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&q=80" alt="People" loading="lazy">
                        </div>
                        <div class="hero-visual-card" style="height: 350px;">
                            <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=600&q=80" alt="Nature" loading="lazy">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Category Slider Section -->
<section class="section" style="padding-bottom: 0;">
    <div class="container">
        <div class="section-header">
            <h2>Explore Categories</h2>
        </div>
        <div class="category-scroll" style="padding-bottom: 20px;">
            <?php
            // Map icons for demo purposes
            $iconMap = [
                'Business' => 'briefcase', 'Food' => 'coffee', 'Festivals' => 'party-popper',
                'Spiritual' => 'moon', 'Fashion' => 'shirt', 'Technology' => 'monitor',
                'Health' => 'heart', 'Travel' => 'plane', 'Wallpapers' => 'image',
                'Social Media' => 'smartphone', 'Transparent PNG' => 'layers', 'Ecommerce' => 'shopping-cart',
                'Gaming' => 'gamepad-2', 'Luxury' => 'gem', 'Nature' => 'leaf'
            ];
            foreach ($categories as $cat):
                $icon = $iconMap[$cat['name']] ?? 'folder';
            ?>
                <a href="<?= BASE_URL ?>/<?= Security::esc($cat['slug']) ?>/" class="category-card">
                    <i data-lucide="<?= $icon ?>"></i>
                    <span style="font-weight: 600; color: var(--clr-text-main);"><?= Security::esc($cat['name']) ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Featured Categories -->
<section class="section">
    <div class="container">
        <div class="featured-category-grid">
            <a href="#" class="featured-category-card">
                <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=800&q=80" alt="Business">
                <div class="featured-category-content">
                    <h3>Business & Startup</h3>
                    <span style="font-size: 0.9rem; opacity: 0.8;">2,450+ resources</span>
                </div>
            </a>
            <a href="#" class="featured-category-card">
                <img src="https://images.unsplash.com/photo-1550745165-9bc0b252726f?auto=format&fit=crop&w=800&q=80" alt="Tech">
                <div class="featured-category-content">
                    <h3>Technology</h3>
                    <span style="font-size: 0.9rem; opacity: 0.8;">1,820+ resources</span>
                </div>
            </a>
            <a href="#" class="featured-category-card">
                <img src="https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?auto=format&fit=crop&w=800&q=80" alt="Travel">
                <div class="featured-category-content">
                    <h3>Travel & Nature</h3>
                    <span style="font-size: 0.9rem; opacity: 0.8;">3,100+ resources</span>
                </div>
            </a>
            <a href="#" class="featured-category-card">
                <img src="https://images.unsplash.com/photo-1558655146-d09347e92766?auto=format&fit=crop&w=800&q=80" alt="Wallpapers">
                <div class="featured-category-content">
                    <h3>4K Wallpapers</h3>
                    <span style="font-size: 0.9rem; opacity: 0.8;">5,000+ resources</span>
                </div>
            </a>
        </div>
    </div>
</section>

<!-- AdSense Header Placeholder -->
<div class="container" style="margin: 20px auto; text-align: center; background: #eaeaea; padding: 20px; border-radius: 8px;">
    <span class="text-muted">Advertisement Placement</span>
</div>

<!-- Latest Uploads Section -->
<section class="section" style="background: var(--clr-white);">
    <div class="container">
        <div class="section-header">
            <h2>Latest Free Images</h2>
            <a href="#" class="btn btn-outline">View All</a>
        </div>

        <div class="masonry-grid">
            <?php if (!empty($latestImages)): ?>
                <?php foreach ($latestImages as $index => $img): ?>
                    <div class="image-card masonry-item">
                        <?= ImageProcessor::generatePictureTag($img, '', $index < 2) /* Load first 2 eagerly for LCP */ ?>
                        <div class="image-overlay">
                            <div>
                                <span style="display:block; font-weight:600;"><?= Security::esc($img['title']) ?></span>
                                <span style="font-size: 0.8rem; opacity:0.8;">Free License</span>
                            </div>
                            <a href="<?= BASE_URL ?>/image/<?= Security::esc($img['slug']) ?>/" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.9rem;"><i data-lucide="download" style="width:16px; height:16px;"></i></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Mock Data for initial view -->
                <?php
                $mockImages = [
                    'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&q=80',
                    'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&q=80',
                    'https://images.unsplash.com/photo-1498050108023-c5249f4df085?w=600&q=80',
                    'https://images.unsplash.com/photo-1518770660439-4636190af475?w=600&q=80',
                    'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=600&q=80',
                    'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=600&q=80',
                    'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=600&q=80',
                    'https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=600&q=80'
                ];
                foreach($mockImages as $i => $url):
                ?>
                    <div class="image-card masonry-item">
                        <img src="<?= $url ?>" alt="Mock Image" loading="lazy">
                        <div class="image-overlay">
                            <div>
                                <span style="display:block; font-weight:600;">Premium Asset <?= $i+1 ?></span>
                                <span style="font-size: 0.8rem; opacity:0.8;">Free License</span>
                            </div>
                            <a href="#" class="btn btn-primary" style="padding: 8px 16px;"><i data-lucide="download" style="width:16px; height:16px;"></i></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- AdSense In-Content Placeholder -->
<div class="container" style="margin: 20px auto; text-align: center; background: #eaeaea; padding: 20px; border-radius: 8px;">
    <span class="text-muted">Advertisement Placement</span>
</div>

<!-- Popular Wallpapers Section -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <h2>Popular Wallpapers</h2>
            <a href="#" class="btn btn-outline">All Wallpapers</a>
        </div>
        <div style="display: grid; grid-template-columns: 1fr; gap: var(--space-md); @media(min-width:768px){grid-template-columns: 1fr 1fr;}">

            <!-- Mobile Wallpaper -->
            <div class="image-card" style="height: 500px;">
                <img src="https://images.unsplash.com/photo-1550684848-fac1c5b4e853?w=600&q=80" alt="Mobile Wallpaper" style="height: 100%;">
                <div class="image-overlay" style="background: linear-gradient(0deg, rgba(230,57,70,0.8) 0%, rgba(0,0,0,0) 100%);">
                    <div>
                        <span style="display:block; font-weight:600; font-size: 1.2rem;">Mobile Wallpapers</span>
                        <span style="font-size: 0.9rem; opacity:0.9;">Optimized for iPhone & Android</span>
                    </div>
                </div>
            </div>

            <!-- Desktop Wallpaper -->
            <div class="image-card" style="height: 500px;">
                <img src="https://images.unsplash.com/photo-1542831371-29b0f74f9713?w=1200&q=80" alt="Desktop Wallpaper" style="height: 100%;">
                <div class="image-overlay" style="background: linear-gradient(0deg, rgba(26,26,26,0.9) 0%, rgba(0,0,0,0) 100%);">
                    <div>
                        <span style="display:block; font-weight:600; font-size: 1.2rem;">4K Desktop Wallpapers</span>
                        <span style="font-size: 0.9rem; opacity:0.9;">High resolution backgrounds</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Transparent PNG Section -->
<section class="section" style="background: var(--clr-white);">
    <div class="container">
        <div class="section-header">
            <h2>Transparent PNGs</h2>
            <a href="#" class="btn btn-outline">Explore PNGs</a>
        </div>
        <div class="featured-category-grid">
            <?php for($i=1; $i<=4; $i++): ?>
            <div class="image-card checkerboard" style="padding: 20px;">
                <!-- Placeholder for actual transparent PNGs -->
                <img src="https://images.unsplash.com/photo-1584992236310-6edddc08acff?auto=format&fit=crop&w=400&q=80" alt="PNG Mock" style="mix-blend-mode: multiply; filter: contrast(1.2);">
                <div class="image-overlay">
                    <span style="font-weight: 600;">Isolated Object <?= $i ?></span>
                    <button class="btn btn-primary" style="padding: 8px;"><i data-lucide="download" style="width:16px;height:16px;"></i></button>
                </div>
            </div>
            <?php endfor; ?>
        </div>
    </div>
</section>

<!-- Social Media Assets & Blog Section -->
<section class="section" style="background: var(--clr-white);">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr; gap: var(--space-xl); @media(min-width:1024px){grid-template-columns: 1fr 1fr;}">

            <!-- Social Media Assets -->
            <div>
                <h2 style="margin-bottom: var(--space-lg);">Social Media Assets</h2>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-md);">
                    <div class="image-card">
                        <img src="https://images.unsplash.com/photo-1611162617474-5b21e879e113?w=400&q=80" alt="Instagram">
                        <div class="image-overlay" style="justify-content:center;">
                            <span style="font-weight:600;">IG Stories</span>
                        </div>
                    </div>
                    <div class="image-card">
                        <img src="https://images.unsplash.com/photo-1611162616305-c69b3fa7fbe0?w=400&q=80" alt="YouTube">
                        <div class="image-overlay" style="justify-content:center;">
                            <span style="font-weight:600;">Thumbnails</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Blog Previews -->
            <div>
                <h2 style="margin-bottom: var(--space-lg);">Creator Tips</h2>
                <div style="display: flex; flex-direction: column; gap: var(--space-md);">
                    <a href="#" class="blog-card" style="display:flex; height: 120px;">
                        <img src="https://images.unsplash.com/photo-1542744173-8e7e53415bb0?w=200&q=80" alt="Blog" style="width: 150px; object-fit: cover;">
                        <div class="blog-card-content" style="padding: 15px;">
                            <h3 style="font-size: 1.1rem; margin-bottom: 5px;">Top 10 AI Image Trends in 2024</h3>
                            <p style="margin-bottom:0;">Discover what creators are downloading most this year.</p>
                        </div>
                    </a>
                    <a href="#" class="blog-card" style="display:flex; height: 120px;">
                        <img src="https://images.unsplash.com/photo-1555421689-d68471e189f2?w=200&q=80" alt="Blog" style="width: 150px; object-fit: cover;">
                        <div class="blog-card-content" style="padding: 15px;">
                            <h3 style="font-size: 1.1rem; margin-bottom: 5px;">How to use Transparent PNGs</h3>
                            <p style="margin-bottom:0;">A complete guide for web designers and marketers.</p>
                        </div>
                    </a>
                </div>
            </div>

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