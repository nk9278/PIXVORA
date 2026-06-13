<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($meta_title ?? 'Pixvora | Premium AI Assets & Free Stock Images') ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_description ?? '') ?>">
    <?php if(!empty($canonical_url)): ?>
    <link rel="canonical" href="<?= htmlspecialchars($canonical_url) ?>">
    <?php endif; ?>

    <!-- Open Graph -->
    <meta property="og:title" content="<?= htmlspecialchars($og_title ?? $meta_title ?? 'Pixvora') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($og_description ?? $meta_description ?? '') ?>">
    <meta property="og:type" content="<?= isset($is_image_page) ? 'article' : 'website' ?>">
    <meta property="og:url" content="<?= htmlspecialchars($canonical_url ?? BASE_URL) ?>">
    <?php if(!empty($og_image)): ?>
    <meta property="og:image" content="<?= htmlspecialchars($og_image) ?>">
    <?php endif; ?>

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= htmlspecialchars($twitter_title ?? $meta_title ?? 'Pixvora') ?>">
    <meta name="twitter:description" content="<?= htmlspecialchars($twitter_description ?? $meta_description ?? '') ?>">
    <?php if(!empty($og_image)): ?>
    <meta name="twitter:image" content="<?= htmlspecialchars($og_image) ?>">
    <?php endif; ?>

    <!-- Structured Data -->
    <?php if(!empty($schema_markup)): ?>
    <script type="application/ld+json">
    <?= $schema_markup ?>
    </script>
    <?php endif; ?>

    <!-- Preconnect & Fonts (Preload critical font) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"></noscript>

    <!-- CSS -->
    <link rel="preload" href="<?= BASE_URL ?>/assets/css/style.css" as="style">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">

    <!-- Icons (Lucide) -->
    <script defer src="https://unpkg.com/lucide@latest"></script>
