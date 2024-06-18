USE examenjunio;

-- Insertar datos en la tabla usuarios
INSERT INTO usuarios (nombre, apellidos, usuario, email, contrasena, rol) VALUES
    ('admin', 'admin', 'admin', 'admin@admin.com', 'admin', 'admin'),
    ('user1', 'user1', 'user1', 'user1@user1.com', 'user1', 'usur'),
    ('user2', 'user2', 'user2', 'user2@user2.com', 'user2', 'usur');

-- Insertar datos en la tabla categorias (especialidades)
INSERT INTO categorias (nombre) VALUES
('Oftalmología'),
('Ginecología'),
('Pediatría'),
('Traumatología'),
('Rehabilitación');

-- Insertar datos en la tabla productos()
INSERT INTO productos (categoria_id, nombre, descripcion, precio) VALUES
(1, 'Revisión general', 'Revisión ordinaria de la vista', 100),
(2, 'Citología', 'Toma de muestras', 200),
(3, 'Revisión', 'Chequeo anual', 80),
(4, 'Tratamiento facitis plantar', 'Observación y pruebas de dolencias del pie.', 80),
(5, 'Ondas de choque', 'Tratamiento con ondas de choqu', 60);


-- Insertar datos en la tabla medicos_cita
INSERT INTO medicos (nombre, apellidos, telefono, email, usuario_id) VALUES
('medico1', 'Apellido1', '111111111', 'medico1@example.com', 1),
('medico2', 'Apellido2', '222222222', 'medico2@example.com', 2),
('medico3', 'Apellido3', '333333333', 'medico3@example.com', 3);

-- Insertar datos en la tabla citas
INSERT INTO citas (fecha_hora, descripcion, usuario_id, medico_id, fecha_registro) VALUES
('2024-06-20 09:00:00', 'Descripción de la cita1.', 1, 1, '2024-06-10 08:00:00'),
('2024-06-21 10:00:00', 'Descripción de la cita2.', 2, 2, '2024-06-11 09:00:00'),
('2024-06-22 11:00:00', 'Descripción de la cita3.', 3, 3, '2024-06-12 10:00:00');
