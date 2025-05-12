<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKelasSiswaTable extends Migration
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
            'murid_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['belum_dimulai', 'proses', 'selesai'],
                'default' => 'belum_dimulai',
            ],
            'status_materi' => [
                'type' => 'ENUM',
                'constraint' => ['belum_diakses', 'selesai'],
                'default' => 'belum_diakses',
            ],
            'status_quiz' => [
                'type' => 'ENUM',
                'constraint' => ['belum_dikerjakan', 'selesai'],
                'default' => 'belum_dikerjakan',
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
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('kelas_id', 'kelas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('murid_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kelas_siswa');
    }

    public function down()
    {
        $this->forge->dropTable('kelas_siswa');
    }
}
