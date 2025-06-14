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
        $db = \Config\Database::connect();

        if ($db->connID) {
            echo "Koneksi database berhasil!<br>";
            echo "Database: " . $db->getDatabase() . "<br>";

            // Test query
            $query = $db->query("SHOW TABLES");
            $tables = $query->getResult();

            echo "Tabel yang ada:<br>";
            foreach ($tables as $table) {
                foreach ($table as $tableName) {
                    echo "- " . $tableName . "<br>";
                }
            }
        } else {
            echo "Koneksi database gagal!";
        }
    }
}
