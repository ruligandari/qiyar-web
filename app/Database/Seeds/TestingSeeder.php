<?php


namespace App\Database\Seeds;

use Faker\Factory as Faker;

use CodeIgniter\Database\Seeder;

class TestingSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $randomAmount = $faker->numberBetween(100000, 10000000);
        for ($i = 0; $i < 300; $i++) {
            $this->db->table('pengeluaran_advertiser')->insert([
                'tanggal' => $faker->date,
                'waktu' => $faker->time,
                'nama_advertiser' => $faker->name,
                'bank_tujuan' => 'BRI',
                'jumlah' => $randomAmount,
                'keterangan' => $faker->name
            ]);
        }
    }
}
