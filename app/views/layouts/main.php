<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($meta_title ?? 'Pixvora | Premium AI Assets & Free Stock Images') ?></title>
    <meta name="description" content="<?= htmlspecialchars($meta_description ?? '') ?>">

    <!-- Open Graph -->
    <meta property="og:title" content="<?= htmlspecialchars($og_title ?? $meta_title ?? 'Pixvora') ?>">
    <meta property="og:description" content="<?= htmlspecialchars($og_description ?? $meta_description ?? '') ?>">
    <meta property="og:type" content="website">

    <!-- Preconnect & Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">

    <!-- Icons (Lucide) -->
    <script src="https://unpkg.com/lucide@latest"></script>
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
                <button style="background:none;border:none;cursor:pointer;"><i data-lucide="search"></i></button>
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
                    <p class="text-muted">Premium AI assets, free stock images, and transparent PNGs for modern creators.</p>
                </div>
                <div>
                    <h4>Discover</h4>
                    <ul>
                        <li><a href="<?= BASE_URL ?>/free-ai-images/">AI Images</a></li>
                        <li><a href="<?= BASE_URL ?>/transparent-png/">Transparent PNG</a></li>
                        <li><a href="<?= BASE_URL ?>/wallpapers/">Wallpapers</a></li>
                        <li><a href="<?= BASE_URL ?>/social-media/">Social Media Assets</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Categories</h4>
                    <ul>
                        <li><a href="<?= BASE_URL ?>/business/">Business</a></li>
                        <li><a href="<?= BASE_URL ?>/technology/">Technology</a></li>
                        <li><a href="<?= BASE_URL ?>/nature/">Nature</a></li>
                        <li><a href="<?= BASE_URL ?>/gaming/">Gaming</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Legal</h4>
                    <ul>
                        <li><a href="<?= BASE_URL ?>/license/">License</a></li>
                        <li><a href="<?= BASE_URL ?>/terms/">Terms of Service</a></li>
                        <li><a href="<?= BASE_URL ?>/privacy-policy/">Privacy Policy</a></li>
                        <li><a href="<?= BASE_URL ?>/dmca/">DMCA</a></li>
                    </ul>
                </div>
            </div>
            <div style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 1px solid #333;">
                <p class="text-muted">&copy; <?= date('Y') ?> Pixvora. All rights reserved.</p>
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
    </script>
</body>
</html>