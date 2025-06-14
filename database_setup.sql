-- Membuat Database
CREATE DATABASE IF NOT EXISTS lab_ci4;
USE lab_ci4;

-- Membuat Tabel Artikel
CREATE TABLE IF NOT EXISTS artikel (
    id INT(11) AUTO_INCREMENT,
    judul VARCHAR(200) NOT NULL,
    isi TEXT,
    gambar VARCHAR(200),
    status TINYINT(1) DEFAULT 0,
    slug VARCHAR(200),
    PRIMARY KEY(id)
);

-- Insert Data Sample
INSERT INTO artikel (judul, isi, gambar, status, slug) VALUES
('Artikel Pertama', 'Ini adalah isi dari artikel pertama. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'artikel1.jpg', 1, 'artikel-pertama'),
('Artikel Kedua', 'Ini adalah isi dari artikel kedua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'artikel2.jpg', 1, 'artikel-kedua'),
('Artikel Ketiga', 'Ini adalah isi dari artikel ketiga. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.', 'artikel3.jpg', 0, 'artikel-ketiga'),
('Tutorial CodeIgniter', 'Tutorial lengkap tentang CodeIgniter 4. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'tutorial-ci.jpg', 1, 'tutorial-codeigniter'),
('Belajar Database', 'Panduan belajar database MySQL untuk pemula. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.', 'database.jpg', 1, 'belajar-database');

-- Menampilkan data yang sudah diinsert
SELECT * FROM artikel;
