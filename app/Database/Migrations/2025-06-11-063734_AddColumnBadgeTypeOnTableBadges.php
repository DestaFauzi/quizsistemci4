<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnBadgeTypeOnTableBadges extends Migration
{
    public function up()
    {
        $this->forge->addColumn('badge', [
            'badge_type' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'default'    => 'winner',
                'after'      => 'badge_name',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('badge', 'badge_type');
    }
}
