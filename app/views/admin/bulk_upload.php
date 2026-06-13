<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 30px;">
    <h2>Bulk Image Upload</h2>
    <a href="<?= BASE_URL ?>/admin/upload" class="btn btn-outline btn-sm">Single Upload</a>
</div>

<div class="admin-card" style="margin-bottom: 30px;">
    <h3 style="margin-top:0; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-bottom:20px;">Bulk Settings (Applied to all)</h3>
    <div style="display: grid; grid-template-columns: 1fr; gap: 20px; @media(min-width: 768px){grid-template-columns: repeat(4, 1fr);}">
        <div>
            <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">Target Category</label>
            <select id="bulkCategory" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
                <option value="">None</option>
                <?php foreach($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>"><?= Security::esc($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">Append Tags</label>
            <input type="text" id="bulkTags" placeholder="e.g. 4k, wallpaper" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
        </div>
        <div>
            <label style="display:block; font-size:0.9rem; font-weight:500; margin-bottom:5px;">Auto SEO Generation</label>
            <select id="bulkSeoMode" style="width:100%; padding:10px; border-radius:6px; border:1px solid #ddd;">
                <option value="1">Generate from Filenames</option>
                <option value="0">Leave Empty</option>
            </select>
        </div>
        <div style="display:flex; align-items:flex-end;">
            <button id="applyBulkSettings" class="btn btn-outline" style="width:100%; padding:10px;">Apply to Queue</button>
        </div>
    </div>
</div>

<div class="admin-card">
    <div id="bulkDropZone" style="border: 2px dashed #ccc; border-radius: 12px; padding: 50px 20px; text-align: center; margin-bottom: 25px; cursor: pointer; transition: 0.2s; background: #fafafa;">
        <i data-lucide="copy-plus" style="width: 48px; height: 48px; color: #999; margin-bottom: 10px;"></i>
        <p style="margin:0; font-weight: 500; color:#555; font-size: 1.1rem;">Drop multiple images here</p>
        <p style="margin:5px 0 0; font-size: 0.9rem; color:#888;">Select up to 50 files at once</p>
        <input type="file" id="bulkFileInput" accept="image/jpeg,image/png,image/webp" multiple style="display:none;">
    </div>

    <!-- Upload Queue UI -->
    <div id="uploadQueue" style="display:none; margin-top:30px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:15px; border-bottom: 1px solid #eee; padding-bottom:10px;">
            <h3 style="margin:0;">Upload Queue (<span id="queueCount">0</span>)</h3>
            <button id="startBulkUpload" class="btn btn-primary btn-sm"><i data-lucide="play" style="width:14px; margin-right:5px; vertical-align:middle;"></i> Start Upload</button>
        </div>

        <div id="queueList" style="display:flex; flex-direction:column; gap:10px;">
            <!-- Queue items injected here via JS -->
        </div>
    </div>
</div>

<script>
    const bulkDropZone = document.getElementById('bulkDropZone');
    const bulkFileInput = document.getElementById('bulkFileInput');
    const uploadQueue = document.getElementById('uploadQueue');
    const queueList = document.getElementById('queueList');
    const queueCount = document.getElementById('queueCount');
    const applyBulkSettings = document.getElementById('applyBulkSettings');

    let filesQueue = [];

    bulkDropZone.addEventListener('click', () => bulkFileInput.click());

    bulkDropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        bulkDropZone.style.borderColor = '#E63946';
        bulkDropZone.style.background = '#fff';
    });

    bulkDropZone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        bulkDropZone.style.borderColor = '#ccc';
        bulkDropZone.style.background = '#fafafa';
    });

    bulkDropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        bulkDropZone.style.borderColor = '#ccc';
        bulkDropZone.style.background = '#fafafa';
        handleFiles(e.dataTransfer.files);
    });

    bulkFileInput.addEventListener('change', () => handleFiles(bulkFileInput.files));

    function generateCleanTitle(filename) {
        let name = filename.replace(/\.[^/.]+$/, "");
        name = name.replace(/[-_]/g, ' ');
        return name.replace(/\w\S*/g, txt => txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase());
    }

    function handleFiles(files) {
        for (let i = 0; i < files.length; i++) {
            if (files[i].type.startsWith('image/')) {
                filesQueue.push({
                    file: files[i],
                    title: document.getElementById('bulkSeoMode').value === "1" ? generateCleanTitle(files[i].name) : "",
                    category: document.getElementById('bulkCategory').value,
                    tags: document.getElementById('bulkTags').value,
                    status: 'pending' // pending, uploading, success, error
                });
            }
        }
        renderQueue();
    }

    applyBulkSettings.addEventListener('click', () => {
        const cat = document.getElementById('bulkCategory').value;
        const tags = document.getElementById('bulkTags').value;
        filesQueue.forEach(item => {
            if (cat) item.category = cat;
            if (tags) {
                item.tags = item.tags ? item.tags + ', ' + tags : tags;
            }
        });
        renderQueue();
        alert("Settings applied to queue.");
    });

    function renderQueue() {
        if (filesQueue.length === 0) {
            uploadQueue.style.display = 'none';
            return;
        }
        uploadQueue.style.display = 'block';
        queueCount.textContent = filesQueue.length;
        queueList.innerHTML = '';

        filesQueue.forEach((item, index) => {
            const sizeMB = (item.file.size / 1024 / 1024).toFixed(2);

            let statusBadge = '<span style="background:#eee; color:#666; padding:3px 8px; border-radius:4px; font-size:0.8rem;">Pending</span>';
            if(item.status === 'success') statusBadge = '<span style="background:#e8f5e9; color:#2e7d32; padding:3px 8px; border-radius:4px; font-size:0.8rem;">Success</span>';

            const div = document.createElement('div');
            div.style.cssText = 'display:flex; align-items:center; justify-content:space-between; padding:15px; border:1px solid #eaeaea; border-radius:8px; background:#fff;';
            div.innerHTML = `
                <div style="display:flex; align-items:center; gap:15px; flex:1;">
                    <div style="width:50px; height:50px; background:#f5f5f5; border-radius:6px; display:flex; align-items:center; justify-content:center; overflow:hidden;">
                        <img src="${URL.createObjectURL(item.file)}" style="width:100%; height:100%; object-fit:cover;">
                    </div>
                    <div style="flex:1;">
                        <div style="font-weight:600; font-size:0.95rem;">${item.title || item.file.name}</div>
                        <div style="font-size:0.8rem; color:#888;">${sizeMB} MB &nbsp;|&nbsp; Category ID: ${item.category || 'None'}</div>
                    </div>
                </div>
                <div>${statusBadge}</div>
                <button onclick="removeItem(${index})" style="background:none; border:none; color:#E63946; cursor:pointer; padding:5px 10px; margin-left:15px;"><i data-lucide="trash-2" style="width:18px;"></i></button>
            `;
            queueList.appendChild(div);
        });
        lucide.createIcons();
    }

    window.removeItem = function(index) {
        filesQueue.splice(index, 1);
        renderQueue();
    }

    document.getElementById('startBulkUpload').addEventListener('click', async () => {
        const btn = document.getElementById('startBulkUpload');
        btn.disabled = true;
        btn.innerHTML = 'Uploading...';

        // Assuming CSRF token is available globally or we fetch it. We will inject it here:
        const csrfToken = '<?= Security::generateCsrfToken() ?>';

        for (let i = 0; i < filesQueue.length; i++) {
            if (filesQueue[i].status === 'success') continue;

            filesQueue[i].status = 'uploading';
            renderQueue();

            const formData = new FormData();
            formData.append('image', filesQueue[i].file);
            formData.append('title', filesQueue[i].title);
            formData.append('category_id', filesQueue[i].category);
            formData.append('tags', filesQueue[i].tags);
            formData.append('csrf_token', csrfToken);
            formData.append('ajax', '1');

            try {
                const response = await fetch('<?= BASE_URL ?>/admin/upload', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const result = await response.json();

                if (result.status) {
                    filesQueue[i].status = 'success';
                } else {
                    filesQueue[i].status = 'error';
                    console.error('Upload Error:', result.error);
                }
            } catch (error) {
                filesQueue[i].status = 'error';
                console.error('Network Error:', error);
            }

            renderQueue();
        }

        btn.innerHTML = 'All Done!';
    });
</script>