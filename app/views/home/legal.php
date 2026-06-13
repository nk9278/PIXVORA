<div class="container" style="padding: var(--space-xl) 0; max-width: 800px;">

    <div style="text-align: center; margin-bottom: var(--space-xl);">
        <h1 style="font-size: clamp(2.5rem, 5vw, 3.5rem); margin-bottom: 20px;"><?= Security::esc($pageTitle) ?></h1>
        <p style="color: var(--clr-text-muted); font-size: 1.15rem;">
            Last updated: <?= date('F j, Y', strtotime('-2 days')) ?>
        </p>
    </div>

    <div class="glass legal-content" style="padding: 40px; border-radius: var(--radius-md); font-size: 1.05rem; line-height: 1.8; color: #444;">

        <?php if ($pageTitle === 'License' || $pageTitle === 'Commercial Use'): ?>
            <h2>Pixvora License</h2>
            <p>All images, backgrounds, and assets available on Pixvora are completely free to use for both commercial and non-commercial purposes. You do not need to ask for permission or provide credit to the creator or Pixvora, although it is appreciated when possible.</p>
            <h3>What is permitted:</h3>
            <ul>
                <li>All assets can be downloaded and used for free.</li>
                <li>Commercial and non-commercial purposes.</li>
                <li>No permission needed (though attribution is appreciated!).</li>
            </ul>
            <h3>What is not permitted:</h3>
            <ul>
                <li>Images cannot be sold without significant modification.</li>
                <li>Compiling images from Pixvora to replicate a similar or competing service.</li>
            </ul>

        <?php elseif ($pageTitle === 'Contact' || $pageTitle === 'About Us'): ?>
            <h2><?= Security::esc($pageTitle) ?></h2>
            <p>Pixvora is a premium platform dedicated to providing creators, designers, and marketers with ultra high-quality, completely free AI-generated assets, transparent PNGs, and wallpapers.</p>
            <p>If you have any questions, business inquiries, or require support, please contact us at:</p>
            <p style="font-weight: 600; font-size: 1.2rem;">hello@trypixvora.com</p>

        <?php else: ?>
            <!-- Generic fallback for Privacy/Terms/DMCA -->
            <h2>Overview</h2>
            <p>Welcome to Pixvora. By accessing or using our website, you agree to comply with and be bound by these terms. Our platform provides high-quality digital assets free of charge for creators.</p>

            <h3>Data Collection and Privacy</h3>
            <p>We believe in minimal data collection. We do not require users to create accounts to download images. Any analytical data collected is used strictly to improve platform performance, search relevance, and AdSense optimization in accordance with standard web practices.</p>

            <h3>DMCA and Copyright</h3>
            <p>If you believe any content on Pixvora infringes upon your copyright, please contact us immediately. We operate under a strict take-down policy and will remove offending assets upon verification of ownership.</p>
        <?php endif; ?>

    </div>
</div>

<style>
.legal-content h2 { margin-top: 30px; margin-bottom: 15px; font-size: 1.8rem; color: var(--clr-black); }
.legal-content h3 { margin-top: 25px; margin-bottom: 10px; font-size: 1.3rem; color: var(--clr-black); }
.legal-content ul { margin-bottom: 20px; padding-left: 20px; }
.legal-content li { margin-bottom: 8px; }
</style>