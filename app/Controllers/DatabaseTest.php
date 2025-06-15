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
}
