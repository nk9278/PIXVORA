<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pixvora Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <style>
        body { background-color: #f4f5f7; font-family: 'Inter', sans-serif; margin:0; padding:0; display:flex; min-height: 100vh;}

        .sidebar {
            width: 260px;
            background: #111;
            color: #fff;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: transform 0.3s ease;
        }

        .sidebar-header {
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #222;
        }
        .sidebar-header img { height: 30px; filter: invert(1) brightness(2); }

        .sidebar-menu { list-style: none; padding: 20px 0; margin: 0; }
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            padding: 12px 25px;
            color: #a0a0a0;
            text-decoration: none;
            transition: 0.2s;
            font-size: 0.95rem;
            gap: 12px;
        }
        .sidebar-menu li a:hover, .sidebar-menu li a.active {
            color: #fff;
            background: rgba(255,255,255,0.05);
            border-left: 3px solid #E63946;
        }

        .main-content {
            flex: 1;
            margin-left: 260px;
            display: flex;
            flex-direction: column;
            width: calc(100% - 260px);
        }

        .top-header {
            background: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eaeaea;
            position: sticky;
            top: 0;
            z-index: 99;
        }

        .content-area {
            padding: 30px;
            overflow-y: auto;
        }

        .admin-card {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            border: 1px solid #f0f0f0;
        }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            border: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .stat-icon {
            width: 48px; height: 48px; border-radius: 10px;
            background: rgba(230, 57, 70, 0.1); color: #E63946;
            display: flex; align-items: center; justify-content: center;
        }
        .stat-info h4 { margin: 0; font-size: 0.9rem; color: #666; font-weight: 500; }
        .stat-info h2 { margin: 5px 0 0; font-size: 1.5rem; color: #111; }

        .table-responsive { overflow-x: auto; }
        .admin-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .admin-table th, .admin-table td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #eee; }
        .admin-table th { color: #666; font-weight: 600; font-size: 0.9rem; background: #fafafa; }
        .admin-table tbody tr:hover { background: #f9f9f9; }

        .btn-sm { padding: 6px 12px; font-size: 0.85rem; }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; width: 100%; }
        }
        .mobile-toggle { display: none; background:none; border:none; font-size: 1.5rem; cursor:pointer;}
        @media (max-width: 992px) { .mobile-toggle { display: block; } }

        /* Login Layout Specific */
        .login-wrapper {
            display: flex; justify-content: center; align-items: center; min-height: 100vh; width: 100%; background: #f4f5f7;
        }
    </style>
</head>
<body>

    <?php if (Security::isLoggedIn()): ?>

        <aside class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <img src="<?= BASE_URL ?>/assets/img/logo.png" alt="Pixvora">
                <button class="mobile-toggle" id="closeSidebar" style="color:white;"><i data-lucide="x"></i></button>
            </div>
            <ul class="sidebar-menu">
                <li><a href="<?= BASE_URL ?>/admin/dashboard"><i data-lucide="layout-dashboard"></i> Dashboard</a></li>
                <li style="padding: 15px 25px 5px; font-size: 0.75rem; text-transform: uppercase; color: #555; font-weight: bold;">Content</li>
                <li><a href="<?= BASE_URL ?>/admin/upload"><i data-lucide="upload-cloud"></i> Upload Image</a></li>
                <li><a href="<?= BASE_URL ?>/admin/bulk-upload"><i data-lucide="copy-plus"></i> Bulk Upload</a></li>
                <li><a href="<?= BASE_URL ?>/admin/manage-images"><i data-lucide="images"></i> Manage Images</a></li>
                <li style="padding: 15px 25px 5px; font-size: 0.75rem; text-transform: uppercase; color: #555; font-weight: bold;">Taxonomy</li>
                <li><a href="<?= BASE_URL ?>/admin/categories"><i data-lucide="folder-tree"></i> Categories</a></li>
                <li><a href="<?= BASE_URL ?>/admin/tags"><i data-lucide="tags"></i> Tags</a></li>
                <li style="padding: 15px 25px 5px; font-size: 0.75rem; text-transform: uppercase; color: #555; font-weight: bold;">System</li>
                <li><a href="<?= BASE_URL ?>/admin/seo"><i data-lucide="search"></i> SEO Settings</a></li>
                <li><a href="<?= BASE_URL ?>/admin/homepage"><i data-lucide="layout-template"></i> Homepage UI</a></li>
                <li><a href="<?= BASE_URL ?>/admin/blog"><i data-lucide="file-text"></i> Blog CMS</a></li>
                <li><a href="<?= BASE_URL ?>/admin/settings"><i data-lucide="settings"></i> Settings</a></li>
                <li style="margin-top: 20px;"><a href="<?= BASE_URL ?>/admin/logout" style="color: #E63946;"><i data-lucide="log-out"></i> Logout</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <header class="top-header">
                <div style="display:flex; align-items:center; gap:15px;">
                    <button class="mobile-toggle" id="openSidebar"><i data-lucide="menu"></i></button>
                    <a href="<?= BASE_URL ?>/" target="_blank" class="btn btn-outline btn-sm"><i data-lucide="external-link" style="width:14px; height:14px; vertical-align:middle; margin-right:5px;"></i> View Site</a>
                </div>
                <div style="display:flex; align-items:center; gap:15px;">
                    <span style="font-weight: 500; font-size:0.9rem;">Admin</span>
                    <div style="width: 35px; height: 35px; border-radius: 50%; background: #111; color: #fff; display:flex; align-items:center; justify-content:center; font-weight:bold;">A</div>
                </div>
            </header>

            <div class="content-area">
                <?php
                if (isset($content_view)) {
                    require_once $content_view;
                }
                ?>
            </div>
        </main>

    <?php else: ?>
        <div class="login-wrapper">
            <div style="width: 100%; max-width: 400px; padding: 20px;">
                <?php
                if (isset($content_view)) {
                    require_once $content_view;
                }
                ?>
            </div>
        </div>
    <?php endif; ?>

    <script>
        lucide.createIcons();

        const sidebar = document.getElementById('sidebar');
        const openBtn = document.getElementById('openSidebar');
        const closeBtn = document.getElementById('closeSidebar');

        if (openBtn && sidebar) {
            openBtn.addEventListener('click', () => sidebar.classList.add('show'));
            closeBtn.addEventListener('click', () => sidebar.classList.remove('show'));
        }
    </script>
</body>
</html>