<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('user')->insert([
            'nama' => 'Manager Advertiser',
            'email' => 'manager.advertiser@gmail.com',
            'password' => password_hash('manageradvertiser', PASSWORD_DEFAULT),
            'role' => '3'
        ]);
    }
}
