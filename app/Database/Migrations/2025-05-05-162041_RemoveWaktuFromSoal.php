<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveWaktuFromSoal extends Migration
{
    public function up()
    {
        // Menghapus kolom waktu dari tabel soal
        $this->forge->dropColumn('soal', 'waktu');
    }

    public function down()
    {
        // Jika rollback, kolom waktu akan ditambahkan lagi
        $this->forge->addColumn('soal', [
            'waktu' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,  // Nilai default jika kolom ini ditambahkan kembali
            ]
        ]);
    }
}
