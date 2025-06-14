<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKategoriToArtikel extends Migration
{
    public function up()
    {
        $this->forge->addColumn('artikel', [
            'kategori' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'status'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('artikel', 'kategori');
    }
}
