-- Database: lab_ci4
-- Membuat tabel kategori dan menambahkan relasi ke tabel artikel

USE lab_ci4;

-- 1. Membuat Tabel Kategori
CREATE TABLE kategori (
    id_kategori INT(11) AUTO_INCREMENT,
    nama_kategori VARCHAR(100) NOT NULL,
    slug_kategori VARCHAR(100),
    PRIMARY KEY (id_kategori)
);

-- 2. Insert data kategori sample
INSERT INTO kategori (nama_kategori, slug_kategori) VALUES
('Teknologi', 'teknologi'),
('Programming', 'programming'),
('Tutorial', 'tutorial'),
('Web Development', 'web-development'),
('Mobile Development', 'mobile-development');

-- 3. Mengubah Tabel Artikel - Tambah foreign key
ALTER TABLE artikel
ADD COLUMN id_kategori INT(11),
ADD CONSTRAINT fk_kategori_artikel
FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori);

-- 4. Update artikel existing dengan kategori (opsional)
UPDATE artikel SET id_kategori = 1 WHERE id = 1; -- Teknologi
UPDATE artikel SET id_kategori = 2 WHERE id = 2; -- Programming
UPDATE artikel SET id_kategori = 3 WHERE id = 3; -- Tutorial

-- 5. Lihat struktur tabel
DESCRIBE kategori;
DESCRIBE artikel;
