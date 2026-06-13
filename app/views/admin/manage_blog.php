<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 30px;">
    <h2>Manage Blog</h2>
    <a href="<?= BASE_URL ?>/admin/edit-blog" class="btn btn-primary btn-sm"><i data-lucide="plus" style="width:14px; margin-right:5px;"></i> Write Post</a>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Title & SEO</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Views</th>
                    <th>Published</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($posts)): ?>
                    <?php foreach($posts as $post): ?>
                    <tr>
                        <td>
                            <div style="font-weight:600; color:#111; margin-bottom:5px;"><?= Security::esc($post['title']) ?></div>
                            <div style="color:#666; font-size:0.8rem;">Slug: <?= Security::esc($post['slug']) ?></div>
                        </td>
                        <td style="color:#555;"><?= Security::esc($post['category']) ?></td>
                        <td>
                            <?php if($post['status'] == 'published'): ?>
                                <span style="color:#2e7d32; background:#e8f5e9; padding:4px 8px; border-radius:4px; font-size:0.85rem;">Published</span>
                            <?php else: ?>
                                <span style="color:#f57c00; background:#fff3e0; padding:4px 8px; border-radius:4px; font-size:0.85rem;">Draft</span>
                            <?php endif; ?>
                        </td>
                        <td><?= number_format($post['views']) ?></td>
                        <td style="font-size:0.9rem; color:#666;"><?= date('M j, Y', strtotime($post['created_at'])) ?></td>
                        <td>
                            <a href="<?= BASE_URL ?>/admin/edit-blog?id=<?= $post['id'] ?>" style="color:#555; margin-right:10px;"><i data-lucide="edit" style="width:18px;"></i></a>
                            <button style="background:none; border:none; color:#E63946; cursor:pointer;"><i data-lucide="trash-2" style="width:18px;"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align:center; padding:30px; color:#999;">No blog posts found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>