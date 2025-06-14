<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Artikel extends BaseController
{
    public function index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        $artikel = $model->findAll();
        return view('artikel/index', compact('artikel', 'title'));
    }

    public function view($slug)
    {
        $model = new ArtikelModel();
        $artikel = $model->where([
            'slug' => $slug
        ])->first();

        // Menampilkan error apabila data tidak ada.
        if (!$artikel) {
            throw PageNotFoundException::forPageNotFound();
        }

        $title = $artikel['judul'];
        return view('artikel/detail', compact('artikel', 'title'));
    }

    public function admin_index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        $artikel = $model->findAll();
        return view('artikel/admin_index', compact('artikel', 'title'));
    }

    public function add()
    {
        // TODO: Implement add functionality
        echo "<h1>Tambah Artikel</h1>";
        echo "<p>Fitur ini akan diimplementasikan selanjutnya.</p>";
        echo "<a href='" . base_url('/admin/artikel') . "'>← Kembali ke Admin</a>";
    }

    public function edit($id)
    {
        // TODO: Implement edit functionality
        echo "<h1>Edit Artikel ID: $id</h1>";
        echo "<p>Fitur ini akan diimplementasikan selanjutnya.</p>";
        echo "<a href='" . base_url('/admin/artikel') . "'>← Kembali ke Admin</a>";
    }

    public function delete($id)
    {
        // TODO: Implement delete functionality
        echo "<h1>Hapus Artikel ID: $id</h1>";
        echo "<p>Fitur ini akan diimplementasikan selanjutnya.</p>";
        echo "<a href='" . base_url('/admin/artikel') . "'>← Kembali ke Admin</a>";
    }
}
