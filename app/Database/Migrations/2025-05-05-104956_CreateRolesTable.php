<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRolesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'role_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('roles');

        // Insert roles admin, guru, dan murid
        $this->db->table('roles')->insertBatch([
            ['role_name' => 'admin'],
            ['role_name' => 'guru'],
            ['role_name' => 'murid'],
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('roles');
    }
}
