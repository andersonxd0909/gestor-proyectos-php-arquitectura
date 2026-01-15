-- Estructura para el proyecto ARCHIVO.ARCH
CREATE DATABASE IF NOT EXISTS archivo_db;
USE archivo_db;

CREATE TABLE IF NOT EXISTS proyectos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    categoria VARCHAR(100) NOT NULL,
    imagen_url VARCHAR(255) NOT NULL,
    url_externa VARCHAR(255) DEFAULT NULL
);