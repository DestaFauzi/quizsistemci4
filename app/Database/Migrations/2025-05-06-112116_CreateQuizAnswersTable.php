<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuizAnswersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true,
                'constraint' => 11,
            ],
            'quiz_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'murid_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'soal_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'jawaban_pilih' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'is_correct' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        // Membuat tabel quiz_answers
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('murid_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('quiz_id', 'quiz', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('soal_id', 'soal', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('quiz_answers');
    }

    public function down()
    {
        // Menghapus tabel quiz_answers
        $this->forge->dropTable('quiz_answers');
    }
}
