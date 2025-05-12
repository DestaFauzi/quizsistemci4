<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBadgesTable extends Migration
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
            'badge_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'date_earned' => [
                'type' => 'DATETIME',
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
        $this->forge->addForeignKey('murid_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('badge');
    }

    public function down()
    {
        $this->forge->dropTable('badge');
    }
}
