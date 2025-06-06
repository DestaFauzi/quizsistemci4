<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumsLevelOnTablekelasSiswa extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('kelas_siswa', [
            'level' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
                'default'    => 0,
                'after'      => 'kelas_id',
            ],
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('kelas_siswa', 'level');
    }
}
