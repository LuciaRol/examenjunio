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
    <div class="cliente-container">
        <table class="clientes-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Usuario ID</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($Clientes as $Cliente): ?>
                    <tr>
                        <td><?php echo $Cliente->getId(); ?></td>
                        <td><?php echo $Cliente->getNombre(); ?></td>
                        <td><?php echo $Cliente->getApellidos(); ?></td>
                        <td><?php echo $Cliente->getTelefono(); ?></td>
                        <td><?php echo $Cliente->getEmail(); ?></td>
                        <td><?php echo $Cliente->getUsuarioId(); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

   
    <!-- Formulario para crear un nuevo cliente -->
    <?php if ($rol === 'admin'): ?>
        <div class="cliente-container">
    <div class="cliente-card">
            <h2 class="cliente-card-h2">Crear nuevo cliente</h2>
            <form action="<?= BASE_URL ?>registro_cliente" method="POST" class="cliente-form">
                <label for="nombre_cliente" class="cliente-form-label">Nombre:</label>
                <input type="text" id="nombre_cliente" name="nombre_cliente" required class="cliente-form-input"><br><br>
                
                <label for="apellidos_cliente" class="cliente-form-label">Apellidos:</label>
                <input type="text" id="apellidos_cliente" name="apellidos_cliente" required class="cliente-form-input"><br><br>
                
                <label for="telefono_cliente" class="cliente-form-label">Teléfono:</label>
                <input type="text" id="telefono_cliente" name="telefono_cliente" class="cliente-form-input"><br><br>
                
                <label for="email_cliente" class="cliente-form-label">Email:</label>
                <input type="email" id="email_cliente" name="email_cliente" class="cliente-form-input"><br><br>
                
                <!-- Campo oculto para usuario_id -->
                <input type="hidden" id="usuario_id" name="usuario_id" value="<?= htmlspecialchars($usuario_id, ENT_QUOTES, 'UTF-8'); ?>">
            
                <input type="submit" value="Crear cliente" class="cliente-form-submit">
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
