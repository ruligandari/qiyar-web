<?php

namespace App\Controllers\Mobile;

use App\Controllers\BaseController;

class BarangMasukController extends BaseController
{
    // constructor
    protected $barang_masuk_jkt;
    protected $master_jkt;
    protected $barang_keluar_jkt;

    public function __construct()
    {
        // load model
        $this->barang_masuk_jkt = new \App\Models\StokBarangJktModel(); // Log Masuk
        $this->master_jkt = new \App\Models\BarangMasukJktModel(); // Master Stock
        $this->barang_keluar_jkt = new \App\Models\BarangKeluarJktModel(); // Log Keluar
    }
    public function index()
    {
        // CSR Implementation
        $data = [
            'title' => 'Barang Masuk',
        ];
        return view('mobile/barang_masuk/index', $data);
    }

    public function listData()
    {
        $search = $this->request->getPost('q');
        $page = (int) ($this->request->getPost('page') ?? 1);
        
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');
        $jenis = $this->request->getPost('jenis_barang_masuk');

        $stokModel = $this->barang_masuk_jkt;

        if ($search) {
            $stokModel->like('nama_barang', $search);
        }
        
        if ($startDate && $endDate) {
            $stokModel->where("tanggal >=", $startDate)->where("tanggal <=", $endDate);
        }

        if ($jenis) {
            $stokModel->where('jenis_barang_masuk', $jenis);
        }

        $stokModel->orderBy('id', 'DESC');

        $data = $stokModel->paginate(30, 'stok_barang', $page);
        
        $pager = $stokModel->pager;
        $pager->setPath(base_url('stok-opname/barang-masuk'));

        return $this->response
            ->setContentType('application/json')
            ->setJSON([
            'status' => 'success',
            'data' => $data,
            'pager' => $pager->links('stok_barang', 'bootstrap_pagination'),
        ]);
    }

    // scan
    // scan
    public function scan()
    {
        // Mengambil data JSON dari request body
        $input = json_decode($this->request->getBody(), true);

        // Mengambil nilai 'kode_barang' dari array yang di-decode
        $kode_barang = $input['kode_barang'];
        $mode = $input['mode'] ?? 'beli'; // beli or return

        // Mode Default: Cari di Master Data by ID
        $data = $this->master_jkt->find($kode_barang);
        if ($data) {
            $response = [
                'status' => 'success',
                'data' => $data
            ];
        } else {
            $response = [
                'status' => 404,
                'message' => 'Barang tidak ditemukan'
            ];
        }
        
        return $this->response->setContentType('application/json')->setJSON($response);
    }

    public function scanManual()
    {
        // find data ke master_jkt (Master Stock)
        $master = $this->master_jkt->findAll();

        $data = [
            'title' => 'Scan Manual Barang Masuk',
            'data' => $master
        ];
        return view('mobile/barang_masuk/scan_manual', $data);
    }

