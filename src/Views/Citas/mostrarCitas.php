<body>
    <main>
         <h2>Lista de citas</h2>
        <?php if (!empty($mensaje)): ?>
            <p class="mensaje"><?php echo $mensaje; ?></p>
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
            <p>No hay citas disponibles.</p>
        <?php endif; ?>

    





           <!-- Agregar formulario para agregar nueva cita si es administrador <//?php if ($rol === 'admin'): ?> -->
           
            <div class="registro-container nuevo">
                <h2 class="registro-form-heading">Crear nueva cita</h2>
                <form action="<?= BASE_URL ?>nueva_cita" method="POST">
                    <label for="fecha_hora">Fecha y Hora:</label><br>
                    <input type="datetime-local" id="fecha_hora" name="fecha_hora" required><br><br>
                    <label for="descripcion">Descripción:</label><br>
                    <textarea id="descripcion" name="descripcion" rows="4" cols="50"></textarea><br><br>
                    <label for="usuario_id">ID Usuario:</label><br>
                    <input type="number" id="usuario_id" name="usuario_id" required><br><br>
                    <label for="cliente_id">ID Cliente:</label><br>
                    <select id="cliente" name="cliente" required class="registro-select">
                        <?php foreach ($clientes as $cliente): ?>
                            <option value="<?php echo htmlspecialchars($cliente->getId(), ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($cliente->getNombre(), ENT_QUOTES, 'UTF-8'); ?></option>
                        <?php endforeach; ?>
                    </select><br><br>
                    
                    
                </form>
            </div>
        <!-- <//?php endif; ?> -->
    </main>




      
    </main>
    
</body>
</html>