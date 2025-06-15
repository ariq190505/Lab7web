<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use App\Models\ArtikelModel;

class Kategori extends BaseController
{
    protected $kategoriModel;
    protected $artikelModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
        $this->artikelModel = new ArtikelModel();
    }

    /**
     * Admin - Daftar Kategori
     */
    public function admin_index()
    {
        $title = 'Kelola Kategori';
        $kategori = $this->kategoriModel->findAll();
        
        return view('kategori/admin_index', compact('title', 'kategori'));
    }

    /**
     * Admin - Form Tambah Kategori
     */
    public function add()
    {
        $title = 'Tambah Kategori';

        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'nama_kategori' => 'required|min_length[3]|max_length[100]'
            ]);

            if ($validation->withRequest($this->request)->run()) {
                $nama = $this->request->getPost('nama_kategori');
                $slug = $this->kategoriModel->generateSlug($nama);

                $this->kategoriModel->insert([
                    'nama_kategori' => $nama,
                    'slug_kategori' => $slug
                ]);

                session()->setFlashdata('success', 'Kategori berhasil ditambahkan!');
                return redirect('admin/kategori');
            } else {
                $errors = $validation->getErrors();
                $errorMessage = implode(' ', $errors);
                session()->setFlashdata('error', $errorMessage);
            }
        }

        return view('kategori/form_add', compact('title'));
    }

    /**
     * Admin - Form Edit Kategori
     */
    public function edit($id)
    {
        $title = 'Edit Kategori';
        $data = $this->kategoriModel->find($id);

        if (!$data) {
            session()->setFlashdata('error', 'Kategori tidak ditemukan!');
            return redirect('admin/kategori');
        }

        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'nama_kategori' => 'required|min_length[3]|max_length[100]'
            ]);

            if ($validation->withRequest($this->request)->run()) {
                $nama = $this->request->getPost('nama_kategori');
                $slug = $this->kategoriModel->generateSlug($nama);

                $this->kategoriModel->update($id, [
                    'nama_kategori' => $nama,
                    'slug_kategori' => $slug
                ]);

                session()->setFlashdata('success', 'Kategori berhasil diubah!');
                return redirect('admin/kategori');
            } else {
                $errors = $validation->getErrors();
                $errorMessage = implode(' ', $errors);
                session()->setFlashdata('error', $errorMessage);
            }
        }

        return view('kategori/form_edit', compact('title', 'data'));
    }

    /**
     * Admin - Hapus Kategori
     */
    public function delete($id)
    {
        $data = $this->kategoriModel->find($id);
        
        if (!$data) {
            session()->setFlashdata('error', 'Kategori tidak ditemukan!');
            return redirect('admin/kategori');
        }

        // Cek apakah kategori masih digunakan artikel
        $artikelCount = $this->artikelModel->where('id_kategori', $id)->countAllResults();
        
        if ($artikelCount > 0) {
            session()->setFlashdata('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh ' . $artikelCount . ' artikel!');
            return redirect('admin/kategori');
        }

        $this->kategoriModel->delete($id);
        session()->setFlashdata('success', 'Kategori berhasil dihapus!');
        return redirect('admin/kategori');
    }

    /**
     * Public - Artikel by Kategori
     */
    public function view($slug)
    {
        $kategori = $this->kategoriModel->getBySlug($slug);
        
        if (!$kategori) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        $artikel = $this->artikelModel->getByKategori($kategori['id_kategori'], 1);
        $title = 'Kategori: ' . $kategori['nama_kategori'];

        return view('kategori/view', compact('title', 'kategori', 'artikel'));
    }
}
