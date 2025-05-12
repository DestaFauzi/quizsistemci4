<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $model = new UserModel();

        // Data pengguna dummy untuk masing-masing role
        $data = [
            [
                'username' => 'adminuser',
                'email' => 'admin@example.com',
                'password' => password_hash('adminpassword', PASSWORD_DEFAULT),  // Password terenkripsi
                'role_id' => 1, // Role admin
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'guruuser',
                'email' => 'guru@example.com',
                'password' => password_hash('gurupassword', PASSWORD_DEFAULT),  // Password terenkripsi
                'role_id' => 2, // Role guru
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'muriduser',
                'email' => 'murid@example.com',
                'password' => password_hash('muridpassword', PASSWORD_DEFAULT),  // Password terenkripsi
                'role_id' => 3, // Role murid
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert data ke dalam tabel users
        $this->db->table('users')->insertBatch($data);
    }
}
