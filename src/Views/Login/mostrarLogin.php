<div class="login-container">
    <?php if (isset($_SESSION['email'])): ?>
        Ya estás logueado como <?= htmlspecialchars($_SESSION['email']); ?>
    <?php else: ?>
        <form class="login-form" action="<?= BASE_URL ?>login" method="POST">
            <input class="login-form-input" type="text" name="email" placeholder="Email" required>
            <input class="login-form-input" type="password" name="password" placeholder="Contraseña" required>
            <button class="login-form-btn" type="submit">Iniciar sesión</button>
            <?php if (isset($loginError)): ?>
                <p class="login-form-error"><?= htmlspecialchars($loginError); ?></p>
            <?php endif; ?>
        </form>
    <?php endif; ?>
</div>