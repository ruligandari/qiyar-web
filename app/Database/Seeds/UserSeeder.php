<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('user')->insert([
            'nama' => 'Syahrul',
            'email' => 'syahrul@gmail.com',
            'password' => password_hash('syahrul', PASSWORD_DEFAULT),
            'role' => '2'
        ]);
    }
}
