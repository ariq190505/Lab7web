<?php

namespace App\Cells;

use CodeIgniter\View\Cell;
use App\Models\ArtikelModel;

class ArtikelTerkini extends Cell
{
    public function render($kategori = null)
    {
        $model = new ArtikelModel();

        $query = $model->where('status', 1);

        if ($kategori) {
            $query = $query->where('kategori', $kategori);
        }

        $artikel = $query->orderBy('created_at', 'DESC')->limit(5)->findAll();

        return view('components/artikel_terkini', [
            'artikel' => $artikel,
            'kategori' => $kategori
        ]);
    }
}