</head>
<body>

    <header class="header">
        <div class="container header-inner">
            <a href="<?= BASE_URL ?>/" class="logo">
                <img src="<?= BASE_URL ?>/assets/img/logo.png" alt="Pixvora Logo">
            </a>

            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <i data-lucide="menu"></i>
            </button>

            <nav class="nav-links" id="navLinks">
                <a href="<?= BASE_URL ?>/">Home</a>
                <a href="<?= BASE_URL ?>/images/">Images</a>
                <a href="<?= BASE_URL ?>/wallpapers/">Wallpapers</a>
                <a href="<?= BASE_URL ?>/transparent-png/">PNG</a>
                <a href="<?= BASE_URL ?>/categories/">Categories</a>
                <a href="<?= BASE_URL ?>/blog/">Blog</a>
                <a href="<?= BASE_URL ?>/about/">About</a>
                <a href="<?= BASE_URL ?>/contact/">Contact</a>
            </nav>

            <div class="nav-actions">
                <div style="position:relative;">
                    <form action="<?= BASE_URL ?>/search" method="GET" style="position:relative;" id="globalSearchForm">
                        <i data-lucide="search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:var(--clr-text-muted); width:18px;"></i>
                        <input type="text" name="q" id="globalSearchInput" placeholder="Search..." autocomplete="off" style="padding:10px 15px 10px 40px; border-radius:var(--radius-pill); border:1px solid var(--clr-border); background:var(--clr-soft-white); font-family:var(--font-primary); font-size:0.95rem; width:200px; outline:none; transition:width 0.3s;">
                    </form>
                    <div class="live-suggestions" id="liveSuggestBox"></div>
                </div>

                <button style="background:none;border:none;cursor:pointer;"><i data-lucide="moon"></i></button>
                <a href="#" class="btn btn-primary" style="display:none; @media (min-width: 768px){display:inline-block;}">Join Free</a>
            </div>
        </div>
    </header>

    <main>
        <?php
        // This acts as the yield/content area
        if (isset($content_view)) {
            require_once $content_view;
        } else {
            // Defaulting to home view if not specified
            require_once APP_DIR . '/views/home/index.php';
        }
        ?>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <img src="<?= BASE_URL ?>/assets/img/logo.png" alt="Pixvora" style="height: 32px; filter: brightness(0) invert(1); margin-bottom: 20px;">
                    <p class="text-muted" style="margin-bottom: 20px;">Premium AI assets, free stock images, and transparent PNGs for modern creators.</p>
                    <div style="display:flex; gap:15px; color:var(--clr-text-muted);">
                        <a href="#"><i data-lucide="twitter"></i></a>
                        <a href="#"><i data-lucide="instagram"></i></a>
                        <a href="#"><i data-lucide="youtube"></i></a>
                        <a href="#"><i data-lucide="linkedin"></i></a>
                    </div>
                </div>
                <div>
                    <h4>Popular Searches</h4>
                    <ul>
                        <li><a href="<?= BASE_URL ?>/collection/free-ai-wallpapers/">Free AI Wallpapers</a></li>
                        <li><a href="<?= BASE_URL ?>/collection/free-business-backgrounds/">Free Business Backgrounds</a></li>
                        <li><a href="<?= BASE_URL ?>/collection/free-png-images/">Free PNG Images</a></li>
                        <li><a href="<?= BASE_URL ?>/collection/instagram-backgrounds/">Instagram Backgrounds</a></li>
                        <li><a href="<?= BASE_URL ?>/collection/youtube-thumbnail-backgrounds/">YouTube Thumbnails</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Explore Tags</h4>
                    <ul>
                        <li><a href="<?= BASE_URL ?>/tag/startup-office/">Startup Office</a></li>
                        <li><a href="<?= BASE_URL ?>/tag/neon-city/">Neon City 4K</a></li>
                        <li><a href="<?= BASE_URL ?>/tag/minimal-workspace/">Minimal Workspace</a></li>
                        <li><a href="<?= BASE_URL ?>/tag/luxury-gold/">Luxury Gold</a></li>
                        <li><a href="<?= BASE_URL ?>/tag/cyberpunk/">Cyberpunk</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Legal & Info</h4>
                    <ul>
                        <li><a href="<?= BASE_URL ?>/license/">License</a></li>
                        <li><a href="<?= BASE_URL ?>/commercial-use/">Commercial Use</a></li>
                        <li><a href="<?= BASE_URL ?>/terms/">Terms of Service</a></li>
                        <li><a href="<?= BASE_URL ?>/privacy-policy/">Privacy Policy</a></li>
                        <li><a href="<?= BASE_URL ?>/dmca/">DMCA</a></li>
                        <li><a href="<?= BASE_URL ?>/contact/">Contact Us</a></li>
                    </ul>
                </div>
            </div>

            <div style="margin-top: 50px; padding-top: 30px; border-top: 1px solid #333; display:flex; flex-direction:column; align-items:center; gap:15px; @media(min-width:768px){flex-direction:row; justify-content:space-between;}">
                <p class="text-muted" style="margin:0;">&copy; <?= date('Y') ?> Pixvora. All rights reserved.</p>
                <p class="text-muted" style="margin:0; font-size:0.85rem;">Engineered for fast, reliable, copyright-free asset delivery.</p>
            </div>
        </div>
    </footer>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Mobile menu toggle
        const menuBtn = document.getElementById('mobileMenuBtn');
        const navLinks = document.getElementById('navLinks');

        menuBtn.addEventListener('click', () => {
            navLinks.classList.toggle('active');
        });

        // Live Search Logic
        const searchInput = document.getElementById('globalSearchInput');
        const suggestBox = document.getElementById('liveSuggestBox');
        let suggestTimeout = null;

        searchInput.addEventListener('input', (e) => {
            clearTimeout(suggestTimeout);
            const query = e.target.value.trim();

            if (query.length < 2) {
                suggestBox.classList.remove('active');
                return;
            }

            suggestTimeout = setTimeout(async () => {
                try {
                    const response = await fetch(`<?= BASE_URL ?>/api/search-suggest?q=${encodeURIComponent(query)}`);
                    const data = await response.json();

                    if (data.length > 0) {
                        let html = '';
                        data.forEach(item => {
                            html += `
                                <a href="${item.url}" class="suggestion-item">
                                    <img src="${item.thumb}" alt="${item.title}">
                                    <span style="font-weight:500;">${item.title}</span>
                                </a>
                            `;
                        });
                        suggestBox.innerHTML = html;
                        suggestBox.classList.add('active');
                    } else {
                        suggestBox.classList.remove('active');
                    }
                } catch (err) {
                    console.error('Search suggest error', err);
                }
            }, 300);
        });

        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target) && !suggestBox.contains(e.target)) {
                suggestBox.classList.remove('active');
            }
        });
    </script>
</body>
</html>