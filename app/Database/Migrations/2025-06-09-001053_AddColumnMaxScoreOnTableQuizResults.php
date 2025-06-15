<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnMaxScoreOnTableQuizResults extends Migration
{
    public function up()
    {
        $this->forge->addColumn('quiz_results', [
            'max_score' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'after'      => 'score',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('quiz_results', 'max_score');
    }
}
