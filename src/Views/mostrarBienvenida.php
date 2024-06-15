<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida - Plantilla de Examen</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>ESTA ES LA BIENVENIDA</h1>
        <p>Bienvenido a la plantilla de examen. A continuación, se explican los puntos clave que abarca esta plantilla:</p>
        
        <h2>1. Estructura de la Base de Datos</h2>
        <p>La base de datos se crea con el nombre <code>examenjunio</code> y se utiliza el conjunto de caracteres UTF-8 para garantizar la compatibilidad con caracteres especiales.</p>
        
        <h2>2. Tablas Principales</h2>
        <p>Las principales tablas de la base de datos son:</p>
        <ul>
            <li><strong>usuarios</strong>: Almacena la información de los usuarios, incluyendo nombre, apellidos, email, contraseña y rol.</li>
            <li><strong>categorias</strong>: Contiene las diferentes categorías de productos.</li>
            <li><strong>productos</strong>: Almacena los productos disponibles, con detalles como nombre, descripción, precio, stock, etc.</li>
            <li><strong>pedidos</strong>: Registra los pedidos realizados por los usuarios, incluyendo información de envío y estado del pedido.</li>
            <li><strong>lineas_pedidos</strong>: Detalla los productos incluidos en cada pedido.</li>
            <li><strong>clientes_cita</strong>: Contiene la información de los clientes que solicitan citas, incluyendo el usuario que los registra.</li>
            <li><strong>citas</strong>: Registra las citas agendadas, con información del cliente, usuario que registra la cita y descripción.</li>
        </ul>
        
        <h2>3. Relaciones entre Tablas</h2>
        <p>Las relaciones entre las tablas se gestionan mediante claves foráneas para garantizar la integridad referencial. Por ejemplo:</p>
        <ul>
            <li>La tabla <strong>productos</strong> está relacionada con <strong>categorias</strong> a través de <code>categoria_id</code>.</li>
            <li>La tabla <strong>pedidos</strong> está relacionada con <strong>usuarios</strong> a través de <code>usuario_id</code>.</li>
            <li>La tabla <strong>lineas_pedidos</strong> está relacionada con <strong>pedidos</strong> y <strong>productos</strong> mediante <code>pedido_id</code> y <code>producto_id</code> respectivamente.</li>
            <li>La tabla <strong>clientes_cita</strong> está relacionada con <strong>usuarios</strong> a través de <code>usuario_id</code>.</li>
            <li>La tabla <strong>citas</strong> está relacionada con <strong>usuarios</strong> y <strong>clientes_cita</strong> mediante <code>usuario_id</code> y <code>cliente_id</code> respectivamente.</li>
        </ul>
        
        <h2>4. Inserción de Datos</h2>
        <p>Los datos se insertan de manera genérica para facilitar la configuración inicial de la base de datos. Por ejemplo:</p>
        <ul>
            <li>En la tabla <strong>categorias</strong> se insertan valores como 'Categoria1', 'Categoria2', etc.</li>
            <li>En la tabla <strong>productos</strong> se insertan productos genéricos como 'Producto1', 'Producto2', etc.</li>
            <li>En la tabla <strong>clientes_cita</strong> se insertan clientes genéricos como 'Cliente1', 'Cliente2', etc.</li>
            <li>En la tabla <strong>citas</strong> se registran citas genéricas como 'Descripción de la cita1', 'Descripción de la cita2', etc.</li>
        </ul>
        
        <h2>5. Uso de la Plantilla</h2>
        <p>Esta plantilla está diseñada para facilitar la creación y gestión de una base de datos estructurada y bien organizada. Puedes utilizarla como base para desarrollar aplicaciones más complejas.</p>
        
        
    </div>
</body>
</html>
