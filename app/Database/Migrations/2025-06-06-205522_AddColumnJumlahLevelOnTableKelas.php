<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnJumlahLevelOnTableKelas extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('kelas', [
            'jumlah_level' => [
            'type'       => 'INT',
            'constraint' => 11,
            'null'       => false,
            'default'    => 0,
            'after'      => 'deskripsi', // adjust if you want to place it after a specific column
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('kelas', 'jumlah_level');
    }
}
