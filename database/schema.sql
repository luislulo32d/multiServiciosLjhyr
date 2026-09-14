SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS ljhyr CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE ljhyr;

CREATE TABLE categoria (
  categoria_id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE marca (
  marca_id INT AUTO_INCREMENT PRIMARY KEY,
  marca VARCHAR(100) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE tasa (
  tasa_id INT AUTO_INCREMENT PRIMARY KEY,
  fecha DATE NOT NULL UNIQUE,
  oficial DECIMAL(12,4) NOT NULL,
  moneda VARCHAR(10) NOT NULL DEFAULT 'USD',
  creada_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE inventario (
  producto_id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  categoria_id INT NULL,
  marca_id INT NULL,
  preciod DECIMAL(12,2) NOT NULL DEFAULT 0,
  preciobs DECIMAL(14,2) NOT NULL DEFAULT 0,
  foto_id INT NULL,
  cantidad INT NOT NULL DEFAULT 0,
  ultimacompra DATE NULL,
  ultimaventa DATE NULL,
  activo TINYINT(1) NOT NULL DEFAULT 1,
  creado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  actualizado_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT fk_inv_cat FOREIGN KEY (categoria_id) REFERENCES categoria(categoria_id) ON DELETE SET NULL,
  CONSTRAINT fk_inv_mar FOREIGN KEY (marca_id) REFERENCES marca(marca_id) ON DELETE SET NULL,
  INDEX idx_activo (activo),
  INDEX idx_nombre (nombre)
) ENGINE=InnoDB;

CREATE TABLE imagen (
  imagen_id INT AUTO_INCREMENT PRIMARY KEY,
  producto_id INT NOT NULL UNIQUE,
  nombre VARCHAR(255) NOT NULL,
  ruta VARCHAR(255) NOT NULL,
  creada_en DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_img_prod FOREIGN KEY (producto_id) REFERENCES inventario(producto_id) ON DELETE CASCADE
) ENGINE=InnoDB;

ALTER TABLE inventario
  ADD CONSTRAINT fk_inv_foto FOREIGN KEY (foto_id) REFERENCES imagen(imagen_id) ON DELETE SET NULL;

CREATE TABLE entradainventario (
  entrada_id INT AUTO_INCREMENT PRIMARY KEY,
  producto_id INT NOT NULL,
  foto_id INT NULL,
  cantidad INT NOT NULL,
  costo DECIMAL(14,2) NOT NULL DEFAULT 0,
  precio DECIMAL(14,2) NOT NULL DEFAULT 0,
  costod DECIMAL(12,2) NOT NULL DEFAULT 0,
  preciod DECIMAL(12,2) NOT NULL DEFAULT 0,
  tipo ENUM('compra','ajuste') NOT NULL DEFAULT 'compra',
  motivo_ajuste VARCHAR(150) NULL,
  fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  tasa_id INT NULL,
  CONSTRAINT fk_ent_prod FOREIGN KEY (producto_id) REFERENCES inventario(producto_id),
  CONSTRAINT fk_ent_tasa FOREIGN KEY (tasa_id) REFERENCES tasa(tasa_id) ON DELETE SET NULL,
  INDEX idx_ent_prod (producto_id),
  INDEX idx_ent_fecha (fecha)
) ENGINE=InnoDB;

CREATE TABLE salidainventario (
  salida_id INT AUTO_INCREMENT PRIMARY KEY,
  producto_id INT NOT NULL,
  entrada_id INT NULL,
  foto_id INT NULL,
  tipo ENUM('venta','ajuste') NOT NULL DEFAULT 'venta',
  motivo_ajuste VARCHAR(150) NULL,
  cantidad INT NOT NULL,
  fechaventa DATETIME NULL,
  fechacompra DATETIME NULL,
  precio DECIMAL(14,2) NOT NULL DEFAULT 0,
  preciod DECIMAL(12,2) NOT NULL DEFAULT 0,
  compra DECIMAL(14,2) NOT NULL DEFAULT 0,
  comprad DECIMAL(12,2) NOT NULL DEFAULT 0,
  tasa DECIMAL(12,4) NOT NULL DEFAULT 0,
  fecha DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_sal_prod FOREIGN KEY (producto_id) REFERENCES inventario(producto_id),
  INDEX idx_sal_prod (producto_id),
  INDEX idx_sal_fecha (fecha)
) ENGINE=InnoDB;

INSERT INTO categoria (nombre) VALUES ('General'), ('Filtros'), ('Aceites'), ('Frenos'), ('Baterías');
INSERT INTO marca (marca) VALUES ('Genérico'), ('Bosch'), ('Fram'), ('Mobil'), ('Willard');

SET FOREIGN_KEY_CHECKS = 1;
