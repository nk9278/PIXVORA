<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 30px;">
    <h2>Category Management</h2>
    <button class="btn btn-primary btn-sm"><i data-lucide="plus" style="width:14px; margin-right:5px;"></i> New Category</button>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Slug</th>
                    <th>Subcategories</th>
                    <th>Images</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($categories as $cat): ?>
                <tr>
                    <td style="font-weight:600;"><?= Security::esc($cat['name']) ?></td>
                    <td style="color:#666; font-size:0.9rem;"><?= Security::esc($cat['slug']) ?></td>
                    <td>0</td> <!-- Placeholder -->
                    <td>0</td> <!-- Placeholder -->
                    <td>
                        <button style="background:none; border:none; color:#555; cursor:pointer; margin-right:10px;"><i data-lucide="edit" style="width:18px;"></i></button>
                        <button style="background:none; border:none; color:#E63946; cursor:pointer;"><i data-lucide="trash-2" style="width:18px;"></i></button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>