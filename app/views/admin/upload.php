<h2>Upload New Image (SEO System)</h2>

<?php if (!empty($error)): ?>
    <div class="alert alert-error"><?= Security::esc($error) ?></div>
<?php endif; ?>

<?php if (!empty($success)): ?>
    <div class="alert alert-success"><?= Security::esc($success) ?></div>
<?php endif; ?>

<div class="admin-card" style="margin-top: 20px;">
    <form method="POST" action="<?= BASE_URL ?>/admin/upload" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= Security::generateCsrfToken() ?>">

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            <!-- Left Column: File & Core Details -->
            <div>
                <h3 style="margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">File Details</h3>

                <div class="form-group">
                    <label class="form-label">Select Image (JPG, PNG, WebP) *</label>
                    <input type="file" name="image" class="form-control" accept="image/jpeg,image/png,image/webp" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Category *</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= Security::esc($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Subcategory (Optional)</label>
                    <select name="subcategory_id" class="form-control">
                        <option value="">None</option>
                        <!-- Assuming flat array for now, real app might structure this -->
                    </select>
                </div>

                <h3 style="margin-bottom: 20px; margin-top: 40px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Basic SEO (1-6)</h3>

                <div class="form-group">
                    <label class="form-label">1. Image Title *</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">2. SEO Slug (Auto-generated if empty)</label>
                    <input type="text" name="slug" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">3. Meta Title</label>
                    <input type="text" name="meta_title" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">4. Meta Description</label>
                    <textarea name="meta_description" class="form-control" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">5. ALT Text</label>
                    <input type="text" name="alt_text" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">6. Focus Keywords (comma separated)</label>
                    <input type="text" name="focus_keywords" class="form-control">
                </div>
            </div>

            <!-- Right Column: Advanced SEO -->
            <div>
                <h3 style="margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px;">Advanced SEO (7-14)</h3>

                <div class="form-group">
                    <label class="form-label">7. Image Tags (comma separated)</label>
                    <input type="text" name="tags" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">8. Caption</label>
                    <textarea name="caption" class="form-control" rows="2"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">9. Canonical URL</label>
                    <input type="url" name="canonical_url" class="form-control" placeholder="https://trypixvora.com/...">
                </div>

                <div class="form-group">
                    <label class="form-label">10. Open Graph Title</label>
                    <input type="text" name="og_title" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">11. Open Graph Description</label>
                    <textarea name="og_description" class="form-control" rows="2"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">12. Twitter Title</label>
                    <input type="text" name="twitter_title" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">13. Twitter Description</label>
                    <textarea name="twitter_description" class="form-control" rows="2"></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">14. Short SEO Description (Contextual)</label>
                    <textarea name="short_seo_description" class="form-control" rows="3"></textarea>
                </div>
            </div>
        </div>

        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee; text-align: right;">
            <button type="submit" class="btn btn-primary" style="padding: 15px 40px; font-size: 1.1rem;">Secure Upload & Optimize</button>
        </div>
    </form>
</div>