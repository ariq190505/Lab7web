<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function about()
    {
        return view('about', [
            'title' => 'Halaman Abot',
            'content' => 'Ini adalah halaman abaut yang menjelaskan tentang isi halaman ini.'
        ]);
    }

    public function contact()
    {
        return view('contact', [
            'title' => 'Halaman Kontak',
            'content' => 'Ini adalah halaman kontak untuk menghubungi kami. Silakan isi form di bawah ini untuk mengirim pesan kepada kami.'
        ]);
    }

    public function faqs()
    {
        return view('faqs', [
            'title' => 'Frequently Asked Questions',
            'content' => 'Berikut adalah pertanyaan-pertanyaan yang sering diajukan beserta jawabannya.'
        ]);
    }

    public function tos()
    {
        echo "ini halaman Term of Services";
    }

    public function artikel()
    {
        return view('artikel', [
            'title' => 'Daftar Artikel',
            'content' => 'Berikut adalah kumpulan artikel-artikel terbaru tentang pengembangan web dan CodeIgniter.'
        ]);
    }

    public function test()
    {
        echo "Test halaman - Controller Page berfungsi!";
    }

    public function testdb()
    {
        echo "<h1>Test Koneksi Database</h1>";
        echo "<hr>";

        // Tampilkan konfigurasi database
        echo "<h3>Konfigurasi Database:</h3>";
        echo "<ul>";
        echo "<li><strong>Host:</strong> " . env('database.default.hostname', 'localhost') . "</li>";
        echo "<li><strong>Database:</strong> " . env('database.default.database', 'lab_ci4') . "</li>";
        echo "<li><strong>Username:</strong> " . env('database.default.username', 'root') . "</li>";
        echo "<li><strong>Password:</strong> " . (env('database.default.password') ? '[SET]' : '[EMPTY]') . "</li>";
        echo "<li><strong>Port:</strong> " . env('database.default.port', '3306') . "</li>";
        echo "</ul>";
        echo "<hr>";

        try {
            // Test koneksi ke MySQL server dulu (tanpa database spesifik)
            echo "<h3>Test Koneksi MySQL Server:</h3>";

            $config = [
                'hostname' => env('database.default.hostname', 'localhost'),
                'username' => env('database.default.username', 'root'),
                'password' => env('database.default.password', ''),
                'port'     => env('database.default.port', 3306),
                'DBDriver' => 'MySQLi'
            ];

            $testDB = \Config\Database::connect($config);

            if ($testDB->connID) {
                echo "<p style='color: green;'>✅ Koneksi ke MySQL server berhasil!</p>";

                // Cek apakah database lab_ci4 ada
                $query = $testDB->query("SHOW DATABASES LIKE 'lab_ci4'");
                $result = $query->getResult();

                if (count($result) > 0) {
                    echo "<p style='color: green;'>✅ Database 'lab_ci4' ditemukan!</p>";
                } else {
                    echo "<p style='color: orange;'>⚠️ Database 'lab_ci4' tidak ditemukan!</p>";
                    echo "<p><strong>Solusi:</strong></p>";
                    echo "<ol>";
                    echo "<li>Buka phpMyAdmin: <a href='http://localhost/phpmyadmin' target='_blank'>http://localhost/phpmyadmin</a></li>";
                    echo "<li>Buat database baru dengan nama: <code>lab_ci4</code></li>";
                    echo "<li>Atau jalankan query: <code>CREATE DATABASE lab_ci4;</code></li>";
                    echo "</ol>";
                    echo "<hr>";
                }

                // Test koneksi ke database spesifik
                echo "<h3>Test Koneksi ke Database lab_ci4:</h3>";
                $db = \Config\Database::connect();

                if ($db->connID) {
                echo "<p style='color: green;'>✅ Koneksi database berhasil!</p>";
                echo "<p><strong>Database:</strong> " . $db->getDatabase() . "</p>";
                echo "<p><strong>Host:</strong> " . $db->hostname . "</p>";
                echo "<p><strong>Username:</strong> " . $db->username . "</p>";

                // Test query untuk melihat tabel
                try {
                    $query = $db->query("SHOW TABLES");
                    $tables = $query->getResult();

                    echo "<h3>Tabel yang ada:</h3>";
                    if (count($tables) > 0) {
                        echo "<ul>";
                        foreach ($tables as $table) {
                            foreach ($table as $tableName) {
                                echo "<li>" . $tableName . "</li>";
                            }
                        }
                        echo "</ul>";

                        // Test query artikel jika tabel artikel ada
                        $artikelExists = false;
                        foreach ($tables as $table) {
                            foreach ($table as $tableName) {
                                if ($tableName == 'artikel') {
                                    $artikelExists = true;
                                    break 2;
                                }
                            }
                        }

                        if ($artikelExists) {
                            $artikelQuery = $db->query("SELECT COUNT(*) as total FROM artikel");
                            $result = $artikelQuery->getRow();
                            echo "<p><strong>Jumlah artikel:</strong> " . $result->total . "</p>";
                        }
                    } else {
                        echo "<p>Tidak ada tabel dalam database.</p>";
                    }
                } catch (\Exception $e) {
                    echo "<p style='color: orange;'>⚠️ Error saat mengakses tabel: " . $e->getMessage() . "</p>";
                }

                } else {
                    echo "<p style='color: red;'>❌ Koneksi ke database lab_ci4 gagal!</p>";
                }
            } else {
                echo "<p style='color: red;'>❌ Koneksi ke MySQL server gagal!</p>";
            }
        } catch (\Exception $e) {
            echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
            echo "<p>Pastikan:</p>";
            echo "<ul>";
            echo "<li>XAMPP MySQL sudah running</li>";
            echo "<li>Database 'lab_ci4' sudah dibuat</li>";
            echo "<li>Konfigurasi di file .env sudah benar</li>";
            echo "</ul>";
        }

        echo "<br><a href='" . base_url() . "'>← Kembali ke Home</a>";
    }

    public function createdb()
    {
        echo "<h1>Setup Database Otomatis</h1>";
        echo "<hr>";

        try {
            // Koneksi ke MySQL server tanpa database spesifik
            $config = [
                'hostname' => env('database.default.hostname', 'localhost'),
                'username' => env('database.default.username', 'root'),
                'password' => env('database.default.password', ''),
                'port'     => env('database.default.port', 3306),
                'DBDriver' => 'MySQLi'
            ];

            $db = \Config\Database::connect($config);

            if ($db->connID) {
                echo "<p style='color: green;'>✅ Koneksi ke MySQL server berhasil!</p>";

                // Buat database lab_ci4
                echo "<h3>Membuat Database:</h3>";
                $db->query("CREATE DATABASE IF NOT EXISTS lab_ci4");
                echo "<p style='color: green;'>✅ Database 'lab_ci4' berhasil dibuat!</p>";

                // Gunakan database lab_ci4
                $db->query("USE lab_ci4");

                // Buat tabel artikel
                echo "<h3>Membuat Tabel Artikel:</h3>";
                $createTable = "
                CREATE TABLE IF NOT EXISTS artikel (
                    id INT(11) AUTO_INCREMENT,
                    judul VARCHAR(200) NOT NULL,
                    isi TEXT,
                    gambar VARCHAR(200),
                    status TINYINT(1) DEFAULT 0,
                    slug VARCHAR(200),
                    PRIMARY KEY(id)
                )";

                $db->query($createTable);
                echo "<p style='color: green;'>✅ Tabel 'artikel' berhasil dibuat!</p>";

                // Insert data sample
                echo "<h3>Menambahkan Data Sample:</h3>";
                $insertData = "
                INSERT IGNORE INTO artikel (id, judul, isi, gambar, status, slug) VALUES
                (1, 'Artikel Pertama', 'Ini adalah isi dari artikel pertama. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'artikel1.jpg', 1, 'artikel-pertama'),
                (2, 'Artikel Kedua', 'Ini adalah isi dari artikel kedua. Ut enim ad minim veniam, quis nostrud exercitation.', 'artikel2.jpg', 1, 'artikel-kedua'),
                (3, 'Tutorial CodeIgniter', 'Tutorial lengkap tentang CodeIgniter 4. Excepteur sint occaecat cupidatat non proident.', 'tutorial-ci.jpg', 1, 'tutorial-codeigniter')
                ";

                $db->query($insertData);
                echo "<p style='color: green;'>✅ Data sample berhasil ditambahkan!</p>";

                echo "<hr>";
                echo "<p><strong>Setup database selesai!</strong></p>";
                echo "<p>Sekarang Anda bisa:</p>";
                echo "<ul>";
                echo "<li><a href='" . base_url('/testdb') . "'>Test koneksi database</a></li>";
                echo "<li><a href='" . base_url('/artikel') . "'>Lihat daftar artikel</a></li>";
                echo "</ul>";

            } else {
                echo "<p style='color: red;'>❌ Koneksi ke MySQL server gagal!</p>";
                echo "<p>Pastikan XAMPP MySQL sudah running.</p>";
            }

        } catch (\Exception $e) {
            echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
        }

        echo "<br><a href='" . base_url() . "'>← Kembali ke Home</a>";
    }
}
