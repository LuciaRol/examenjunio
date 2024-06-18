<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de categorías</title>
    <link rel="stylesheet" type="text/css" href="public/css/styles.css">
</head>
<body>
    <h2 class="card-h2">Lista de médicos</h2>
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
                <?php foreach ($medicos as $medico): ?>
                    <tr>
                        <td><?php echo $medico->getId(); ?></td>
                        <td><?php echo $medico->getNombre(); ?></td>
                        <td><?php echo $medico->getApellidos(); ?></td>
                        <td><?php echo $medico->getTelefono(); ?></td>
                        <td><?php echo $medico->getEmail(); ?></td>
                        <td><?php echo $medico->getUsuarioId(); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

   
    <!-- Formulario para crear un nuevo medico -->
    <?php if ($rol === 'admin'): ?>
        <div class="cliente-container">
    <div class="cliente-card">
            <h2 class="cliente-card-h2">Crear nuevo medico</h2>
            <form action="<?= BASE_URL ?>registro_medico" method="POST" class="cliente-form">
                <label for="nombre_cliente" class="cliente-form-label">Nombre:</label>
                <input type="text" id="nombre_medico" name="nombre_medico" required class="cliente-form-input"><br><br>
                
                <label for="apellidos_medico" class="cliente-form-label">Apellidos:</label>
                <input type="text" id="apellidos_medico" name="apellidos_medico" required class="cliente-form-input"><br><br>
                
                <label for="telefono_medico" class="cliente-form-label">Teléfono:</label>
                <input type="text" id="telefono_medico" name="telefono_medico" class="cliente-form-input"><br><br>
                
                <label for="email_medico" class="cliente-form-label">Email:</label>
                <input type="email" id="email_medico" name="email_medico" class="cliente-form-input"><br><br>
                
                <!-- Campo oculto para usuario_id -->
                <input type="hidden" id="usuario_id" name="usuario_id" value="<?= htmlspecialchars($usuario_id, ENT_QUOTES, 'UTF-8'); ?>">
            
                <input type="submit" value="Crear medico" class="cliente-form-submit">
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
