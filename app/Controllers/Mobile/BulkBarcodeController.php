<?php

namespace App\Controllers\Mobile;

use App\Controllers\BaseController;
use App\Models\BarangMasukJktModel;

class BulkBarcodeController extends BaseController
{
    protected $master_jkt;

    public function __construct()
    {
        $this->master_jkt = new BarangMasukJktModel();
    }

    public function index()
    {
        // Should probably use pagination if there are many items, but for now findAll() 
        // as per valid implementation patterns in this codebase (see Scaner.php)
        $data = [
            'title' => 'Cetak Barcode Massal',
            'products' => $this->master_jkt->orderBy('nama_barang', 'ASC')->findAll()
        ];
        return view('mobile/bulk_barcode/index', $data);
    }

    public function print()
    {
        $selectedIds = $this->request->getPost('selected_ids');

        if (empty($selectedIds)) {
            return redirect()->back()->with('error', 'Pilih setidaknya satu barang untuk dicetak.');
        }

        // Fetch details for selected items
        $products = $this->master_jkt->whereIn('id', $selectedIds)->findAll();

        $data = [
            'title' => 'Cetak Barcode',
            'products' => $products
        ];
        return view('mobile/bulk_barcode/print', $data);
    }
}
