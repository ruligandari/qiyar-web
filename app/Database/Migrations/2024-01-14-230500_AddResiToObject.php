<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddResiToObject extends Migration
{
    public function up()
    {
        // Try adding it again with a new migration file
       $fields = [
            'resi' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'after' => 'total_resi', 
            ],
        ];
        
        // Direct execute raw SQL to debug
        $this->db->query("ALTER TABLE barang_keluar_jkt ADD COLUMN resi VARCHAR(255) NULL AFTER total_resi");
    }

    public function down()
    {
        //
    }
}
