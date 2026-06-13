<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 30px;">
    <h2>Write Blog Post</h2>
    <a href="<?= BASE_URL ?>/admin/manage-blog" class="btn btn-outline btn-sm">Cancel</a>
</div>

<?php if (!empty($error)): ?>
    <div style="background: #ffebee; color: #c62828; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <i data-lucide="alert-circle" style="vertical-align:middle; width:18px;"></i> <?= Security::esc($error) ?>
    </div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div style="background: #e8f5e9; color: #2e7d32; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <i data-lucide="check" style="vertical-align:middle; width:18px;"></i> <?= Security::esc($success) ?>
    </div>
<?php endif; ?>

<form method="POST" action="<?= BASE_URL ?>/admin/edit-blog">
    <input type="hidden" name="csrf_token" value="<?= Security::generateCsrfToken() ?>">

    <div style="display: grid; grid-template-columns: 1fr; gap: 30px; @media(min-width: 1024px){grid-template-columns: 2fr 1fr;}">

        <!-- Left: Content Editor -->
        <div style="display:flex; flex-direction:column; gap:20px;">
            <div class="admin-card">
                <input type="text" name="title" placeholder="Post Title..." style="width:100%; padding:15px; border:none; border-bottom:1px solid #eee; font-size:1.5rem; font-weight:bold; outline:none; margin-bottom:20px;" required>

                <!-- TinyMCE Placeholder Area -->
                <div style="border: 1px solid #ddd; border-radius: 8px; overflow:hidden;">
                    <div style="background:#f5f5f5; padding:10px; border-bottom:1px solid #ddd; display:flex; gap:10px;">
                        <i data-lucide="bold" style="width:16px;"></i> <i data-lucide="italic" style="width:16px;"></i> <i data-lucide="link" style="width:16px;"></i> <i data-lucide="image" style="width:16px;"></i>
                    </div>
                    <textarea name="content" rows="20" placeholder="Write your post here... Use HTML for headings, paragraphs, and embedded images." style="width:100%; padding:15px; border:none; resize:vertical; outline:none; font-family:monospace;"></textarea>
                </div>
            </div>

            <div class="admin-card">
                <h3 style="margin-top:0; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom:15px;">Search Engine Optimization</h3>
                <div style="display:grid; gap:15px;">
                    <div>
                        <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">SEO Slug</label>
                        <input type="text" name="slug" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;" placeholder="leave empty to auto-generate">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">Meta Title</label>
                        <input type="text" name="meta_title" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">Meta Description</label>
                        <textarea name="meta_description" rows="3" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;"></textarea>
                    </div>
                    <div>
                        <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">Focus Keywords</label>
                        <input type="text" name="focus_keywords" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Settings -->
        <div style="display:flex; flex-direction:column; gap:20px;">
            <div class="admin-card">
                <h3 style="margin-top:0; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom:15px;">Publishing</h3>

                <div style="margin-bottom:15px;">
                    <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">Status</label>
                    <select name="status" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
                        <option value="published">Published</option>
                        <option value="draft">Draft</option>
                    </select>
                </div>

                <div style="margin-bottom:15px;">
                    <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">Author</label>
                    <input type="text" name="author_name" value="Pixvora Team" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
                </div>

                <button type="submit" class="btn btn-primary" style="width:100%; padding:12px;"><i data-lucide="send" style="width:16px; margin-right:5px; vertical-align:middle;"></i> Publish Post</button>
            </div>

            <div class="admin-card">
                <h3 style="margin-top:0; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom:15px;">Organization</h3>
                <div style="margin-bottom:15px;">
                    <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">Category</label>
                    <input type="text" name="category" placeholder="e.g. Creator Tips" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">Tags</label>
                    <input type="text" name="tags" placeholder="comma separated" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">Featured Image URL</label>
                    <input type="text" name="featured_image" placeholder="uploads/..." style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">Featured Image ALT</label>
                    <input type="text" name="featured_image_alt" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
                </div>
            </div>

            <div class="admin-card">
                <h3 style="margin-top:0; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom:15px;">Social Media</h3>
                <div style="margin-bottom:15px;">
                    <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">OG Title</label>
                    <input type="text" name="og_title" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
                </div>
                <div style="margin-bottom:15px;">
                    <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">Twitter Title</label>
                    <input type="text" name="twitter_title" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
                </div>
            </div>
        </div>

    </div>
</form>