<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTimestampsToArtikel extends Migration
{
    public function up()
    {
        $this->forge->addColumn('artikel', [
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'slug'
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'created_at'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('artikel', ['created_at', 'updated_at']);
    }
}
