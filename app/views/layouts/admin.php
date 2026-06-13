<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | Pixvora</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <style>
        body { background-color: var(--clr-soft-white); }
        .admin-sidebar {
            width: 250px;
            background: var(--clr-black);
            color: var(--clr-white);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding: 20px;
        }
        .admin-sidebar a {
            display: block;
            color: #aaa;
            padding: 10px 0;
            border-bottom: 1px solid #333;
        }
        .admin-sidebar a:hover { color: var(--clr-white); }
        .admin-content {
            margin-left: 250px;
            padding: 40px;
        }
        .admin-card {
            background: var(--clr-white);
            border-radius: var(--radius-md);
            padding: 30px;
            box-shadow: var(--shadow-soft);
        }
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .alert-error { background: #ffebee; color: #c62828; }
        .alert-success { background: #e8f5e9; color: #2e7d32; }
    </style>
</head>
<body>

    <?php if (Security::isLoggedIn()): ?>
        <div class="admin-sidebar">
            <h3 style="color:white; margin-bottom: 30px;">Pixvora Admin</h3>
            <a href="<?= BASE_URL ?>/admin/upload">Upload Image</a>
            <a href="<?= BASE_URL ?>/">View Site</a>
            <a href="<?= BASE_URL ?>/admin/logout" style="color: var(--clr-accent-red);">Logout</a>
        </div>
        <div class="admin-content">
            <?php
            if (isset($content_view)) {
                require_once $content_view;
            } else {
                echo "<h2>Admin Dashboard</h2>";
            }
            ?>
        </div>
    <?php else: ?>
        <!-- Login layout -->
        <div style="display: flex; justify-content: center; align-items: center; min-height: 100vh;">
            <div style="width: 100%; max-width: 400px;">
                <?php
                if (isset($content_view)) {
                    require_once $content_view;
                }
                ?>
            </div>
        </div>
    <?php endif; ?>

</body>
</html>