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
        $title = "Tambah Artikel";

        // Cek apakah form sudah di-submit
        if ($this->request->getMethod() === 'post') {
            // validasi data.
            $validation = \Config\Services::validation();
            $validation->setRules([
                'judul' => 'required|min_length[3]|max_length[200]',
                'isi' => 'required|min_length[10]'
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $artikel = new ArtikelModel();
                $artikel->insert([
                    'judul' => $this->request->getPost('judul'),
                    'isi' => $this->request->getPost('isi'),
                    'slug' => url_title($this->request->getPost('judul')),
                    'status' => 0 // Default status draft
                ]);

                session()->setFlashdata('success', 'Artikel berhasil ditambahkan!');
                return redirect('admin/artikel');
            } else {
                $errors = $validation->getErrors();
                $errorMessage = '';
                foreach ($errors as $error) {
                    $errorMessage .= $error . ' ';
                }
                session()->setFlashdata('error', trim($errorMessage));
            }
        }

        return view('artikel/form_add', compact('title'));
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