    public function addBulk()
    {
        // Accept JSON because we will send complex data
        $input = json_decode($this->request->getBody(), true);
        
        if (!$input || !isset($input['items'])) {
            return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'Invalid Data']);
        }

        $items = $input['items'];

        $jenis_barang_masuk = $input['jenis_barang_masuk'] ?? 'Barang Return';
        $date = date('Y-m-d');

        $successCount = 0;
        
        foreach($items as $item) {
            $idMaster = $item['id_barang'];
            $qty = $item['qty'];
            $nama_barang = $item['nama_barang'];

            // 1. Get Master Stock
            $masterData = $this->master_jkt->find($idMaster);
            if(!$masterData) continue; // Skip if somehow not found

            // 2. Insert to Barang Masuk Log
            $logData = [
                'nama_barang' => $nama_barang,
                'qty' => $qty,
                'tanggal' => $date,
                'jenis_barang_masuk' => $jenis_barang_masuk
            ];
            $this->barang_masuk_jkt->insert($logData);

            // 3. Update Master Stock (Atomic Update)
            $this->master_jkt->where('id', $idMaster)->set('qty', 'qty + ' . $qty, false)->update();

            $successCount++;
        }

        return $this->response->setJSON([
            'status' => 'success', 
            'message' => "$successCount barang berhasil disimpan."
        ]);
    }

    public function add()
    {
        // date waktu jakarta
        date_default_timezone_set('Asia/Jakarta');
        $nama_barang = $this->request->getPost('nama_barang');
        $id = $this->request->getPost('id_barang');
        $qty = $this->request->getPost('qty');
        $jenis_barang_masuk = $this->request->getPost('jenis_barang_masuk');



        // cari stok master
        $qtyMaster = $this->master_jkt->find($id);
        // input data ke barang_masuk_jkt
        $addQty = $qty + $qtyMaster['qty'];
        $data = [
            'nama_barang' => $nama_barang,
            'qty' => $qty,
            'tanggal' => date('Y-m-d'),
            'tanggal' => date('Y-m-d'),
            'jenis_barang_masuk' => $jenis_barang_masuk,
        ];

        $this->barang_masuk_jkt->insert($data);
        $this->master_jkt->where('id', $id)->set('qty', $addQty)->update();

        // redirect
        return redirect()->to(base_url('stok-opname/barang-masuk'))->with('success', 'Data berhasil disimpan');
    }

    public function delete()
    {
        // tangkap data id dengan method delete
        $id = $this->request->getPost('id');
        // cari nama produk
        $BarangMasuk = $this->barang_masuk_jkt->find($id);
        // cari stok berdasarkan BarangMasuk ke master_jkt
        $stokBarangJkt = $this->master_jkt->where('nama_barang', $BarangMasuk['nama_barang'])->first();
        $stokJkt = $stokBarangJkt['qty'];
        $stokBarangMasuk = $BarangMasuk['qty'];
        $updateStok = $stokJkt - $stokBarangMasuk;

        if ($updateStok < 0) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Stok Saat Ini Kurang dari Data Stok Barang Masuk',]);
        }
        // update stok master_jkt
        $this->master_jkt->where('nama_barang', $stokBarangJkt['nama_barang'])->set('qty', $updateStok)->update();

        // hapus data dengan data id
        $this->barang_masuk_jkt->delete($id);
        // kirim response json dengan status sukses
        return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil dihapus', 'data' => $id]);
    }

    public function edit()
    {
        $id = $this->request->getPost('id');
        // cari data berdasarkan id
        $data = $this->barang_masuk_jkt->find($id);
        // kirim data ke json
        return $this->response->setJSON($data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $nama_barang = $this->request->getPost('nama_barang');
        $qty = $this->request->getPost('qty');
        $jenis_barang_masuk = $this->request->getPost('jenis_barang_masuk');

        $stokMaster = $this->master_jkt->where('nama_barang', $nama_barang)->first();
        if ($stokMaster == null || $stokMaster['qty'] < $qty) {
            return redirect()->to(base_url('stok-opname/barang-masuk'))->with('error', 'Stok barang tidak mencukupi');
        }
        $stokBarang = $this->barang_masuk_jkt->find($id);

        $stokBaru = ($stokMaster['qty'] - $stokBarang['qty']) + $qty;
        // INPUT ke stok master
        $this->master_jkt->where('nama_barang', $nama_barang)->set(['qty' => $stokBaru])->update();

        $data = [
            'nama_barang' => $nama_barang,
            'qty' => $qty,
            'jenis_barang_masuk' => $jenis_barang_masuk,
        ];

        $this->barang_masuk_jkt->update($id, $data);
        return redirect()->to(base_url('stok-opname/barang-masuk'))->with('success', 'Data berhasil diupdate');
    }
    public function scaner()
    {
        // find data ke master_jkt
        $master = $this->master_jkt->findAll();

        $data = [
            'title' => 'Scan Barang Masuk',
            'data' => $master
        ];
        return view('mobile/barang_masuk/scaner', $data);
    }
}
