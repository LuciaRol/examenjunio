<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de servicios</title>
    <link rel="stylesheet" href="path/to/your/styles.css">
</head>
<body class="productos-body">
    <main class="productos-main">
        <h2 class="productos-heading">Lista de servicios</h2>
        <?php if (!empty($mensaje)): ?>
            <p class="productos-mensaje"><?php echo $mensaje; ?></p>
        <?php endif; ?>
        <?php if (!empty($productos)): ?>
            <table class="productos-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Precio (€)</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr id="producto-<?php echo htmlspecialchars($producto->getId(), ENT_QUOTES, 'UTF-8'); ?>">
                            <td><?php echo htmlspecialchars($producto->getId(), ENT_QUOTES, 'UTF-8'); ?></td>
                            
                            <td>
                                <span class="productos-texto"><?php echo htmlspecialchars($producto->getNombre(), ENT_QUOTES, 'UTF-8'); ?></span>
                            </td>
                            <td>
                                <span class="productos-texto"><?php echo htmlspecialchars($producto->getDescripcion() ?? 'Sin descripción', ENT_QUOTES, 'UTF-8'); ?></span>
                            </td>
                            <td>
                                <span class="productos-texto"><?php echo htmlspecialchars($producto->getPrecio(), ENT_QUOTES, 'UTF-8'); ?></span>
                            </td>
                            <td>
                                <?php if ($rol === 'admin'): ?>
                                    <!-- Formulario para eliminar producto -->
                                    <form action="<?= BASE_URL ?>eliminar_producto" method="POST" style="display:inline;">
                                        <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto->getId(), ENT_QUOTES, 'UTF-8'); ?>">
                                        <button type="submit" class="form-submit">Borrar servicio</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay servicios disponibles.</p>
        <?php endif; ?>
    
        <!-- formulario para agregar nuevos productos -->
        <?php if ($rol === 'admin'): ?>
            <div class="productos-nuevo">
                <h2 class="productos-registro-form-heading">Crear nuevo servicio</h2>
                <div class="productos-registro-form">
                
                <form action="<?= BASE_URL ?>nuevo_producto" method="POST" class="productos-registro-formulario"> 
                    <label for="nuevo_producto">Servicio:</label><br>
                    <input type="text" id="nuevo_producto" name="nuevo_producto" required class="productos-registro-input"><br><br> 
                    
                    <label for="categoria">Categoría:</label><br>
                    <select id="categoria" name="categoria" required class="productos-registro-select">
                        <?php foreach ($categorias as $categoria): ?>
                            <option value="<?php echo htmlspecialchars($categoria->getId(), ENT_QUOTES, 'UTF-8'); ?>"><?php echo htmlspecialchars($categoria->getNombre(), ENT_QUOTES, 'UTF-8'); ?></option>
                        <?php endforeach; ?>
                    </select><br><br>
                    <label for="descripcion">Descripción:</label><br>
                    <textarea id="descripcion" name="descripcion" rows="4" cols="50" class="productos-registro-textarea"></textarea><br><br>

                    <label for="precio">Precio:</label><br>
                    <input type="number" id="precio" name="precio" step="0.01" required class="productos-registro-input"><br><br>
                    

                    <input type="submit" value="Crear producto" class="productos-registro-button form-submit"> <!-- Cambiado el texto del botón para reflejar que se está creando un producto -->
                </form>
            </div>
        </div>

        <?php endif; ?>
        <?php if ($rol === 'admin'): ?>
             <h2 class="productos-editar-titulo">Editar servicios ya existentes</h2>
        <table class="productos-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Categoría</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio (€)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <!-- Agregar un formulario para cada fila -->
                        <form action="<?= BASE_URL ?>editar_producto" method="POST">
                            <!-- Utilizar el ID del producto como identificador único -->
                            <input type="hidden" name="producto_id" value="<?php echo htmlspecialchars($producto->getId(), ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="hidden" name="categoria_id" value="<?php echo htmlspecialchars($producto->getCategoriaId(), ENT_QUOTES, 'UTF-8'); ?>">
                            <td><?php echo htmlspecialchars($producto->getId(), ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><input type="text" name="nombre" value="<?php echo htmlspecialchars($producto->getNombre(), ENT_QUOTES, 'UTF-8'); ?>"></td>
                            <td><textarea name="descripcion"><?php echo htmlspecialchars($producto->getDescripcion() ?? 'Sin descripción', ENT_QUOTES, 'UTF-8'); ?></textarea></td>
                            
                            <td>
                                <button type="submit" class="form-submit">Guardar</button> <!-- No es necesario el formulario en la celda de acciones -->
                            </td>
                        </form>
                    </tr>
                <?php endforeach; ?>
        <?php endif; ?>
            </tbody>
        </table>
    </main>
    <script>
        function verificarStock(form) {
            const cantidad = form.querySelector('input[name="cantidad"]').value;
            const stock = form.querySelector('input[name="cantidad"]').max;
            if (parseInt(cantidad) > parseInt(stock)) {
                alert("La cantidad no puede ser mayor que el stock disponible.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
