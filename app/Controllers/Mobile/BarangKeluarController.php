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
        // same as barang masuk
        $search = $this->request->getGet('q');
        // Inisialisasi model
        $stokModel = $this->barang_keluar_jkt;

        if ($search) {
            // Jika ada pencarian, filter data berdasarkan pencarian
            $stokModel->like('nama_barang', $search);
        }

        // Pagination dengan pencarian
        $stok = $stokModel->orderBy('id', 'DESC')
            ->paginate(30, 'stok_barang');

        $data = [
            'title' => 'Barang Keluar',
            'data' => $stok,
            'pager' => $stokModel->pager,  // Untuk pagination
            'search' => $search            // Untuk mempertahankan input pencarian di view
        ];
        return view('mobile/barang_keluar/index', $data);
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
        $data = [
            'nama_barang' => $nama_barang,
            'qty' => $qty,
            'tanggal' => date('Y-m-d'),
            'total_resi' => $resi,
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
            'total_resi' => $resi,
        ];

        $this->barang_keluar_jkt->update($id, $data);
        return redirect()->to(base_url('stok-opname/barang-keluar'))->with('success', 'Data berhasil diupdate');
    }
}
