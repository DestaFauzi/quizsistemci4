<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnskelasidOnTableQuizAnswer extends Migration
{
    public function up()
    {
        //add Column kelas_id on table quiz_answer kelas_id adalah foreign key dari tabel kelas
        $this->forge->addColumn('quiz_answers', [
            'kelas_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
                'default'    => 0,
                'after'      => 'quiz_id',
            ],
        ]);
    }

    public function down()
    {
        //
        $this->forge->dropColumn('quiz_answers', 'kelas_id');
    }
}
