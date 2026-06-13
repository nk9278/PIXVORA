<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 30px;">
    <h2>Dashboard Overview</h2>
    <a href="<?= BASE_URL ?>/admin/upload" class="btn btn-primary"><i data-lucide="plus" style="width:16px; height:16px; vertical-align:middle; margin-right:5px;"></i> New Upload</a>
</div>

<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon"><i data-lucide="image"></i></div>
        <div class="stat-info">
            <h4>Total Images</h4>
            <h2><?= number_format($stats['total_images']) ?></h2>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i data-lucide="download"></i></div>
        <div class="stat-info">
            <h4>Total Downloads</h4>
            <h2><?= number_format($stats['total_downloads']) ?></h2>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i data-lucide="folder"></i></div>
        <div class="stat-info">
            <h4>Categories</h4>
            <h2><?= number_format($stats['total_categories']) ?></h2>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i data-lucide="hard-drive"></i></div>
        <div class="stat-info">
            <h4>Storage Usage</h4>
            <h2>1.2 GB</h2> <!-- Placeholder -->
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr; gap: 30px; @media(min-width: 1024px){grid-template-columns: 2fr 1fr;}">

    <!-- Latest Uploads -->
    <div class="admin-card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
            <h3 style="margin:0;">Latest Uploads</h3>
            <a href="<?= BASE_URL ?>/admin/manage-images" style="font-size: 0.9rem; color: #E63946;">View All</a>
        </div>

        <div class="table-responsive">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Downloads</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($stats['latest_images'])): ?>
                        <?php foreach($stats['latest_images'] as $img): ?>
                        <tr>
                            <td><img src="<?= BASE_URL ?>/<?= Security::esc($img['filepath_thumbnail']) ?>" style="width:50px; height:50px; object-fit:cover; border-radius:6px;"></td>
                            <td style="font-weight:500;"><?= Security::esc($img['title']) ?></td>
                            <td style="color:#666; font-size:0.9rem;"><?= date('M j, Y', strtotime($img['created_at'])) ?></td>
                            <td><?= number_format($img['downloads']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" style="text-align:center; color:#999;">No images uploaded yet.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Most Downloaded / Activity -->
    <div style="display: flex; flex-direction: column; gap: 30px;">
        <div class="admin-card">
            <h3 style="margin:0 0 20px 0;">Most Downloaded</h3>
            <div style="display: flex; flex-direction: column; gap: 15px;">
                <?php if (!empty($stats['top_images'])): ?>
                    <?php foreach($stats['top_images'] as $img): ?>
                        <div style="display:flex; align-items:center; gap: 15px;">
                            <img src="<?= BASE_URL ?>/<?= Security::esc($img['filepath_thumbnail']) ?>" style="width:40px; height:40px; border-radius:6px; object-fit:cover;">
                            <div style="flex:1;">
                                <div style="font-weight:500; font-size:0.9rem;"><?= Security::esc($img['title']) ?></div>
                                <div style="color:#666; font-size:0.8rem;"><?= number_format($img['downloads']) ?> downloads</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span style="color:#999; font-size:0.9rem;">No data available.</span>
                <?php endif; ?>
            </div>
        </div>

        <div class="admin-card">
            <h3 style="margin:0 0 20px 0;">Recent Activity</h3>
            <ul style="list-style:none; padding:0; margin:0; font-size: 0.9rem; color:#555;">
                <li style="margin-bottom:10px; padding-bottom:10px; border-bottom:1px solid #eee;">Admin logged in from 192.168.1.1</li>
                <li style="margin-bottom:10px; padding-bottom:10px; border-bottom:1px solid #eee;">Bulk upload completed (12 images)</li>
                <li>System backup created</li>
            </ul>
        </div>
    </div>

</div>