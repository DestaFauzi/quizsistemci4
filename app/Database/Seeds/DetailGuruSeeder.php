<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DetailGuruSeeder extends Seeder
{
    public function run()
    {
        // Ambil user_id untuk user guru (role_id = 2)
        $builder = $this->db->table('users');
        $guru = $builder->where('role_id', 2)->get()->getRow();

        if (!$guru) {
            echo "Tidak ada user dengan role_id 2 (guru) ditemukan.";
            return;
        }

        $data = [
            'user_id'    => $guru->id,
            'nama_guru'  => 'Budi Santoso',
            'nip'        => '198004032022011001',
            'alamat'     => 'Jl. Pendidikan No. 45, Bandung',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        // Masukkan ke tabel detail_guru
        $this->db->table('detail_guru')->insert($data);
    }
}
