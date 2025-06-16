<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMateriSiswaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'materi_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'murid_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['belum_diakses', 'sedang_dibaca', 'selesai'],
                'default' => 'belum_diakses',
            ],
            'created_at'     => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => date('Y-m-d H:i:s'),
            ],
            'updated_at'     => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => date('Y-m-d H:i:s'),
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('materi_id', 'materi', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('murid_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('materi_siswa');
    }

    public function down()
    {
        $this->forge->dropTable('materi_siswa');
    }
}
