<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateLevelColumnInMateriTable extends Migration
{
    public function up()
    {
        // Mengubah kolom level dari ENUM menjadi INT
        $this->forge->modifyColumn('materi', [
            'level' => [
                'type' => 'INT',
                'constraint' => 1,
                'default' => 1,  // Defaultnya 1
                'unsigned' => true
            ]
        ]);
    }

    public function down()
    {
        // Jika ingin membalikkan perubahan (mengubah kembali ke ENUM), lakukan ini
        $this->forge->modifyColumn('materi', [
            'level' => [
                'type' => 'ENUM',
                'constraint' => ['level_1', 'level_2', 'level_3'],
                'default' => 'level_1'
            ]
        ]);
    }
}
