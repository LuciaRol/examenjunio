USE examenjunio;

-- Insertar datos en la tabla usuarios
INSERT INTO usuarios (nombre, apellidos, usuario, email, contrasena, rol) VALUES
    ('admin', 'admin', 'admin', 'admin@admin.com', 'admin', 'admin'),
    ('user1', 'user1', 'user1', 'user1@user1.com', 'user1', 'usur'),
    ('user2', 'user2', 'user2', 'user2@user2.com', 'user2', 'usur');

-- Insertar datos en la tabla categorias
INSERT INTO categorias (nombre) VALUES
('Oftalmología'),
('Ginecología'),
('Pediatría'),
('Traumatología'),
('Rehabilitación');

-- Insertar datos en la tabla productos
INSERT INTO productos (categoria_id, nombre, descripcion, precio) VALUES
(1, 'Revisión general', 'Revisión ordinaria de la vista', 100),
(2, 'Citología', 'Toma de muestras', 200),
(3, 'Revisión', 'Chequeo anual', 80),
(4, 'Tratamiento facitis plantar', 'Observación y pruebas de dolencias del pie.', 80),
(5, 'Ondas de choque', 'Tratamiento con ondas de choqu', 60);

-- Insertar datos en la tabla pedidos
/*INSERT INTO pedidos (usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora) VALUES
(1, 'Provincia1', 'Localidad1', 'Direccion1', 100.00, 'no enviado', '2024-05-05', '10:30:00'),
(2, 'Provincia2', 'Localidad2', 'Direccion2', 200.00, 'no enviado', '2024-05-10', '14:45:00');

-- Insertar datos en la tabla lineas_pedidos
INSERT INTO lineas_pedidos (pedido_id, producto_id, unidades) VALUES
(1, 1, 1),  
(1, 3, 1),  
(2, 5, 2);  
*/
-- Insertar datos en la tabla clientes_cita
INSERT INTO clientes_cita (nombre, apellidos, telefono, email, usuario_id) VALUES
('Cliente1', 'Apellido1', '111111111', 'cliente1@example.com', 1),
('Cliente2', 'Apellido2', '222222222', 'cliente2@example.com', 2),
('Cliente3', 'Apellido3', '333333333', 'cliente3@example.com', 3);

-- Insertar datos en la tabla citas
INSERT INTO citas (fecha_hora, descripcion, usuario_id, cliente_id, fecha_registro) VALUES
('2024-06-20 09:00:00', 'Descripción de la cita1.', 1, 1, '2024-06-10 08:00:00'),
('2024-06-21 10:00:00', 'Descripción de la cita2.', 2, 2, '2024-06-11 09:00:00'),
('2024-06-22 11:00:00', 'Descripción de la cita3.', 3, 3, '2024-06-12 10:00:00');
