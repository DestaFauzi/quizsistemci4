<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableDetailMurid extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'murid_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'nama_murid' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'nis' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'alamat' => [
                'type' => 'TEXT',
            ],
            'jurusan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'kelas' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('murid_id', 'users', 'id');
        $this->forge->createTable('detail_murid');
    }

    public function down()
    {
        //
    }
}
