<div class="admin-card text-center">
    <img src="<?= BASE_URL ?>/assets/img/logo.png" alt="Pixvora" style="height: 40px; margin: 0 auto 30px;">
    <h2 style="margin-bottom: 20px;">Admin Login</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= Security::esc($error) ?></div>
    <?php endif; ?>
    <?php if (isset($_GET['timeout'])): ?>
        <div class="alert alert-error">Session expired. Please login again.</div>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_URL ?>/admin/login" style="text-align: left;">
        <input type="hidden" name="csrf_token" value="<?= Security::generateCsrfToken() ?>">

        <div class="form-group">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="form-group">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">Login securely</button>
    </form>
</div>