<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DetailMuridSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua user yang memiliki role_id = 3 (murid)
        $murids = $this->db->table('users')->where('role_id', 3)->get()->getResult();

        $data = [];

        foreach ($murids as $index => $murid) {
            $data[] = [
                'user_id'    => $murid->id,
                'nama_murid'  => 'Murid ' . ($index + 1),
                'nis'         => '202500' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'alamat'      => 'Alamat Murid ' . ($index + 1),
                'jurusan'     => ['IPA', 'IPS', 'Bahasa', 'TKJ', 'RPL'][$index % 5], // jurusan bervariasi
                'kelas'       => 'XII-' . chr(65 + ($index % 3)), // XII-A, XII-B, XII-C
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ];
        }

        // Insert ke dalam tabel detail_murid secara batch
        $this->db->table('detail_murid')->insertBatch($data);
    }
}
