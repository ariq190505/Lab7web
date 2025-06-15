<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Artikel extends BaseController
{
    public function index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        $kategoriModel = new KategoriModel();

        // Get search keyword
        $q = $this->request->getVar('q') ?? '';

        // Get category filter
        $kategori_id = $this->request->getVar('kategori_id') ?? '';

        // Building the query for public articles
        $builder = $model->table('artikel')
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left')
            ->where('artikel.status', 1); // Only published articles

        // Apply search filter if keyword is provided
        if ($q != '') {
            $builder->like('artikel.judul', $q);
        }

        // Apply category filter if category_id is provided
        if ($kategori_id != '') {
            $builder->where('artikel.id_kategori', $kategori_id);
        }

        $builder->orderBy('artikel.created_at', 'DESC');
        $artikel = $builder->get()->getResultArray();

        // Get all categories for the filter dropdown
        $kategori = $kategoriModel->findAll();

        return view('artikel/index', [
            'title' => $title,
            'artikel' => $artikel,
            'kategori' => $kategori,
            'q' => $q,
            'kategori_id' => $kategori_id
        ]);
    }



    public function admin_index()
    {
        $title = 'Daftar Artikel (Admin)';
        $model = new ArtikelModel();

        // Get search keyword
        $q = $this->request->getVar('q') ?? '';

        // Get category filter
        $kategori_id = $this->request->getVar('kategori_id') ?? '';

        $data = [
            'title' => $title,
            'q' => $q,
            'kategori_id' => $kategori_id,
        ];

        // Building the query
        $builder = $model->table('artikel')
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left');

        // Apply search filter if keyword is provided
        if ($q != '') {
            $builder->like('artikel.judul', $q);
        }

        // Apply category filter if category_id is provided
        if ($kategori_id != '') {
            $builder->where('artikel.id_kategori', $kategori_id);
        }

        // Apply pagination
        $data['artikel'] = $builder->paginate(10);
        $data['pager'] = $model->pager;

        // Fetch all categories for the filter dropdown
        $kategoriModel = new KategoriModel();
        $data['kategori'] = $kategoriModel->findAll();

        return view('artikel/admin_index', $data);
    }

    public function add()
    {
        $title = "Tambah Artikel";

        // Validation and form processing
        if ($this->request->getMethod() == 'post' && $this->validate([
            'judul' => 'required|min_length[3]|max_length[200]',
            'isi' => 'required|min_length[10]',
            'id_kategori' => 'required|integer' // Ensure id_kategori is required and an integer
        ])) {
            $model = new ArtikelModel();
            $model->insert([
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'slug' => url_title($this->request->getPost('judul')),
                'id_kategori' => $this->request->getPost('id_kategori'),
                'status' => $this->request->getPost('status') ?? 0
            ]);

            session()->setFlashdata('success', 'Artikel berhasil ditambahkan!');
            return redirect()->to('/admin/artikel');
        } else {
            // Handle validation errors
            if ($this->request->getMethod() == 'post') {
                $errors = $this->validator->getErrors();
                $errorMessage = implode(' ', $errors);
                session()->setFlashdata('error', $errorMessage);
            }

            // Fetch categories for the form
            $kategoriModel = new KategoriModel();
            $data['kategori'] = $kategoriModel->findAll();
            $data['title'] = $title;

            return view('artikel/form_add', $data);
        }
    }

    public function edit($id)
    {
        $artikel = new ArtikelModel();

        // Cek apakah form sudah di-submit
        if ($this->request->getMethod() === 'post') {
            // validasi data.
            $validation = \Config\Services::validation();
            $validation->setRules([
                'judul' => 'required|min_length[3]|max_length[200]',
                'isi' => 'required|min_length[10]',
                'id_kategori' => 'required|integer'
            ]);
            $isDataValid = $validation->withRequest($this->request)->run();

            if ($isDataValid) {
                $artikel->update($id, [
                    'judul' => $this->request->getPost('judul'),
                    'isi' => $this->request->getPost('isi'),
                    'slug' => url_title($this->request->getPost('judul')),
                    'id_kategori' => $this->request->getPost('id_kategori'),
                    'status' => $this->request->getPost('status') ?? 0,
                ]);

                session()->setFlashdata('success', 'Artikel berhasil diubah!');
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

        // ambil data lama
        $artikel_data = $artikel->where('id', $id)->first();

        if (!$artikel_data) {
            session()->setFlashdata('error', 'Artikel tidak ditemukan!');
            return redirect('admin/artikel');
        }

        // Fetch categories for the form
        $kategoriModel = new KategoriModel();
        $kategori = $kategoriModel->findAll();

        $title = "Edit Artikel";
        return view('artikel/form_edit', [
            'title' => $title,
            'artikel' => $artikel_data,
            'kategori' => $kategori
        ]);
    }

    public function delete($id)
    {
        $model = new ArtikelModel();

        // Cek apakah artikel ada
        $data = $model->find($id);
        if (!$data) {
            session()->setFlashdata('error', 'Artikel tidak ditemukan!');
            return redirect()->to('/admin/artikel');
        }

        $model->delete($id);
        session()->setFlashdata('success', 'Artikel berhasil dihapus!');
        return redirect()->to('/admin/artikel');
    }

    public function view($slug)
    {
        $model = new ArtikelModel();

        // Get artikel by slug with kategori information
        $artikel = $model->getBySlugWithKategori($slug);

        if (empty($artikel)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the article.');
        }

        $data['artikel'] = $artikel;
        $data['title'] = $artikel['judul'];

        return view('artikel/detail', $data);
    }
}
