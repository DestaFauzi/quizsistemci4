<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
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
            [
                'username' => 'muriduser1',
                'email' => 'murid1@example.com',
                'password' => password_hash('muridpassword1', PASSWORD_DEFAULT),  // Password terenkripsi
                'role_id' => 3, // Role murid
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'muriduser2',
                'email' => 'murid2@example.com',
                'password' => password_hash('muridpassword2', PASSWORD_DEFAULT),  // Password terenkripsi
                'role_id' => 3, // Role murid
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'muriduser3',
                'email' => 'murid3@example.com',
                'password' => password_hash('muridpassword3', PASSWORD_DEFAULT),  // Password terenkripsi
                'role_id' => 3, // Role murid
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'muriduser4',
                'email' => 'murid4@example.com',
                'password' => password_hash('muridpassword4', PASSWORD_DEFAULT),  // Password terenkripsi
                'role_id' => 3, // Role murid
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'muriduser5',
                'email' => 'murid5@example.com',
                'password' => password_hash('muridpassword5', PASSWORD_DEFAULT),  // Password terenkripsi
                'role_id' => 3, // Role murid
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'muriduser6',
                'email' => 'murid6@example.com',
                'password' => password_hash('muridpassword6', PASSWORD_DEFAULT),  // Password terenkripsi
                'role_id' => 3, // Role murid
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'muriduser7',
                'email' => 'murid7@example.com',
                'password' => password_hash('muridpassword7', PASSWORD_DEFAULT),  // Password terenkripsi
                'role_id' => 3, // Role murid
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'muriduser8',
                'email' => 'murid8@example.com',
                'password' => password_hash('muridpassword8', PASSWORD_DEFAULT),  // Password terenkripsi
                'role_id' => 3, // Role murid
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'muriduser9',
                'email' => 'murid9@example.com',
                'password' => password_hash('muridpassword9', PASSWORD_DEFAULT),  // Password terenkripsi
                'role_id' => 3, // Role murid
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert data ke dalam tabel users
        $this->db->table('users')->insertBatch($data);
    }
}
