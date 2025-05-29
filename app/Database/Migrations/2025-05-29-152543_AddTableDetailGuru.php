<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTableDetailGuru extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'guru_id' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'nama_guru' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'nip' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'alamat' => [
                'type' => 'TEXT',
            ],
            
            'created_at' => [
                'type' => 'DATETIME',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('guru_id', 'users', 'id');
        $this->forge->createTable('detail_guru');
    }

    public function down()
    {
        $this->forge->dropTable('detail_guru');
    }
}
