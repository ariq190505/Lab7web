<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['nama_kategori', 'slug_kategori'];

    // Timestamps (jika diperlukan)
    protected $useTimestamps = false;
    
    // Validation rules
    protected $validationRules = [
        'nama_kategori' => 'required|min_length[3]|max_length[100]',
        'slug_kategori' => 'required|min_length[3]|max_length[100]'
    ];
    
    protected $validationMessages = [
        'nama_kategori' => [
            'required' => 'Nama kategori harus diisi',
            'min_length' => 'Nama kategori minimal 3 karakter',
            'max_length' => 'Nama kategori maksimal 100 karakter'
        ],
        'slug_kategori' => [
            'required' => 'Slug kategori harus diisi',
            'min_length' => 'Slug kategori minimal 3 karakter',
            'max_length' => 'Slug kategori maksimal 100 karakter'
        ]
    ];

    /**
     * Get all categories for dropdown
     */
    public function getKategoriDropdown()
    {
        $categories = $this->findAll();
        $dropdown = ['' => 'Pilih Kategori'];
        
        foreach ($categories as $category) {
            $dropdown[$category['id_kategori']] = $category['nama_kategori'];
        }
        
        return $dropdown;
    }

    /**
     * Get category by slug
     */
    public function getBySlug($slug)
    {
        return $this->where('slug_kategori', $slug)->first();
    }

    /**
     * Generate slug from nama kategori
     */
    public function generateSlug($nama)
    {
        return url_title($nama, '-', true);
    }
}
