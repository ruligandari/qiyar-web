<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('user')->insert([
            'nama' => 'gudangjkt',
            'email' => 'gudangjkt@gmail.com',
            'password' => password_hash('gudangjkt', PASSWORD_DEFAULT),
            'role' => '7'
        ]);
    }
}
