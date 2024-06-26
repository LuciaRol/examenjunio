<link rel="stylesheet" href="public/css/styles.css">
<header class="header">
    <div class="header_first_div">
        <div class="header_principal">
            <div ><img class="principal_logo" src="public/img/logo.png" alt=""></div>
            <h1 class="principal_title">Examen Junio</h1>
        </div>
        <nav class="nav_container">
            <a class="nav_link" href="<?= BASE_URL ?>">Inicio</a>
            <a class="nav_link" href="<?= BASE_URL ?>categorias">Especialidades</a>
            <a class="nav_link" href="<?= BASE_URL ?>productos">Servicios</a>
            <a class="nav_link" href="<?= BASE_URL ?>medicos">Médicos</a>
            <a class="nav_link" href="<?= BASE_URL ?>citas">Citas</a>
            <a class="nav_link" href="<?= BASE_URL ?>usuario">Mi perfil</a>
            <a class="nav_link" href="<?= BASE_URL ?>iniciosesion">Login</a>
            <a class="nav_link" href="<?= BASE_URL ?>registro">Registro</a>
        </nav>
    </div>

    <div class="header_second_div">
        <div class="search_container">
            <form action="<?=  BASE_URL ?>busqueda" method="POST">
                <input class="search_input" type="text" name="q" placeholder="Busca categoría o nombre">
                <button type="submit" class="search_button login_btn">Buscar</button>
            </form>  
        </div>

        <div class="login_container">
            <?php if (isset($_SESSION['email'])): ?>
                <p>Hola, <?= htmlspecialchars($_SESSION['email']); ?></p>
                <form action="<?= BASE_URL ?>logout" method="POST">
                    <button type="submit" class="logout_button login_btn">Cerrar sesión</button>
                </form>
            <?php else: ?>
               
            <?php endif; ?>
        </div>
    </div>
</header>




