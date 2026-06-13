<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 30px;">
    <h2>Upload Single Image (SEO Optimized)</h2>
    <div style="background: #e8f5e9; color: #2e7d32; padding: 10px 20px; border-radius: 50px; font-weight: 600; display:flex; align-items:center; gap:10px;">
        <i data-lucide="check-circle" style="width:18px;"></i>
        SEO Score: <span id="seoScoreDisplay">0/10</span>
    </div>
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

<form method="POST" action="<?= BASE_URL ?>/admin/upload" enctype="multipart/form-data" id="uploadForm">
    <input type="hidden" name="csrf_token" value="<?= Security::generateCsrfToken() ?>">

    <div style="display: grid; grid-template-columns: 1fr; gap: 30px; @media(min-width: 1024px){grid-template-columns: 1fr 1fr;}">

        <!-- Left Column: File & Basic Settings -->
        <div class="admin-card">
            <h3 style="margin-top:0; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom:20px;">Media Details</h3>

            <!-- Drag Drop Area -->
            <div id="dropZone" style="border: 2px dashed #ccc; border-radius: 12px; padding: 40px 20px; text-align: center; margin-bottom: 25px; cursor: pointer; transition: 0.2s; background: #fafafa;">
                <i data-lucide="upload-cloud" style="width: 48px; height: 48px; color: #999; margin-bottom: 10px;"></i>
                <p style="margin:0; font-weight: 500; color:#555;">Drag & Drop image here</p>
                <p style="margin:5px 0 0; font-size: 0.85rem; color:#888;">or click to browse (JPG, PNG, WEBP)</p>
                <input type="file" name="image" id="fileInput" accept="image/jpeg,image/png,image/webp" style="display:none;" required>
            </div>

            <div id="previewArea" style="display:none; margin-bottom: 25px; text-align:center;">
                <img id="imagePreview" style="max-width: 100%; max-height: 250px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                <p id="fileNameDisplay" style="margin: 10px 0 0; font-size: 0.9rem; color:#666;"></p>
            </div>

            <div style="display:flex; gap:15px; margin-bottom: 20px;">
                <div style="flex:1;">
                    <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">Category *</label>
                    <select name="category_id" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;" required>
                        <option value="">Select Category</option>
                        <?php foreach($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= Security::esc($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div style="flex:1;">
                    <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">Subcategory</label>
                    <select name="subcategory_id" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
                        <option value="">None</option>
                    </select>
                </div>
            </div>

            <h3 style="margin-top:30px; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom:20px;">Image Toggles</h3>
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
                <label style="display:flex; align-items:center; gap:8px; font-size:0.9rem; cursor:pointer;"><input type="checkbox" name="is_featured" value="1"> Featured</label>
                <label style="display:flex; align-items:center; gap:8px; font-size:0.9rem; cursor:pointer;"><input type="checkbox" name="show_on_homepage" value="1" checked> Homepage</label>
                <label style="display:flex; align-items:center; gap:8px; font-size:0.9rem; cursor:pointer;"><input type="checkbox" name="is_trending" value="1"> Trending</label>
                <label style="display:flex; align-items:center; gap:8px; font-size:0.9rem; cursor:pointer;"><input type="checkbox" name="is_recommended" value="1"> Recommended</label>
                <label style="display:flex; align-items:center; gap:8px; font-size:0.9rem; cursor:pointer;"><input type="checkbox" name="is_wallpaper" value="1"> Wallpaper</label>
                <label style="display:flex; align-items:center; gap:8px; font-size:0.9rem; cursor:pointer;"><input type="checkbox" name="is_png" value="1"> Transparent PNG</label>
            </div>

            <h3 style="margin-top:30px; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom:20px;">SEO Analysis</h3>
            <div id="seoWarnings" style="font-size: 0.9rem; color: #c62828;">
                <ul style="padding-left: 20px; margin:0;" id="seoWarningList">
                    <li>Title is missing</li>
                    <li>Meta description is missing</li>
                    <li>ALT text is missing</li>
                </ul>
            </div>
        </div>

        <!-- Right Column: SEO Engine -->
        <div class="admin-card" style="display:flex; flex-direction:column; gap: 15px;">
            <h3 style="margin-top:0; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom:5px;">Core SEO</h3>

            <div>
                <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">1. Image Title *</label>
                <input type="text" name="title" id="seoTitle" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;" required>
            </div>

            <div>
                <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">2. SEO Slug <span style="color:#999; font-weight:normal;">(Auto-generated)</span></label>
                <input type="text" name="slug" id="seoSlug" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd; background:#f9f9f9;">
            </div>

            <div>
                <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">3. Meta Title</label>
                <input type="text" name="meta_title" id="seoMetaTitle" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
                <div style="font-size:0.8rem; text-align:right; color:#888;" id="metaTitleLen">0 / 60</div>
            </div>

            <div>
                <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">4. Meta Description</label>
                <textarea name="meta_description" id="seoMetaDesc" rows="3" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd; font-family:inherit;"></textarea>
                <div style="font-size:0.8rem; text-align:right; color:#888;" id="metaDescLen">0 / 160</div>
            </div>

            <div>
                <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">5. ALT Text</label>
                <input type="text" name="alt_text" id="seoAlt" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
                <div>
                    <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">6. Focus Keywords</label>
                    <input type="text" name="focus_keywords" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;" placeholder="comma separated">
                </div>
                <div>
                    <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">7. Tags</label>
                    <input type="text" name="tags" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;" placeholder="comma separated">
                </div>
            </div>

            <h3 style="margin-top:15px; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom:5px;">Advanced Metadata</h3>

            <div>
                <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">8. Caption</label>
                <textarea name="caption" rows="2" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd; font-family:inherit;"></textarea>
            </div>

            <div>
                <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">9. Canonical URL</label>
                <input type="url" name="canonical_url" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
                <div>
                    <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">10. OG Title</label>
                    <input type="text" name="og_title" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
                </div>
                <div>
                    <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">12. Twitter Title</label>
                    <input type="text" name="twitter_title" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
                </div>
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
                <div>
                    <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">11. OG Description</label>
                    <textarea name="og_description" rows="2" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd; font-family:inherit;"></textarea>
                </div>
                <div>
                    <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">13. Twitter Description</label>
                    <textarea name="twitter_description" rows="2" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd; font-family:inherit;"></textarea>
                </div>
            </div>

            <div>
                <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">14. Short SEO Description</label>
                <textarea name="short_seo_description" rows="2" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd; font-family:inherit;"></textarea>
            </div>

            <div style="display:flex; gap:15px;">
                <div style="flex:1;">
                    <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">15. Credit</label>
                    <input type="text" name="image_credit" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
                </div>
                <div style="flex:1;">
                    <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">16. License</label>
                    <input type="text" name="image_license" value="Free for commercial use" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
                </div>
            </div>

            <div style="margin-top:20px; text-align:right;">
                <button type="submit" class="btn btn-primary" style="padding: 15px 30px; font-size: 1rem;"><i data-lucide="save" style="width:18px; vertical-align:middle; margin-right:5px;"></i> Upload & Optimize</button>
            </div>
        </div>
    </div>
</form>

<script>
    // Drag and Drop
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const previewArea = document.getElementById('previewArea');
    const imagePreview = document.getElementById('imagePreview');
    const fileNameDisplay = document.getElementById('fileNameDisplay');

    dropZone.addEventListener('click', () => fileInput.click());

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.style.borderColor = '#E63946';
        dropZone.style.background = '#fff';
    });

    dropZone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        dropZone.style.borderColor = '#ccc';
        dropZone.style.background = '#fafafa';
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.style.borderColor = '#ccc';
        dropZone.style.background = '#fafafa';
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            handleFilePreview();
        }
    });

    fileInput.addEventListener('change', handleFilePreview);

    function handleFilePreview() {
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            fileNameDisplay.textContent = file.name + ' (' + (file.size/1024/1024).toFixed(2) + ' MB)';
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                dropZone.style.display = 'none';
                previewArea.style.display = 'block';
            }
            reader.readAsDataURL(file);

            // Auto fill title if empty
            const titleInput = document.getElementById('seoTitle');
            if(titleInput.value === '') {
                let name = file.name.replace(/\.[^/.]+$/, "");
                name = name.replace(/[-_]/g, ' ').replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
                titleInput.value = name;
                calculateSEO();
            }
        }
    }

    // Live SEO Score Calculation
    const fields = {
        title: document.getElementById('seoTitle'),
        slug: document.getElementById('seoSlug'),
        metaTitle: document.getElementById('seoMetaTitle'),
        metaDesc: document.getElementById('seoMetaDesc'),
        alt: document.getElementById('seoAlt')
    };

    function generateSlug(text) {
        return text.toString().toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
    }

    function calculateSEO() {
        let score = 0;
        let warnings = [];

        // Title
        if (fields.title.value.length > 0) {
            score += 2;
            if (fields.slug.value === '') fields.slug.value = generateSlug(fields.title.value);
            if (fields.metaTitle.value === '') fields.metaTitle.value = fields.title.value + ' - Free Download';
            if (fields.alt.value === '') fields.alt.value = fields.title.value;
        } else {
            warnings.push("Image Title is missing.");
        }

        // Meta Title (optimal length 30-60)
        let mtLen = fields.metaTitle.value.length;
        document.getElementById('metaTitleLen').textContent = mtLen + ' / 60';
        if (mtLen > 0) {
            score += 2;
            if (mtLen > 60) warnings.push("Meta Title is too long (over 60 chars).");
            if (mtLen < 30) warnings.push("Meta Title is short (under 30 chars).");
            if (mtLen >= 30 && mtLen <= 60) score += 0.5;
        } else {
            warnings.push("Meta Title is missing.");
        }

        // Meta Desc (optimal length 120-160)
        let mdLen = fields.metaDesc.value.length;
        document.getElementById('metaDescLen').textContent = mdLen + ' / 160';
        if (mdLen > 0) {
            score += 2;
            if (mdLen > 160) warnings.push("Meta Description is too long (over 160 chars).");
            if (mdLen < 120) warnings.push("Meta Description is short (under 120 chars).");
            if (mdLen >= 120 && mdLen <= 160) score += 1.5;
        } else {
            warnings.push("Meta Description is missing.");
        }

        // Alt text
        if (fields.alt.value.length > 0) score += 2;
        else warnings.push("ALT text is missing.");

        // Normalize score to 10
        let displayScore = Math.min(10, score).toFixed(1);
        document.getElementById('seoScoreDisplay').textContent = displayScore + '/10';

        let ul = document.getElementById('seoWarningList');
        ul.innerHTML = '';
        if (warnings.length === 0) {
            ul.innerHTML = '<li style="color:#2e7d32;">SEO looks perfect! (9.5+/10 target reached)</li>';
        } else {
            warnings.forEach(w => {
                let li = document.createElement('li');
                li.textContent = w;
                ul.appendChild(li);
            });
        }
    }

    Object.values(fields).forEach(el => {
        el.addEventListener('input', calculateSEO);
    });

    calculateSEO(); // init
</script>