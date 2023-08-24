<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('user')->insert([
            'nama' => 'Amelia',
            'email' => 'amelia@gmail.com',
            'password' => password_hash('amelia1234', PASSWORD_DEFAULT),
            'role' => '2'
        ]);
    }
}
