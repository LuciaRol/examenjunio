<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida - Plantilla de Examen</title>
    <link rel="stylesheet" href="styles.css">
</head>


<body>



<?php
    // Verificar si hay errores de registro y mostrar el mensaje
    if (isset($mensajeError) && is_array($mensajeError)) {
        echo "<ul>";
        foreach ($mensajeError as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
    ?>


    <div class="container">
        <h1>ESTA ES LA BIENVENIDA</h1>
        <p>Bienvenido a la plantilla de examen. A continuación, se explican los puntos clave que abarca esta plantilla:</p>
        
        <h2>1. Estructura de la Base de Datos</h2>
        <p>La base de datos se crea con el nombre <code>examenjunio</code> y se utiliza el conjunto de caracteres UTF-8 para garantizar la compatibilidad con caracteres especiales.</p>
        
        <h2>2. Tablas Principales</h2>
        <p>Las principales tablas de la base de datos son:</p>
        <ul>
            <li><strong>usuarios</strong>: Almacena la información de los usuarios.</li>
            <li><strong>categorias</strong>: En este proyecto es como se llaman las ESPECIALIDADES.</li>
            <li><strong>productos</strong>:En este proyecto es como se llaman los SERVICIOS.</li>
            <li><strong>medicos</strong>: Contiene la información de los clientes que solicitan citas, incluyendo el usuario que los registra.</li>
            <li><strong>citas</strong>: Registra las citas agendadas, con información del medico y el usuario que registra la cita.</li>
        </ul>
        
        
        
        
    </div>
</body>
</html>
