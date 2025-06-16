<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnskelasidOnTableQuizResults extends Migration
{
    public function up()
    {
        //        // Add Column kelas_id on table quiz_results
        $this->forge->addColumn('quiz_results', [
            'kelas_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
                'default'    => 0,
                'after'      => 'quiz_id',
            ],
        ]);
        $this->forge->addForeignKey('kelas_id', 'kelas', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        //
        $this->forge->dropColumn('quiz_results', 'kelas_id');
    }
}
