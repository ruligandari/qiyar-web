<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;

class WarehouseKuninganController extends BaseController
{
    function __construct()
    {
        $this->barang_masuk = new \App\Models\BarangMasukModel();
        $this->barang_keluar = new \App\Models\BarangKeluarModel();
        $this->stok_barang = new \App\Models\StokBarangModel();
    }
    public function index()
    {
        $barangMasuk = $this->barang_masuk->findAll();
        $barangKeluar = $this->barang_keluar->findAll();
        $data = [
            'title' => 'Warehouse - Kuningan',
            'active' => 'warehouse',
            'barangmasuk' => $barangMasuk,
            'barangkeluar' => $barangKeluar,
        ];
        return view('dashboard/warehouse/kuningan/warehouse', $data);
    }
    public function tambahBarangMasuk()
    {

        $data = [
            'title' => 'Warehouse - Kuningan',

        ];
        return view('dashboard/warehouse/kuningan/tambahbarangmasuk-kuningan', $data);
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
        return view('dashboard/warehouse/kuningan/editbarangmasuk-kuningan', $data);
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
        return view('dashboard/warehouse/kuningan/tambahbarangkeluar-kuningan', $data);
    }

    public function addBarangKeluar()
    {
        $tanggal = $this->request->getPost('tanggal');
        $nama_barang = $this->request->getPost('nama_barang');
        $qty = $this->request->getPost('qty');
        $total_resi = $this->request->getPost('total_resi');
        $upload_bukti = $this->request->getFile('upload_bukti');

        // cek jumlah array $nama barang
        $jumlahNamaBarang = count($nama_barang);

        if ($jumlahNamaBarang > 1) {
            for ($i = 0; $jumlahNamaBarang > $i; $i++) {
                // cek nama barang dari table barang_masuk
                $barangMasukDb = $this->barang_masuk->find($nama_barang[$i]);
                $qtyBarangMasuk = $barangMasukDb['qty'];
                $kurangi = $qtyBarangMasuk - $qty;
                // update barang_masuk dengan mengurangi qty yang didatabase dengan qty dari form
                $this->barang_masuk->update($nama_barang[$i], [
                    'qty' => $kurangi
                ]);
            }
        } else {
            $barang = $nama_barang[0];

            // update barang_masuk dengan mengurangi qty yang didatabase dengan qty dari form
            $barang_masuk = $this->barang_masuk->find($barang);
            $kurangQty = $barang_masuk['qty'] - $qty;
            $this->barang_masuk->update($barang, [
                'qty' => $kurangQty
            ]);
        }

        // cek nama barang dari table barang_masuk
        $cekNamaBarang = $this->barang_masuk->find($nama_barang[0]);
        $namaBarangDb = $cekNamaBarang['nama_barang'];

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
            'nama_barang' => $namaBarangDb,
            'qty' => $qty,
            'total_resi' => $total_resi,
            'bukti_pickup' => $namaFile
        ];

