<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSoalTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'quiz_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'soal' => [
                'type' => 'TEXT',
            ],
            'jawaban_a' => [
                'type' => 'TEXT',
            ],
            'jawaban_b' => [
                'type' => 'TEXT',
            ],
            'jawaban_c' => [
                'type' => 'TEXT',
            ],
            'jawaban_d' => [
                'type' => 'TEXT',
            ],
            'jawaban_benar' => [
                'type' => 'VARCHAR',
                'constraint' => '1', // a, b, c, atau d
            ],
            'poin' => [
                'type' => 'INT',
                'default' => 1,
            ],
            'waktu' => [
                'type' => 'INT',
                'default' => 1, // Default waktu adalah 1 menit
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('quiz_id', 'quiz', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('soal');
    }

    public function down()
    {
        $this->forge->dropTable('soal');
    }
}
