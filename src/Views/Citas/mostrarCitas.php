<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de citas</title>
    <link rel="stylesheet" href="path/to/your/styles.css">
</head>
<body class="citas-body">
    <main class="citas-main">
        <h2 class="citas-heading">Lista de citas</h2>
        <?php if (!empty($mensaje)): ?>
            <p class="citas-mensaje"><?php echo $mensaje; ?></p>
        <?php endif; ?>
        <?php if (!empty($citas)): ?>
            <table class="citas-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha y Hora</th>
                        <th>Descripción</th>
                        <th>ID Usuario</th>
                        <th>ID Cliente</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($citas as $cita): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($cita->getCitaId(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($cita->getFechaHora(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($cita->getDescripcion() ?? 'Sin descripción', ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($cita->getNombreUsuario(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($cita->getNombreCliente(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($cita->getFechaRegistro(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <?php if ($rol === 'admin'): ?>
                                    <!-- Formulario para eliminar cita -->
                                    <form action="<?= BASE_URL ?>eliminar_cita" method="POST">
                                        <input type="hidden" name="cita_id" value="<?php echo htmlspecialchars($cita->getCitaId(), ENT_QUOTES, 'UTF-8'); ?>">
                                        <button type="submit" class="form-submit">Borrar cita</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="citas-no-citas">No hay citas disponibles.</p>
        <?php endif; ?>

        <!-- Agregar formulario para agregar nueva cita si es administrador -->
        <?php if ($rol === 'admin'): ?>
            <div class="citas-nuevo">
                <h2 class="citas-registro-form-heading">Crear nueva cita</h2>
                <form action="<?= BASE_URL ?>nueva_cita" method="POST" class="citas-registro-form">
                    <label for="fecha_hora">Fecha y Hora:</label><br>
                    <input type="datetime-local" id="fecha_hora" name="fecha_hora" required><br><br>
                    <label for="descripcion">Descripción:</label><br>
                    <textarea id="descripcion" name="descripcion" rows="4" cols="50"></textarea><br><br>
                    <input type="hidden" id="usuario_id" name="usuario_id" value="<?= htmlspecialchars($usuario_id, ENT_QUOTES, 'UTF-8'); ?>">
                    <label for="cliente">ID Cliente:</label><br>
                    <select id="cliente" name="cliente" required class="registro-select">
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?php echo htmlspecialchars($cliente->getId(), ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($cliente->getNombre(), ENT_QUOTES, 'UTF-8'); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="submit" value="Crear nueva cita" class="form-submit">
                </form>
            </div>

            <h2 class="citas-editar-titulo">Editar Citas ya existentes</h2>
            <table class="citas-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha y Hora</th>
                        <th>Descripción</th>
                        <th>ID Usuario</th>
                        <th>ID Cliente</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($citas as $cita): ?>
                        <tr>
                            <!-- Agregar un formulario para cada fila -->
                            <form action="<?= BASE_URL ?>editar_cita" method="POST">
                                <!-- Utilizar el ID del cita como identificador único -->
                                <input type="hidden" name="cita_id" value="<?php echo htmlspecialchars($cita->getCitaId(), ENT_QUOTES, 'UTF-8'); ?>">
                                <td><?php echo htmlspecialchars($cita->getCitaId(), ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><input type="datetime-local" name="fecha_hora" value="<?php echo htmlspecialchars($cita->getFechaHora(), ENT_QUOTES, 'UTF-8'); ?>"></td>
                                <td><textarea name="descripcion"><?php echo htmlspecialchars($cita->getDescripcion() ?? 'Sin descripción', ENT_QUOTES, 'UTF-8'); ?></textarea></td>
                                <td><input type="number" name="usuario_id" value="<?php echo htmlspecialchars($cita->getUsuarioId(), ENT_QUOTES, 'UTF-8'); ?>" readonly></td>
                                <td><input type="number" name="cliente_id" value="<?php echo htmlspecialchars($cita->getClienteId(), ENT_QUOTES, 'UTF-8'); ?>"></td>
                                <td><?php echo htmlspecialchars($cita->getFechaRegistro(), ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                    <button type="submit" class="form-submit">Guardar</button>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="citas-no-citas">No hay citas disponibles.</p>
        <?php endif; ?>
    </main>
</body>
</html>
