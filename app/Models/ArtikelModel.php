<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['judul', 'isi', 'status', 'slug', 'gambar', 'id_kategori'];

    // Timestamps
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    /**
     * Method untuk mengambil data artikel beserta nama kategorinya menggunakan join
     * Sesuai spesifikasi Modul 7
     */
    public function getArtikelDenganKategori()
    {
        return $this->db->table('artikel')
            ->select('artikel.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id_kategori = artikel.id_kategori')
            ->get()
            ->getResultArray();
    }

    /**
     * Get artikel with kategori (JOIN)
     */
    public function getArtikelWithKategori($id = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('artikel.*, kategori.nama_kategori, kategori.slug_kategori');
        $builder->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left');

        if ($id !== null) {
            $builder->where('artikel.id', $id);
            return $builder->get()->getRowArray();
        }

        return $builder->get()->getResultArray();
    }

    /**
     * Get artikel by kategori
     */
    public function getByKategori($id_kategori, $status = 1)
    {
        return $this->where('id_kategori', $id_kategori)
                   ->where('status', $status)
                   ->findAll();
    }

    /**
     * Get artikel by slug with kategori
     */
    public function getBySlugWithKategori($slug)
    {
        $builder = $this->db->table($this->table);
        $builder->select('artikel.*, kategori.nama_kategori, kategori.slug_kategori');
        $builder->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left');
        $builder->where('artikel.slug', $slug);

        return $builder->get()->getRowArray();
    }

    /**
     * Get published artikel with kategori
     */
    public function getPublishedWithKategori()
    {
        $builder = $this->db->table($this->table);
        $builder->select('artikel.*, kategori.nama_kategori, kategori.slug_kategori');
        $builder->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left');
        $builder->where('artikel.status', 1);
        $builder->orderBy('artikel.created_at', 'DESC');

        return $builder->get()->getResultArray();
    }
}
