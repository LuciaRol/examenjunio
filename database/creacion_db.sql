CREATE DATABASE IF NOT EXISTS examenjunio;
SET NAMES UTF8;
USE examenjunio;

DROP TABLE IF EXISTS usuarios;
CREATE TABLE IF NOT EXISTS usuarios(
    id INT AUTO_INCREMENT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(255),
    usuario VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    rol VARCHAR(20),
    CONSTRAINT pk_usuarios PRIMARY KEY (id),
    CONSTRAINT uq_email UNIQUE (email),
    CONSTRAINT uq_usuario UNIQUE (usuario) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

/* esto son las especialidades */
DROP TABLE IF EXISTS categorias;
CREATE TABLE IF NOT EXISTS categorias(
    id INT AUTO_INCREMENT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    CONSTRAINT pk_categorias PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


/* esto son los servicios */
DROP TABLE IF EXISTS productos;
CREATE TABLE IF NOT EXISTS productos(
    id INT AUTO_INCREMENT NOT NULL,
    categoria_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio FLOAT(10,2) NOT NULL,
    CONSTRAINT pk_productos PRIMARY KEY (id),
    CONSTRAINT fk_producto_categoria FOREIGN KEY (categoria_id) REFERENCES categorias(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS medicos;
CREATE TABLE IF NOT EXISTS medicos(
    id INT AUTO_INCREMENT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(255) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    usuario_id INT NOT NULL,
    CONSTRAINT pk_medicos_cita PRIMARY KEY (id),
    CONSTRAINT fk_medico_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

DROP TABLE IF EXISTS citas;
CREATE TABLE IF NOT EXISTS citas(
    id INT AUTO_INCREMENT NOT NULL,
    fecha_hora DATETIME NOT NULL,
    descripcion TEXT,
    usuario_id INT NOT NULL,
    medico_id INT NOT NULL,
    fecha_registro DATETIME NOT NULL,
    CONSTRAINT pk_citas PRIMARY KEY (id),
    CONSTRAINT fk_cita_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    CONSTRAINT fk_cita_medico FOREIGN KEY (medico_id) REFERENCES medicos_cita(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
