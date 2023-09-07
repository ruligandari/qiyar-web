<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('user')->insert([
            'nama' => 'Selvia Ningsih',
            'email' => 'selvia@gmail.com',
            'password' => password_hash('selvia', PASSWORD_DEFAULT),
            'role' => '4'
        ]);
    }
}
