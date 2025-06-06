<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnPointOnTableKelas extends Migration
{
    public function up()
    {
        //
        $this->forge->addColumn('materi', [
            'point' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
                'default'    => 0,
                'after'      => 'level',
            ],
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('materi', 'point');
    }
}
