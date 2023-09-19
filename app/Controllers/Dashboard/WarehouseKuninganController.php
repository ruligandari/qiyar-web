<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;

use DateTime;

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

        $data = [
            'tanggal' => $tanggal,
            'nama_barang' => $nama_barang,
            'qty' => $qty,
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
        $nama_barang = $this->barang_masuk->find($id);
        $nama_barang = $nama_barang['nama_barang'];

        // delete barang_keluar dengan nama_barang
        $cekBarangKeluar = $this->barang_keluar->where('nama_barang', $nama_barang)->delete();
        $cekStokBarang = $this->stok_barang->where('nama_barang', $nama_barang)->delete();

        $hapus = $this->barang_masuk->delete($id);
        if ($hapus && $cekBarangKeluar && $cekStokBarang) {
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


        $data = [
            'nama_barang' => $nama_barang,
            'qty' => $qty,

        ];

        if ($data) {
            // insert data 
            $this->barang_masuk->update($id, $data);
            return redirect()->to('/dashboard/warehouse-kuningan')->with('success', 'Data Berhasil Diupdate!');
        } else {
            return redirect()->to('/dashboard/warehouse-kuningan/edit/' . $id)->withInput()->with('error', 'Data Gagal Diupdate!, Silahkan Periksa Kembali');
        }
    }

    public function listBarangMasuk()
    {
        $db = db_connect();
        $builder = $db->table('barang_masuk')->select('id, tanggal, nama_barang, qty');
        return DataTable::of($builder)->addNumbering('no')->filter(function ($builder, $request) {
            // cek data diterima atau tidak
            if ($request->dates) {
                // ambil rentang tanggal 09/01/2023 - 09/01/2023
                $dates = explode(' - ', $request->dates);
                $min = DateTime::createFromFormat('m/d/Y', $dates[0])->format('Y-m-d');
                $max = DateTime::createFromFormat('m/d/Y', $dates[1])->format('Y-m-d');
                $builder->where('tanggal >=', $min)->where('tanggal <=', $max);
            }
        })->format('qty', function ($value) {
            return number_format($value, 0, ',', '.');
        })->add('action', function ($row) {
            return '<div class="text-center"><a class="btn btn-success" title="Edit Bray" href="' . base_url('dashboard/warehouse-kuningan/edit/') . $row->id . '" role="button"><i class="fas fa-sm fa-pen"></i></a>
            <button class="btn btn-danger delete-pengeluaran" title="Hapus Bray" onclick="deleteKngMasuk(' . $row->id . ')" role="button"><i class="fas fa-sm fa-trash"></i></button></div>';
        }, 'last')->toJson(true);
    }
    public function listBarangKeluar()
    {
        $db = db_connect();
        $builder = $db->table('barang_keluar')->select('id, tanggal, nama_barang, qty, total_resi, bukti_pickup');
        return DataTable::of($builder)->addNumbering('no')->filter(function ($builder, $request) {
            // cek data diterima atau tidak
            if ($request->dates) {
                // ambil rentang tanggal 09/01/2023 - 09/01/2023
                $dates = explode(' - ', $request->dates);
                $min = DateTime::createFromFormat('m/d/Y', $dates[0])->format('Y-m-d');
                $max = DateTime::createFromFormat('m/d/Y', $dates[1])->format('Y-m-d');
                $builder->where('tanggal >=', $min)->where('tanggal <=', $max);
            }
        })->format('qty', function ($value) {
            return number_format($value, 0, ',', '.');
        })->format('bukti_pickup', function ($value) {
            return '<a href="' . base_url('bukti-barang-masuk-kng/') . $value . '" target="_blank">
            <img src="' . base_url('bukti-barang-masuk-kng/') . $value . '" alt="" style="height:50px; width:50px"></a>';
        })->add('action', function ($row) {
            return '<div class="text-center"><a class="btn btn-success" title="Edit Bray" href="' . base_url('dashboard/warehouse-kuningan/keluar/edit/') . $row->id . '" role="button"><i class="fas fa-sm fa-pen"></i></a>
            <button class="btn btn-danger delete-pengeluaran" title="Hapus Bray" onclick="deleteKngKeluar(' . $row->id . ')" role="button"><i class="fas fa-sm fa-trash"></i></button></div>';
        }, 'last')->toJson(true);
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

        if ($nama_barang == null) {
            return json_encode([
                'message' => 'Data Barang Keluar Gagal ditambahkan, lengkapi data',
                'status' => false
            ]);
        } else if ($qty == null) {
            return json_encode([
                'message' => 'Data Barang Keluar Gagal ditambahkan, lengkapi data',
                'status' => false
            ]);
        } else if ($total_resi == null) {
            return json_encode([
                'message' => 'Data Barang Keluar Gagal ditambahkan, lengkapi data',
                'status' => false
            ]);
        } else if ($tanggal == null) {
            return json_encode([
                'message' => 'Data Barang Keluar Gagal ditambahkan, lengkapi data',
                'status' => false
            ]);
        }

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
        $upload_bukti = $this->request->getFile('upload_bukti');
        if ($upload_bukti) {
            // generate nama file random
            $namaFile = $upload_bukti->getRandomName();
            // pindahkan file ke folder img
            $upload_bukti->move('bukti-barang-masuk-kng', $namaFile);
        } else {
            return json_encode([
                'message' => 'Data Barang Keluar Gagal ditambahkan, lengkapi data',
                'status' => false
            ]);
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
            return json_encode([
                'status' => true,
                'message' => 'Data Barang Keluar Berhasil ditambahkan'
            ]);
        } else {
            return json_encode(
                [
                    'status' => false,
                    'message' => 'Data Barang Keluar Gagal ditambahkan, lengkapi data'
                ]
            );
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
        $upload_bukti = $this->request->getFile('upload_bukti');
        $bukti_transfer_lama = $this->request->getPost('bukti_transfer_lama');

        // cek apakah ada file yang diupload
        if ($upload_bukti) {
            // generate nama file random
            $namaFile = $upload_bukti->getRandomName();
            // pindahkan file ke folder img
            $upload_bukti->move('bukti-barang-masuk-kng', $namaFile);
            // hapus file lama
            try {
                unlink('bukti-barang-masuk-kng/' . $bukti_transfer_lama);
            } catch (\Throwable $th) {
                return json_encode([
                    'message' => $th->getMessage(),
                    'status' => false
                ]);
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
                return json_encode([
                    'status' => true,
                    'message' => 'Data Barang Keluar Berhasil diupdate'
                ]);
            } else {
                return json_encode([
                    'status' => false,
                    'message' => 'Data Barang Keluar Gagal diupdate, lengkapi data'
                ]);
            }
        } else {
            $namaFile = $bukti_transfer_lama;
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
    }

    public function deleteBarangKeluar()
    {
        $id = $this->request->getPost('id');
        // unlink $bukti_pickup
        $barang_keluar = $this->barang_keluar->find($id);

        // mendapatkan qty dari barang masuk where nama barang
        $barang_masuk = $this->barang_masuk->where('nama_barang', $barang_keluar['nama_barang'])->first();
        $qtyBarangMasuk = $barang_masuk['qty'];
        $tambahQty = $qtyBarangMasuk + $barang_keluar['qty'];

        // update barang_masuk dengan mengurangi qty yang didatabase dengan qty dari form
        $this->barang_masuk->update($barang_masuk['id'], [
            'qty' => $tambahQty
        ]);

        unlink('bukti-barang-masuk-kng/' . $barang_keluar['bukti_pickup']);
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
        $jenis_barang_masuk = $this->request->getPost('jenis_barang_masuk');
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
                'jenis_barang_masuk' => $jenis_barang_masuk, // 'barang_return' atau 'barang_baru
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

        // mendapatkan qty dari barang masuk where nama barang
        $barang_masuk = $this->barang_masuk->where('nama_barang', $barang_keluar['nama_barang'])->first();
        $qtyBarangMasuk = $barang_masuk['qty'];
        $tambahQty = $qtyBarangMasuk - $barang_keluar['qty'];

        // update barang_masuk dengan mengurangi qty yang didatabase dengan qty dari form
        $this->barang_masuk->update($barang_masuk['id'], [
            'qty' => $tambahQty
        ]);

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
        $jenis_barang = $this->request->getPost('jenis_barang_masuk');

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
            'jenis_barang_masuk' => $jenis_barang,
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
