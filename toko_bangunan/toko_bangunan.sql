-- Database Toko Bangunan
-- Struktur mengikuti materi CRUD: produk + admin, dengan field id, nama, kategori,
-- deskripsi, harga, stok, gambar, created_at.

CREATE DATABASE IF NOT EXISTS toko_bangunan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE toko_bangunan;

SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
START TRANSACTION;
SET time_zone = '+00:00';

DROP TABLE IF EXISTS produk;
DROP TABLE IF EXISTS admin;

CREATE TABLE admin (
  id INT NOT NULL AUTO_INCREMENT,
  nama VARCHAR(100) NOT NULL,
  username VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE produk (
  id INT NOT NULL AUTO_INCREMENT,
  nama VARCHAR(100) NOT NULL,
  kategori VARCHAR(50) NOT NULL,
  deskripsi TEXT NOT NULL,
  harga DECIMAL(12,2) NOT NULL,
  stok INT NOT NULL DEFAULT 0,
  gambar VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO admin (nama, username, password) VALUES
('Administrator Toko Bangunan', 'admin', '$2y$10$98vbxh4xT65X0Rnc9/L33eWkPdxz8VL4hbvd338D7IILqDOqYj4e6');

INSERT INTO produk (nama, kategori, deskripsi, harga, stok, gambar) VALUES
('Semen Premium 50kg', 'Semen', 'Semen serbaguna untuk pekerjaan konstruksi, pemasangan bata, plesteran, dan pengecoran.', 68000.00, 35, 'semen.jpg'),
('Cat Tembok Eksterior 5L', 'Cat', 'Cat tembok untuk area dalam dan luar ruangan dengan hasil akhir rapi dan daya tutup baik.', 185000.00, 18, 'cat.jpg'),
('Bor Tangan 13mm', 'Perkakas', 'Bor tangan untuk pekerjaan rumah dan proyek ringan, cocok untuk berbagai kebutuhan pengeboran.', 325000.00, 12, 'bor.jpg');

COMMIT;
