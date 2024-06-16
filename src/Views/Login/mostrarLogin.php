<h2>Login</h2>

<div class="login-container">
    <!-- si quiero entrar con email, aqui cambio 'usuario' por 'email' -->
    <?php if (isset($_SESSION['usuario'])): ?>
        Ya estás logueado como <?= htmlspecialchars($_SESSION['usuario']); ?>
        <form action="<?= BASE_URL ?>logout" method="POST">
                    <button type="submit" class="logout_button login_btn">Cerrar sesión</button>
                </form>
    <?php else: ?>
        <form class="login-form" action="<?= BASE_URL ?>login" method="POST">
            <input class="login-form-input" type="text" name="usuario" placeholder="Usuario" required>
            <!-- Se pone esto si se loguea con el usuario en vez de con el email -->
            <!-- <input class="login-form-input" type="text" name="email" placeholder="Email" required> -->
            <input class="login-form-input" type="password" name="password" placeholder="Contraseña" required>
            <button class="login-form-btn" type="submit">Iniciar sesión</button>
            <?php if (isset($loginError)): ?>
                <p class="login-form-error"><?= htmlspecialchars($loginError); ?></p>
            <?php endif; ?>
        </form>
    <?php endif; ?>
</div>