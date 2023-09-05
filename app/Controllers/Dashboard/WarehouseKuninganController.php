<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class WarehouseKuninganController extends BaseController
{
    function __construct()
    {
        $this->barang_masuk = new \App\Models\BarangMasukModel();
        $this->barang_keluar = new \App\Models\BarangKeluarModel();
    }
    public function index()
    {
        $barangMasuk = $this->barang_masuk->findAll();
        $data = [
            'title' => 'Warehouse - Kuningan',
            'active' => 'warehouse',
            'barangmasuk' => $barangMasuk
        ];
        return view('dashboard/warehouse/warehouse', $data);
    }
    public function tambahBarangMasuk()
    {

        $data = [
            'title' => 'Warehouse - Kuningan',

        ];
        return view('dashboard/warehouse/tambahbarangmasuk-kuningan', $data);
    }

    public function addBarangMasuk()
    {
        $tanggal = $this->request->getPost('tanggal');
        $nama_barang = $this->request->getPost('nama_barang');
        $qty = $this->request->getPost('qty');
        $upload_bukti = $this->request->getFile('upload_bukti');

        // cek apakah ada file yang diupload
        if (!$upload_bukti->getError() == 4) {
            // generate nama file random
            $namaFile = $upload_bukti->getRandomName();
            // pindahkan file ke folder img
            $upload_bukti->move('bukti-barang-masuk-kng', $namaFile);
        } else {
            return redirect()->to('/dashboard/warehouse-kuningan/tambah')->withInput()->with('error', 'File Upload Bukti Barang Masuk Wajib Diisi!');
        }

        $data = [
            'tanggal' => $tanggal,
            'nama_barang' => $nama_barang,
            'qty' => $qty,
            'upload_bukti' => $namaFile
        ];

        if ($data) {
            // insert data 
            $this->barang_masuk->insert($data);
            return redirect()->to('/dashboard/warehouse-kuningan')->with('success', 'Data Berhasil Ditambahkan!');
        } else {
            return redirect()->to('/dashboard/warehouse-kuningan/tambah')->withInput()->with('error', 'Data Gagal Ditambahkan!, Silahkan Periksa Kembali');
        }
    }

    public function deleteBarangMasuk()
    {
        $id = $this->request->getPost('id');

        $hapus = $this->barang_masuk->delete($id);
        if ($hapus) {
            $data = [
                'success' => true
            ];
        } else {
            $data = [
                'success' => false
            ];
        }

        return json_encode($data);
    }

    public function editBarangMasuk($id)
    {
        $barangMasuk = $this->barang_masuk->find($id);

        $data = [
            'title' => 'Warehouse - Kuningan',
            'data' => $barangMasuk

        ];
        return view('dashboard/warehouse/editbarangmasuk-kuningan', $data);
    }

    public function tambahQtyBarangMasuk()
    {
        $id = $this->request->getPost('id');
        $qty = $this->request->getPost('qty');

        // tambah nilai qty yang tersimpan didalam database
        $barang_masuk = $this->barang_masuk->find($id);
        $tambahQty = $barang_masuk['qty'] + $qty;

        $update = $this->barang_masuk->update($id, [
            'qty' => $tambahQty
        ]);

        if ($update) {
            $data = [
                'success' => true
            ];
        } else {
            $data = [
                'success' => false
            ];
        }

        return json_encode($data);
    }

    public function updateBarangMasuk()
    {
        $id = $this->request->getPost('id');
        $nama_barang = $this->request->getPost('nama_barang');
        $qty = $this->request->getPost('qty');
        $upload_bukti = $this->request->getFile('upload_bukti');
        $bukti_transfer_lama = $this->request->getPost('bukti_transfer_lama');

        // cek apakah ada file yang diupload
        if (!$upload_bukti->getError() == 4) {
            // generate nama file random
            $namaFile = $upload_bukti->getRandomName();
            // pindahkan file ke folder img
            $upload_bukti->move('bukti-barang-masuk-kng', $namaFile);
            // hapus file lama
            unlink('bukti-barang-masuk-kng/' . $bukti_transfer_lama);
        } else {
            $namaFile = $bukti_transfer_lama;
        }

        $data = [
            'nama_barang' => $nama_barang,
            'qty' => $qty,
            'upload_bukti' => $namaFile
        ];

        if ($data) {
            // insert data 
            $this->barang_masuk->update($id, $data);
            return redirect()->to('/dashboard/warehouse-kuningan')->with('success', 'Data Berhasil Diupdate!');
        } else {
            return redirect()->to('/dashboard/warehouse-kuningan/edit/' . $id)->withInput()->with('error', 'Data Gagal Diupdate!, Silahkan Periksa Kembali');
        }
    }

    public function tambahBarangKeluar()
    {
        $barang_masuk = $this->barang_masuk->findAll();
        $data = [
            'title' => 'Warehouse - Kuningan',
            'barangmasuk' => $barang_masuk

        ];
        return view('dashboard/warehouse/tambahbarangkeluar-kuningan', $data);
    }

    public function addBarangKeluar()
    {
        $tanggal = $this->request->getPost('tanggal');
        $nama_barang = $this->request->getPost('nama_barang');
        $qty = $this->request->getPost('qty');
        $upload_bukti = $this->request->getFile('upload_bukti');

        dd($nama_barang);

        // cek apakah ada file yang diupload
        if (!$upload_bukti->getError() == 4) {
            // generate nama file random
            $namaFile = $upload_bukti->getRandomName();
            // pindahkan file ke folder img
            $upload_bukti->move('bukti-barang-masuk-kng', $namaFile);
        } else {
            return redirect()->to('/dashboard/warehouse-kuningan/tambah')->withInput()->with('error', 'File Upload Bukti Barang Masuk Wajib Diisi!');
        }

        $data = [
            'tanggal' => $tanggal,
            'nama_barang' => $nama_barang,
            'qty' => $qty,
            'upload_bukti' => $namaFile
        ];

        if ($data) {
            // insert data 
            $this->barang_masuk->insert($data);
            return redirect()->to('/dashboard/warehouse-kuningan')->with('success', 'Data Berhasil Ditambahkan!');
        } else {
            return redirect()->to('/dashboard/warehouse-kuningan/tambah')->withInput()->with('error', 'Data Gagal Ditambahkan!, Silahkan Periksa Kembali');
        }
    }
}