        if ($data) {
            // insert data 
            $this->barang_keluar->insert($data);
            return redirect()->to('/dashboard/warehouse-kuningan')->with('success', 'Data Berhasil Ditambahkan!');
        } else {
            return redirect()->to('/dashboard/warehouse-kuningan-keluar/tambah')->withInput()->with('error', 'Data Gagal Ditambahkan!, Silahkan Periksa Kembali');
        }
    }

    public function editBarangKeluar($id)
    {
        $barangkeluar = $this->barang_keluar->find($id);
        $id = $this->barang_masuk->where('nama_barang', $barangkeluar['nama_barang'])->first();
        $barang_masuk = $this->barang_masuk->where('nama_barang !=', $barangkeluar['nama_barang'])->findAll();

        $data = [
            'title' => 'Warehouse - Kuningan',
            'data' => $barangkeluar,
            'barang' => $barang_masuk,
            'id_barang_masuk' => $id['id']

        ];
        return view('dashboard/warehouse/kuningan/editbarangkeluar-kuningan', $data);
    }

    public function updateBarangKeluar()
    {
        $id = $this->request->getPost('id');
        $nama_barang = $this->request->getPost('nama_barang');
        $qty = $this->request->getPost('qty');
        $qty_lama = $this->request->getPost('qty_lama');
        $total_resi = $this->request->getPost('total_resi');
        $upload_bukti = $this->request->getFile('bukti_pickup');
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

        $barang_masuk = $this->barang_masuk->find($nama_barang);

        if ($qty != $qty_lama) {
            // update barang_masuk dengan mengurangi qty yang didatabase dengan qty dari form
            $kurangQty = $barang_masuk['qty'] - $qty_lama;
            $tambahQty = $kurangQty + $qty;
            $this->barang_masuk->update($nama_barang, [
                'qty' => $tambahQty
            ]);
        }

        $data = [
            'nama_barang' => $barang_masuk['nama_barang'],
            'total_resi' => $total_resi,
            'qty' => $qty,
            'bukti_pickup' => $namaFile
        ];

        if ($data) {
            // insert data 
            $this->barang_keluar->update($id, $data);
            return redirect()->to('/dashboard/warehouse-kuningan')->with('success', 'Data Berhasil Diupdate!');
        } else {
            return redirect()->to('/dashboard/warehouse-kuningan-keluar/edit/' . $id)->withInput()->with('error', 'Data Gagal Diupdate!, Silahkan Periksa Kembali');
        }
    }

    public function deleteBarangKeluar()
    {
        $id = $this->request->getPost('id');
        // unlink $bukti_pickup
        // $barang_keluar = $this->barang_keluar->find($id);
        // unlink('bukti-barang-masuk-kng/' . $barang_keluar['bukti_pickup']);

        $hapus = $this->barang_keluar->delete($id);
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

    public function stokBarang()
    {
        $stok = $this->stok_barang->findAll();
        $data = [
            'title' => 'Warehouse - Kuningan',
            'stok' => $stok
        ];

        return view('dashboard/warehouse/kuningan/stokbarang-kuningan', $data);
    }
    public function tambahStokBarang()
    {
        $barang_masuk = $this->barang_masuk->findAll();
        $data = [
            'title' => 'Warehouse - Kuningan',
            'barang_masuk' => $barang_masuk
        ];

        return view('dashboard/warehouse/kuningan/updatestokbarang-kuningan', $data);
    }

    public function addStokBarang()
    {
        $tanggal = $this->request->getPost('tanggal');
        $nama_barang_form = $this->request->getPost('nama_barang');
        $qty = $this->request->getPost('qty');
        $upload_bukti = $this->request->getFile('upload_bukti');

        // cek apakah ada file yang diupload
        if (!$upload_bukti->getError() == 4) {
            // generate nama file random
            $namaFile = $upload_bukti->getRandomName();
            // pindahkan file ke folder img
            $upload_bukti->move('bukti-barang-masuk-kng', $namaFile);
        } else {
            return redirect()->to('/dashboard/warehouse-kuningan/stok/tambah')->withInput()->with('error', 'File Upload Bukti Barang Masuk Wajib Diisi!');
        }
        // mendapatkan nama_barang dari tabel barang masuk berdasarkan id
        $barang_masuk = $this->barang_masuk->find($nama_barang_form);
        $nama_barang = $barang_masuk['nama_barang'];

        if ($barang_masuk) {
            $data = [
                'tanggal' => $tanggal,
                'nama_barang' => $nama_barang,
                'qty' => $qty,
                'upload_bukti' => $namaFile
            ];
            // update tabel barang_masuk
            $tambah_stok = $barang_masuk['qty'] + $qty;
            $update_stok = $this->barang_masuk->update($nama_barang_form, [
                'qty' => $tambah_stok
            ]);
            // insert
            $this->stok_barang->insert($data);
            return redirect()->to('/dashboard/warehouse-kuningan/stok')->with('success', 'Data Berhasil Ditambahkan!');
        } else {
            return redirect()->to('/dashboard/warehouse-kuningan/stok/tambah')->withInput()->with('error', 'Data Gagal Ditambahkan!, Silahkan Periksa Kembali');
        }
    }

    public function deleteStokBarang()
    {
        $id = $this->request->getPost('id');

        // unlink $bukti_pickup
        $barang_keluar = $this->stok_barang->find($id);
        unlink('bukti-barang-masuk-kng/' . $barang_keluar['upload_bukti']);

        $hapus = $this->stok_barang->delete($id);
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

    public function editStokBarang($id)
    {
        $stokBarang = $this->stok_barang->find($id);
        $barang = $this->barang_masuk->where('nama_barang !=', $stokBarang['nama_barang'])->findAll();
        $idNamaBarang = $this->barang_masuk->where('nama_barang', $stokBarang['nama_barang'])->first();

        $data = [
            'title' => 'Warehouse - Kuningan',
            'data' => $stokBarang,
            'barang' => $barang,
            'id' => $idNamaBarang['id']

        ];
        return view('dashboard/warehouse/kuningan/editstokbarang-kuningan', $data);
    }

    public function updateStokBarang()
    {
        $id = $this->request->getPost('id');
        $tanggal = $this->request->getPost('tanggal');
        $nama_barang = $this->request->getPost('nama_barang');
        $qty = $this->request->getPost('qty');
        $qty_lama = $this->request->getPost('qty_lama');
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

        // update qty barang_masuk
        $barang_masuk = $this->barang_masuk->find($nama_barang);
        $kurangQty = $barang_masuk['qty'] - $qty_lama;
        $tambahQty = $kurangQty + $qty;

        // update qty barang_masuk
        $this->barang_masuk->update($nama_barang, [
            'qty' => $kurangQty
        ]);

        $data = [
            'tanggal' => $tanggal,
            'nama_barang' => $barang_masuk['nama_barang'],
            'qty' => $qty,
            'upload_bukti' => $namaFile
        ];

        if ($data) {

            // insert data 
            $this->stok_barang->update($id, $data);
            // update qty barang_masuk
            $this->barang_masuk->update($nama_barang, [
                'qty' => $tambahQty
            ]);
            return redirect()->to('/dashboard/warehouse-kuningan/stok')->with('success', 'Data Berhasil Diupdate!');
        } else {
            return redirect()->to('/dashboard/warehouse-kuningan/stok/edit/' . $id)->withInput()->with('error', 'Data Gagal Diupdate!, Silahkan Periksa Kembali');
        }
    }
}
