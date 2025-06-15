<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuizTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'kelas_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'judul_quiz' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'jumlah_soal' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'waktu' => [
                'type' => 'INT', // waktu dalam menit
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('kelas_id', 'kelas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('quiz');
    }

    public function down()
    {
        $this->forge->dropTable('quiz');
    }
}
