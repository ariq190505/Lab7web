<?php

namespace App\Cells;

use CodeIgniter\View\Cell;
use App\Models\ArtikelModel;

class ArtikelTerkini extends Cell
{
    public function show($kategori = null)
    {
        try {
            $model = new ArtikelModel();
            $query = $model->where('status', 1);

            if ($kategori) {
                $query = $query->where('kategori', $kategori);
            }

            $artikel = $query->orderBy('created_at', 'DESC')->limit(5)->findAll();
        } catch (\Exception $e) {
            // Fallback jika database error
            $artikel = [
                [
                    'id' => 1,
                    'judul' => 'Artikel Demo 1',
                    'slug' => 'artikel-demo-1',
                    'kategori' => 'teknologi'
                ],
                [
                    'id' => 2,
                    'judul' => 'Artikel Demo 2',
                    'slug' => 'artikel-demo-2',
                    'kategori' => 'programming'
                ],
                [
                    'id' => 3,
                    'judul' => 'Artikel Demo 3',
                    'slug' => 'artikel-demo-3',
                    'kategori' => 'tutorial'
                ]
            ];
        }

        return view('components/artikel_terkini', [
            'artikel' => $artikel,
            'kategori' => $kategori
        ]);
    }
}
