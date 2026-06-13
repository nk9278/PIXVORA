<div class="container" style="padding: var(--space-xl) 0; min-height: 60vh; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">

    <div style="margin-bottom: 20px; position: relative;">
        <h1 style="font-size: clamp(6rem, 15vw, 10rem); margin: 0; line-height: 1; font-weight: 700; color: var(--clr-border);">404</h1>
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 100%;">
            <h2 style="font-size: clamp(1.5rem, 4vw, 2.5rem); margin: 0; background: var(--clr-white); display: inline-block; padding: 0 10px;">Page Not Found</h2>
        </div>
    </div>

    <p style="color: var(--clr-text-muted); font-size: 1.15rem; max-width: 500px; margin: 0 auto var(--space-lg);">
        The image or page you're looking for might have been moved or deleted. Let's get you back on track.
    </p>

    <!-- Search Fallback -->
    <div class="search-box" style="width: 100%; max-width: 500px; margin-bottom: var(--space-lg);">
        <form action="<?= BASE_URL ?>/search" method="GET" style="position:relative;">
            <i data-lucide="search" style="position:absolute; left:20px; top:50%; transform:translateY(-50%); color:var(--clr-text-muted);"></i>
            <input type="text" name="q" class="search-input" placeholder="Search free images, wallpapers, PNGs..." style="padding-left: 55px;">
        </form>
    </div>

    <div>
        <h3 style="font-size: 1rem; color: var(--clr-text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 15px;">Or explore trending categories</h3>
        <div style="display:flex; flex-wrap:wrap; gap:10px; justify-content:center;">
            <a href="<?= BASE_URL ?>/search/business-office" class="pill">Business Office</a>
            <a href="<?= BASE_URL ?>/search/transparent-png" class="pill">Transparent PNG</a>
            <a href="<?= BASE_URL ?>/search/mobile-wallpaper" class="pill">Mobile Wallpaper</a>
            <a href="<?= BASE_URL ?>/search/luxury" class="pill">Luxury Background</a>
        </div>
    </div>

</div>