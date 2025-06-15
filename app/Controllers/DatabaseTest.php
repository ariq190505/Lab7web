<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;

class DatabaseTest extends BaseController
{
    public function index()
    {
        echo "<h2>Database Connection Test</h2>";
        
        try {
            $db = \Config\Database::connect();
            echo "<p>✅ Database connection: SUCCESS</p>";
            
            // Test tabel artikel
            if ($db->tableExists('artikel')) {
                echo "<p>✅ Tabel 'artikel': EXISTS</p>";
                $artikelCount = $db->table('artikel')->countAll();
                echo "<p>📊 Jumlah artikel: $artikelCount</p>";
            } else {
                echo "<p>❌ Tabel 'artikel': NOT EXISTS</p>";
            }
            
            // Test tabel kategori
            if ($db->tableExists('kategori')) {
                echo "<p>✅ Tabel 'kategori': EXISTS</p>";
                $kategoriCount = $db->table('kategori')->countAll();
                echo "<p>📊 Jumlah kategori: $kategoriCount</p>";
            } else {
                echo "<p>❌ Tabel 'kategori': NOT EXISTS</p>";
                echo "<p>🔧 Silakan jalankan SQL dari file database_kategori.sql</p>";
            }
            
            // Test method getArtikelDenganKategori
            echo "<hr><h3>Test Method getArtikelDenganKategori()</h3>";
            $artikelModel = new ArtikelModel();
            
            try {
                $artikel = $artikelModel->getArtikelDenganKategori();
                echo "<p>✅ Method getArtikelDenganKategori(): SUCCESS</p>";
                echo "<p>📊 Data ditemukan: " . count($artikel) . " artikel</p>";
                
                if (!empty($artikel)) {
                    echo "<h4>Sample Data:</h4>";
                    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
                    echo "<tr><th>ID</th><th>Judul</th><th>Kategori</th><th>Status</th></tr>";
                    foreach (array_slice($artikel, 0, 5) as $row) {
                        echo "<tr>";
                        echo "<td>" . ($row['id'] ?? 'N/A') . "</td>";
                        echo "<td>" . ($row['judul'] ?? 'N/A') . "</td>";
                        echo "<td>" . ($row['nama_kategori'] ?? 'No Category') . "</td>";
                        echo "<td>" . ($row['status'] ? 'Published' : 'Draft') . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
            } catch (\Exception $e) {
                echo "<p>❌ Method getArtikelDenganKategori(): ERROR</p>";
                echo "<p>Error: " . $e->getMessage() . "</p>";
            }
            
        } catch (\Exception $e) {
            echo "<p>❌ Database connection: FAILED</p>";
            echo "<p>Error: " . $e->getMessage() . "</p>";
        }
        
        echo "<hr>";
        echo "<p><a href='" . base_url('/admin/artikel') . "'>← Back to Admin Artikel</a></p>";
        echo "<p><a href='" . base_url('/') . "'>← Back to Home</a></p>";
    }
    
    public function createTables()
    {
        echo "<h2>Create Database Tables</h2>";
        
        try {
            $db = \Config\Database::connect();
            
            // Create kategori table
            $sql = "
            CREATE TABLE IF NOT EXISTS kategori (
                id_kategori INT(11) AUTO_INCREMENT,
                nama_kategori VARCHAR(100) NOT NULL,
                slug_kategori VARCHAR(100),
                PRIMARY KEY (id_kategori)
            )";
            
            $db->query($sql);
            echo "<p>✅ Tabel kategori berhasil dibuat</p>";
            
            // Insert sample data
            $kategoriData = [
                ['nama_kategori' => 'Teknologi', 'slug_kategori' => 'teknologi'],
                ['nama_kategori' => 'Programming', 'slug_kategori' => 'programming'],
                ['nama_kategori' => 'Tutorial', 'slug_kategori' => 'tutorial'],
                ['nama_kategori' => 'Web Development', 'slug_kategori' => 'web-development'],
                ['nama_kategori' => 'Mobile Development', 'slug_kategori' => 'mobile-development']
            ];
            
            $builder = $db->table('kategori');
            foreach ($kategoriData as $data) {
                $existing = $builder->where('slug_kategori', $data['slug_kategori'])->get()->getRow();
                if (!$existing) {
                    $builder->insert($data);
                }
            }
            echo "<p>✅ Data kategori sample berhasil diinsert</p>";
            
            // Add foreign key to artikel table
            try {
                $sql = "ALTER TABLE artikel ADD COLUMN id_kategori INT(11)";
                $db->query($sql);
                echo "<p>✅ Kolom id_kategori berhasil ditambahkan ke tabel artikel</p>";
            } catch (\Exception $e) {
                echo "<p>ℹ️ Kolom id_kategori mungkin sudah ada: " . $e->getMessage() . "</p>";
            }
            
            echo "<p><a href='" . base_url('/databasetest') . "'>Test Database Connection</a></p>";

        } catch (\Exception $e) {
            echo "<p>❌ Error: " . $e->getMessage() . "</p>";
        }
    }

    public function addSampleData()
    {
        echo "<h2>Add Sample Data</h2>";

        try {
            $db = \Config\Database::connect();

            // Add sample articles with categories
            $sampleArticles = [
                [
                    'judul' => 'Pengenalan Teknologi AI',
                    'isi' => 'Artificial Intelligence (AI) adalah teknologi yang memungkinkan mesin untuk belajar dan membuat keputusan seperti manusia. Teknologi ini berkembang pesat dan mulai diterapkan di berbagai bidang.',
                    'slug' => 'pengenalan-teknologi-ai',
                    'id_kategori' => 1, // Teknologi
                    'status' => 1
                ],
                [
                    'judul' => 'Belajar Programming Python',
                    'isi' => 'Python adalah bahasa pemrograman yang mudah dipelajari dan sangat populer. Artikel ini akan membahas dasar-dasar programming dengan Python untuk pemula.',
                    'slug' => 'belajar-programming-python',
                    'id_kategori' => 2, // Programming
                    'status' => 1
                ],
                [
                    'judul' => 'Tutorial Web Development',
                    'isi' => 'Web development adalah proses pembuatan website dan aplikasi web. Tutorial ini akan membahas HTML, CSS, dan JavaScript untuk membuat website yang menarik.',
                    'slug' => 'tutorial-web-development',
                    'id_kategori' => 4, // Web Development
                    'status' => 1
                ],
                [
                    'judul' => 'Teknologi Blockchain Terbaru',
                    'isi' => 'Blockchain adalah teknologi yang mendasari cryptocurrency. Artikel ini membahas perkembangan terbaru teknologi blockchain dan aplikasinya.',
                    'slug' => 'teknologi-blockchain-terbaru',
                    'id_kategori' => 1, // Teknologi
                    'status' => 1
                ],
                [
                    'judul' => 'Tutorial CodeIgniter 4',
                    'isi' => 'CodeIgniter 4 adalah framework PHP yang powerful dan mudah digunakan. Tutorial ini akan membahas cara membuat aplikasi web dengan CodeIgniter 4.',
                    'slug' => 'tutorial-codeigniter-4',
                    'id_kategori' => 3, // Tutorial
                    'status' => 1
                ]
            ];

            $builder = $db->table('artikel');
            foreach ($sampleArticles as $article) {
                // Check if article already exists
                $existing = $builder->where('slug', $article['slug'])->get()->getRow();
                if (!$existing) {
                    $article['created_at'] = date('Y-m-d H:i:s');
                    $article['updated_at'] = date('Y-m-d H:i:s');
                    $builder->insert($article);
                    echo "<p>✅ Added: " . $article['judul'] . "</p>";
                } else {
                    echo "<p>ℹ️ Already exists: " . $article['judul'] . "</p>";
                }
            }

            echo "<hr>";
            echo "<p><strong>Sample data berhasil ditambahkan!</strong></p>";
            echo "<p><a href='" . base_url('/databasetest') . "'>Test Database</a></p>";
            echo "<p><a href='" . base_url('/artikel') . "'>Lihat Artikel</a></p>";
            echo "<p><a href='" . base_url('/kategori/teknologi') . "'>Test Kategori Teknologi</a></p>";

        } catch (\Exception $e) {
            echo "<p>❌ Error: " . $e->getMessage() . "</p>";
        }
    }
}
