-- Base de datos y tabla para Detector de Gases IoT
-- Importar desde phpMyAdmin o: mysql -u root < database.sql

CREATE DATABASE IF NOT EXISTS detector_gases
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE detector_gases;

CREATE TABLE IF NOT EXISTS lecturas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  valor_gas FLOAT NOT NULL,
  estado VARCHAR(30) NOT NULL,
  fecha_hora DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
