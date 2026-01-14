<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddResiToBarangKeluarJkt extends Migration
{
    public function up()
    {
        $fields = [
            'resi' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'after' => 'total_resi', // Places the column after 'total_resi'
            ],
        ];

        // Check if column exists
        // simplified logic to just add it. If it fails, we will see the error.
        $this->forge->addColumn('barang_keluar_jkt', $fields);
    }

    public function down()
    {
        if ($this->db->tableExists('barang_keluar_jkt')) {
            $this->forge->dropColumn('barang_keluar_jkt', 'resi');
        }
    }
}
