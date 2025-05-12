<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'role_name' => 'admin',
            ],
            [
                'role_name' => 'guru',
            ],
            [
                'role_name' => 'murid',
            ],
        ];

        // Insert data ke dalam tabel roles
        $this->db->table('roles')->insertBatch($data);
    }
}
