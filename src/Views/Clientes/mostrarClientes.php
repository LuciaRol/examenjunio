<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de categorías</title>
    <link rel="stylesheet" type="text/css" href="public/css/styles.css">
</head>
<body>
    <h2 class="card-h2">Cliente</h2>
    <div class="card-container">
        <?php foreach ($Clientes as $Cliente): ?>
            <div class="card">
                <div class="card-body">
                    <article class="Cliente">
                        <p>ID: <?php echo $Cliente->getId(); ?></p>
                        <p>Nombre: <?php echo $Cliente->getNombre(); ?></p>
                        <p>Apellidos: <?php echo $Cliente->getApellidos(); ?></p>
                        <p>Teléfono: <?php echo $Cliente->getTelefono(); ?></p>
                        <p>Email: <?php echo $Cliente->getEmail(); ?></p>
                        <p>usuario_id: <?php echo $Cliente->getUsuarioId(); ?></p>
                        <!-- Formulario para mostrar productos de esta categoría -->
                    </article>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
   
    <!-- Formulario para crear un nuevo cliente -->
    <?php if ($rol === 'admin'): ?>
        <div class=>
            <div class=>
                <h2 class="card-h2">Crear nuevo cliente</h2>
                <form action="<?= BASE_URL ?>registro_cliente" method="POST" class="form-cliente">
                    <label for="nombre_cliente" class="form-label">Nombre:</label>
                    <input type="text" id="nombre_cliente" name="nombre_cliente" required class="form-input"><br><br>
                    
                    <label for="apellidos_cliente" class="form-label">Apellidos:</label>
                    <input type="text" id="apellidos_cliente" name="apellidos_cliente" required class="form-input"><br><br>
                    
                    <label for="telefono_cliente" class="form-label">Teléfono:</label>
                    <input type="text" id="telefono_cliente" name="telefono_cliente" class="form-input"><br><br>
                    
                    <label for="email_cliente" class="form-label">Email:</label>
                    <input type="email" id="email_cliente" name="email_cliente" class="form-input"><br><br>
                    
                    <!-- Campo oculto para usuario_id -->
                    <input type="hidden" id="usuario_id" name="usuario_id" value="<?= htmlspecialchars($usuario_id, ENT_QUOTES, 'UTF-8'); ?>">
                
                    
                    <input type="submit" value="Crear cliente" class="form-submit">
                </form>
            </div>
        </div>
    <?php endif; ?>

<!-- Display message if it exists -->
<?php if (!empty($mensaje)): ?>
    <div class="message">
        <p><?php echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8'); ?></p>
    </div>
<?php endif; ?>


</body>
</html>
