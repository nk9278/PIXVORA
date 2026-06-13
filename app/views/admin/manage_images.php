<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 30px;">
    <h2>Manage Images</h2>
    <a href="<?= BASE_URL ?>/admin/upload" class="btn btn-primary btn-sm"><i data-lucide="plus" style="width:14px; margin-right:5px;"></i> Upload</a>
</div>

<div class="admin-card" style="margin-bottom: 20px; padding: 15px 25px;">
    <form style="display:flex; gap:15px; align-items:center; flex-wrap:wrap;">
        <input type="text" placeholder="Search images..." style="padding:10px; border:1px solid #ddd; border-radius:6px; flex:1; min-width:200px;">
        <select style="padding:10px; border:1px solid #ddd; border-radius:6px; min-width:150px;">
            <option value="">All Categories</option>
        </select>
        <select style="padding:10px; border:1px solid #ddd; border-radius:6px; min-width:150px;">
            <option value="newest">Newest First</option>
            <option value="downloads">Most Downloads</option>
        </select>
        <button class="btn btn-outline" style="padding:10px 20px;">Filter</button>
    </form>
</div>

<div class="admin-card">
    <div style="display:flex; justify-content:space-between; margin-bottom: 15px; align-items:center;">
        <span style="font-size:0.9rem; color:#666;">Showing <?= count($images) ?> images</span>
        <select style="padding:5px 10px; border:1px solid #ddd; border-radius:4px; font-size:0.85rem;">
            <option>Bulk Actions</option>
            <option>Delete Selected</option>
        </select>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width:40px;"><input type="checkbox"></th>
                    <th>Image</th>
                    <th>Title & SEO</th>
                    <th>Category</th>
                    <th>Stats</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($images as $img): ?>
                <tr>
                    <td><input type="checkbox"></td>
                    <td><img src="<?= BASE_URL ?>/<?= Security::esc($img['filepath_thumbnail']) ?>" style="width:60px; height:60px; object-fit:cover; border-radius:6px;"></td>
                    <td>
                        <div style="font-weight:600; color:#111; margin-bottom:5px;"><?= Security::esc($img['title']) ?></div>
                        <div style="display:flex; gap:10px; font-size:0.8rem;">
                            <span style="color:#2e7d32; background:#e8f5e9; padding:2px 6px; border-radius:4px;">SEO: 9.8/10</span>
                            <span style="color:#666;">Slug: <?= Security::esc($img['slug']) ?></span>
                        </div>
                    </td>
                    <td style="color:#555;"><?= $img['category_id'] ? 'Cat ID: '.$img['category_id'] : 'None' ?></td>
                    <td>
                        <div style="font-size:0.85rem; color:#555;"><i data-lucide="download" style="width:14px; vertical-align:middle;"></i> <?= number_format($img['downloads']) ?></div>
                        <div style="font-size:0.8rem; color:#999; margin-top:3px;"><?= date('M j, Y', strtotime($img['created_at'])) ?></div>
                    </td>
                    <td>
                        <button style="background:none; border:none; color:#555; cursor:pointer; margin-right:10px;" title="Edit"><i data-lucide="edit" style="width:18px;"></i></button>
                        <button style="background:none; border:none; color:#E63946; cursor:pointer;" title="Delete"><i data-lucide="trash-2" style="width:18px;"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($images)): ?>
                    <tr><td colspan="6" style="text-align:center; padding:30px; color:#999;">No images found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>