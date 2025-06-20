<?php include VIEW . '/components/header.php'; ?>

    <div class="auth-container">
        <div class="auth-card">
            <h2 class="auth-title">Înregistrare</h2>

            <form method="POST" class="auth-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">Parolă</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= $error ?></div>
                <?php endif; ?>

                <button type="submit" class="btn btn-primary btn-block">Creează cont</button>
            </form>

            <div class="auth-footer">
                <p>Ai deja cont? <a href="/PIG/public/login">Autentifică-te</a></p>
            </div>
        </div>
    </div>

<?php include VIEW . '/components/footer.php'; ?>