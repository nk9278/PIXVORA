<div class="admin-card text-center">
    <img src="<?= BASE_URL ?>/assets/img/logo.png" alt="Pixvora" style="height: 40px; margin: 0 auto 30px;">
    <h2 style="margin-bottom: 20px;">Admin Login</h2>

    <?php if (!empty($error)): ?>
        <div style="background: #ffebee; color: #c62828; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: left; font-size: 0.9rem;">
            <?= Security::esc($error) ?>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['timeout'])): ?>
        <div style="background: #ffebee; color: #c62828; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: left; font-size: 0.9rem;">
            Session expired. Please login again.
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/admin/login" style="text-align: left;">
        <input type="hidden" name="csrf_token" value="<?= Security::generateCsrfToken() ?>">

        <div style="margin-bottom: 15px;">
            <label style="display:block; margin-bottom: 5px; font-weight: 500; font-size: 0.9rem;">Username</label>
            <input type="text" name="username" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;" required>
        </div>

        <div style="margin-bottom: 20px;">
            <label style="display:block; margin-bottom: 5px; font-weight: 500; font-size: 0.9rem;">Password</label>
            <input type="password" name="password" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box;" required>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%;">Login securely</button>
    </form>
</div>