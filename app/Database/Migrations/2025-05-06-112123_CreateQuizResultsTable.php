<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuizResultsTable extends Migration
{
    public function up()
    {
        // Membuat tabel quiz_results
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
            'score' => [
                'type' => 'INT',
                'constraint' => 11,
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

        // Membuat tabel quiz_results
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('quiz_id', 'quiz', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('murid_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('quiz_results');
    }

    public function down()
    {
        // Menghapus tabel quiz_results
        $this->forge->dropTable('quiz_results');
    }
}
