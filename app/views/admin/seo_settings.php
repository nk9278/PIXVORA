<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 30px;">
    <h2>Global SEO Settings</h2>
    <button class="btn btn-primary btn-sm"><i data-lucide="save" style="width:14px; margin-right:5px;"></i> Save Settings</button>
</div>

<div class="admin-card" style="margin-bottom:30px;">
    <h3 style="margin-top:0; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom:20px;">Site Metadata Defaults</h3>

    <div style="display:grid; grid-template-columns:1fr; gap:20px; max-width:800px;">
        <div>
            <label style="display:block; margin-bottom:5px; font-weight:500;">Default Meta Title Pattern</label>
            <input type="text" value="{title} - Free AI Images & Backgrounds | Pixvora" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">
            <span style="font-size:0.8rem; color:#888;">Available tags: {title}, {category}, {site_name}</span>
        </div>
        <div>
            <label style="display:block; margin-bottom:5px; font-weight:500;">Default Meta Description Pattern</label>
            <textarea rows="3" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px;">Download {title} for free. High quality AI generated images, backgrounds, and transparent PNGs from Pixvora.</textarea>
        </div>
    </div>
</div>

<div class="admin-card">
    <h3 style="margin-top:0; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom:20px;">Sitemap & Robots</h3>

    <div style="display:grid; grid-template-columns:1fr; gap:20px; max-width:800px;">
        <div style="display:flex; align-items:center; justify-content:space-between; padding:15px; border:1px solid #ddd; border-radius:6px;">
            <div>
                <div style="font-weight:500; margin-bottom:5px;">XML Sitemap</div>
                <div style="font-size:0.85rem; color:#666;">Last generated: Today at 02:45 AM</div>
            </div>
            <button class="btn btn-outline btn-sm">Regenerate Now</button>
        </div>

        <div>
            <label style="display:block; margin-bottom:5px; font-weight:500;">Robots.txt Content</label>
            <textarea rows="5" style="width:100%; padding:10px; border:1px solid #ddd; border-radius:6px; font-family:monospace;">User-agent: *
Allow: /
Disallow: /admin/
Sitemap: https://trypixvora.com/sitemap.xml</textarea>
        </div>
    </div>
</div>