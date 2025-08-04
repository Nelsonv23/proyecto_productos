CREATE DATABASE IF NOT EXISTS productos CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE productos;

CREATE TABLE IF NOT EXISTS bodegas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS sucursales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    bodega_id INT NOT NULL,
    FOREIGN KEY (bodega_id) REFERENCES bodegas(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS monedas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(15) UNIQUE NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    bodega_id INT NOT NULL,
    sucursal_id INT NOT NULL,
    moneda_id INT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    descripcion TEXT NOT NULL,
    materiales TEXT NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (bodega_id) REFERENCES bodegas(id),
    FOREIGN KEY (sucursal_id) REFERENCES sucursales(id),
    FOREIGN KEY (moneda_id) REFERENCES monedas(id)
) ENGINE = InnoDB;

INSERT INTO bodegas (nombre) VALUES
('Bodega Temuco'),
('Bodega Santiago'),
('Bodega Puerto Montt');

INSERT INTO sucursales (nombre, bodega_id) VALUES
('Sucursal PLC', 1),
('Sucursal PDV', 1),
('Sucursal Centro', 1),
('Sucursal Pudahuel', 2),
('Sucursal Las Condes', 2),
('Sucursal Castro', 3),
('Sucursal PuertoCentro', 3);

INSERT INTO monedas (nombre) VALUES
('Soles'),
('Dólares'),
('Euros'),
('Pesos');