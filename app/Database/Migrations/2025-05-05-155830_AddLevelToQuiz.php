<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLevelToQuiz extends Migration
{
    public function up()
    {
        // Menambahkan kolom level pada tabel quiz
        $this->forge->addColumn('quiz', [
            'level' => [
                'type'           => 'INT',
                'constraint'     => 1,
                'default'        => 1,  // Nilai default 1 untuk level quiz
                'after'          => 'waktu',  // Tempatkan kolom setelah kolom 'waktu'
            ]
        ]);
    }

    public function down()
    {
        // Menghapus kolom level jika rollback
        $this->forge->dropColumn('quiz', 'level');
    }
}
