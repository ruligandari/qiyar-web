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
        // Client-side search requested to persist selections. 
        // Returning all data so JS can filter.
        $data = [
            'title' => 'Cetak Barcode Massal',
            'products' => $this->master_jkt->orderBy('nama_barang', 'ASC')->findAll(),
        ];
        return view('mobile/bulk_barcode/index', $data);
    }

    public function print()
    {
        $selectedIds = $this->request->getPost('selected_ids');
        $quantities = $this->request->getPost('qty'); // Array of [id => qty]

        if (empty($selectedIds)) {
            return redirect()->back()->with('error', 'Pilih setidaknya satu barang untuk dicetak.');
        }

        // Fetch details for selected items
        $products = $this->master_jkt->whereIn('id', $selectedIds)->findAll();
        
        // Prepare data with repetition
        $printData = [];
        foreach ($products as $product) {
            $count = isset($quantities[$product['id']]) ? (int)$quantities[$product['id']] : 1;
            if($count < 1) $count = 1;

            // Add the product object to the list $count times
            for($i = 0; $i < $count; $i++) {
                $printData[] = $product;
            }
        }

        $type = $this->request->getPost('type') ?? 'barcode';

        $data = [
            'title' => 'Cetak ' . ($type == 'qrcode' ? 'QR Code' : 'Barcode'),
            'products' => $printData,
            'type' => $type
        ];
        return view('mobile/bulk_barcode/print', $data);
    }
}
