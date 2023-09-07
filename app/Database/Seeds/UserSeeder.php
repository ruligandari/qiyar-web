<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('user')->insert([
            'nama' => 'Mukti',
            'email' => 'mukti@gmail.com',
            'password' => password_hash('mukti', PASSWORD_DEFAULT),
            'role' => '6'
        ]);
    }
}
