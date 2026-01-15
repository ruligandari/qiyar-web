<?php

namespace App\Controllers\Mobile;

use App\Controllers\BaseController;

class BarangKeluarController extends BaseController
{
    protected $barang_keluar_jkt;
    protected $master_jkt;
    public function __construct()
    {
        $this->barang_keluar_jkt = new \App\Models\BarangKeluarJktModel();
        $this->master_jkt = new \App\Models\BarangMasukJktModel();
    }
    public function index()
    {
        // CSR Implementation: Just return the view container
        // Data will be fetched via AJAX to listData()
        $data = [
            'title' => 'Barang Keluar',
        ];
        return view('mobile/barang_keluar/index', $data);
    }

    public function listData()
    {
        $search = $this->request->getPost('q');
        $page = (int) ($this->request->getPost('page') ?? 1);

        $stokModel = $this->barang_keluar_jkt;

        if ($search) {
            $stokModel->like('nama_barang', $search);
        }

        // Use standard pagination
        $stokModel->orderBy('id', 'DESC');
        
        // Pass manual 'page' index (3rd arg) because we use POST.
        $data = $stokModel->paginate(30, 'stok_barang', $page);
        
        $pager = $stokModel->pager;
        // Fix for AJAX: Set the base path so links don't point to 'list-data'
        // and ostensibly to help Pager resolve context if needed.
        $pager->setPath(base_url('stok-opname/barang-keluar'));

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $data,
            'pager' => $pager->links('stok_barang', 'bootstrap_pagination'),
        ]);
    }
    // scan
    public function scan()
    {
        // Mengambil data JSON dari request body
        $input = json_decode($this->request->getBody(), true);

        // Mengambil nilai 'kode_barang' dari array yang di-decode
        $kode_barang = $input['kode_barang'];
        // find data ke master_jkt
        $data = $this->master_jkt->find($kode_barang);
        if ($data) {
            // jika data ada
            $response = [
                'status' => 'success',
                'data' => $data
            ];
        } else {
            // jika data tidak ada
            $response = [
                'status' => 404,
                'message' => $kode_barang
            ];
        }
        return $this->response->setJSON($response);
    }

    public function add()
    {
        // date waktu jakarta
        date_default_timezone_set('Asia/Jakarta');
        $nama_barang = $this->request->getPost('nama_barang');
        $id = $this->request->getPost('id_barang');
        $qty = $this->request->getPost('qty');
        $resi = $this->request->getPost('resi');

        // cari stok master
        $qtyMaster = $this->master_jkt->find($id);
        // input data ke barang_keluar_jkt
        $addQty = $qtyMaster['qty'] - $qty;
        if ($addQty < 0) {
            return redirect()->to(base_url('stok-opname/barang-keluar'))->with('error', 'Stok Barang bernilai minus, Silahkan Cek Stok Terlebih Dahulu');
        }
        if (empty($resi)) {
             return redirect()->back()->with('error', 'Nomor Resi wajib diisi');
        }

        $data = [
            'nama_barang' => $nama_barang,
            'qty' => $qty,
            'tanggal' => date('Y-m-d'),
            'total_resi' => 1, // Default 1 as per request
            'resi' => $resi,
        ];

        $this->barang_keluar_jkt->insert($data);
        $this->master_jkt->where('id', $id)->set('qty', $addQty)->update();

        // redirect
        return redirect()->to(base_url('stok-opname/barang-keluar'))->with('success', 'Data berhasil disimpan');
    }

    public function delete()
    {
        // tangkap data id dengan method delete
        $id = $this->request->getPost('id');
        // cari nama produk
        $BarangMasuk = $this->barang_keluar_jkt->find($id);
        // cari stok berdasarkan BarangMasuk ke master_jkt
        $stokBarangJkt = $this->master_jkt->where('nama_barang', $BarangMasuk['nama_barang'])->first();
        $stokJkt = $stokBarangJkt['qty'];
        $stokBarangMasuk = $BarangMasuk['qty'];
        $updateStok = $stokJkt + $stokBarangMasuk;

        // update stok master_jkt
        $this->master_jkt->where('nama_barang', $stokBarangJkt['nama_barang'])->set('qty', $updateStok)->update();

        // hapus data dengan data id
        $this->barang_keluar_jkt->delete($id);
        // kirim response json dengan status sukses
        return $this->response->setJSON(['status' => 'success', 'message' => 'Data berhasil dihapus', 'data', $id]);
    }

    public function edit()
    {
        $id = $this->request->getPost('id');
        // cari data berdasarkan id
        $data = $this->barang_keluar_jkt->find($id);
        // kirim data ke json
        return $this->response->setJSON($data);
    }

    public function update()
    {
        $id = $this->request->getPost('id');
        $nama_barang = $this->request->getPost('nama_barang');
        $qty = $this->request->getPost('qty');
        $resi = $this->request->getPost('resi');

        if (empty($resi)) {
            return redirect()->back()->with('error', 'Nomor Resi wajib diisi');
        }

        $stokMaster = $this->master_jkt->where('nama_barang', $nama_barang)->first();
        if ($stokMaster == null || $stokMaster['qty'] < $qty) {
            return redirect()->to(base_url('stok-opname/barang-keluar'))->with('error', 'Stok barang tidak mencukupi');
        }
        $stokBarang = $this->barang_keluar_jkt->find($id);
        $stokBaru = ($stokMaster['qty'] + $stokBarang['qty']) - $qty;
        // INPUT ke stok master
        $this->master_jkt->where('nama_barang', $nama_barang)->set(['qty' => $stokBaru])->update();

        $data = [
            'nama_barang' => $nama_barang,
            'qty' => $qty,
            'total_resi' => 1, // Default 1
            'resi' => $resi,
        ];

        $this->barang_keluar_jkt->update($id, $data);
        return redirect()->to(base_url('stok-opname/barang-keluar'))->with('success', 'Data berhasil diupdate');
    }

    public function scaner()
    {
        // find master_jkt
        $master = $this->master_jkt->findAll();
        $data = [
            'title' => 'Scan Barang Keluar',
            'data' => $master
        ];
        return view('mobile/barang_keluar/scaner', $data);
    }

    public function scanManual()
    {
        // find master_jkt
        $master = $this->master_jkt->findAll();
        $data = [
            'title' => 'Scan Manual Barang Keluar',
            'data' => $master
        ];
        return view('mobile/barang_keluar/scan_manual', $data);
    }
}
