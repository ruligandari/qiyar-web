<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTotalResiToBarangKeluarJkt extends Migration
{
    public function up()
    {
        $fields = [
            'total_resi' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
                'after' => 'tanggal', // Places the column after 'tanggal'
            ],
        ];

        // Check if table exists first to avoid errors
        if ($this->db->tableExists('barang_keluar_jkt')) {
             // Check if column exists
            if (!$this->db->getFieldData('barang_keluar_jkt', 'total_resi')) {
                $this->forge->addColumn('barang_keluar_jkt', $fields);
            }
        }
    }

    public function down()
    {
        if ($this->db->tableExists('barang_keluar_jkt')) {
            $this->forge->dropColumn('barang_keluar_jkt', 'total_resi');
        }
    }
}
