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

        try {
            $db = \Config\Database::connect();

            // Test koneksi
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
                echo "<p style='color: red;'>❌ Koneksi database gagal!</p>";
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
}
