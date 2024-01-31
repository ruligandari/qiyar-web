<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use \Hermawan\DataTables\DataTable;

use DateTime;

class WarehouseJakartaController extends BaseController
{
    function __construct()
    {
        $this->barang_masuk = new \App\Models\BarangMasukJktModel();
        $this->barang_keluar = new \App\Models\BarangKeluarJktModel();
        $this->stok_barang = new \App\Models\StokBarangJktModel();
    }
    public function index()
    {
        $barangMasuk = $this->barang_masuk->findAll();
        $barangKeluar = $this->barang_keluar->findAll();
        $data = [
            'title' => 'Warehouse - jakarta',
            'barangmasuk' => $barangMasuk,
            'barangkeluar' => $barangKeluar,
        ];
        return view('dashboard/warehouse/jakarta/warehouse', $data);
    }
    public function tambahBarangMasuk()
    {

        $data = [
            'title' => 'Warehouse - jakarta',

        ];
        return view('dashboard/warehouse/jakarta/tambahbarangmasuk-jakarta', $data);
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
            return redirect()->to('/dashboard/warehouse-jakarta')->with('success', 'Data Berhasil Ditambahkan!');
        } else {
            return redirect()->to('/dashboard/warehouse-jakarta/tambah')->withInput()->with('error', 'Data Gagal Ditambahkan!, Silahkan Periksa Kembali');
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
            'title' => 'Warehouse - jakarta',
            'data' => $barangMasuk

        ];
        return view('dashboard/warehouse/jakarta/editbarangmasuk-jakarta', $data);
    }

    public function updateBarangMasuk()
    {
        $id = $this->request->getPost('id');
        $nama_barang = $this->request->getPost('nama_barang');
        $qty = $this->request->getPost('qty');
        $hpp = $this->request->getPost('hpp');
        $hppString = str_replace(',', '', $hpp);
        if ($hpp != '') {
            if (!is_numeric($hppString)) {
                return redirect()->to('/dashboard/warehouse-jakarta/edit/' . $id)->withInput()->with('error', 'Data HPP harus berupa angka!');
            }
            $data = [
                'nama_barang' => $nama_barang,
                'qty' => $qty,
                'hpp' => $hppString,
            ];
        } else {
            $data = [
                'nama_barang' => $nama_barang,
                'qty' => $qty,
            ];
        }

        if ($data) {
            // insert data 
            $this->barang_masuk->update($id, $data);
            return redirect()->to('/dashboard/warehouse-jakarta')->with('success', 'Data Berhasil Diupdate!');
        } else {
            return redirect()->to('/dashboard/warehouse-jakarta/edit/' . $id)->withInput()->with('error', 'Data Gagal Diupdate!, Silahkan Periksa Kembali');
        }
    }

    public function tambahBarangKeluar()
    {
        $barang_masuk = $this->barang_masuk->findAll();
        $data = [
            'title' => 'Warehouse - jakarta',
            'barangmasuk' => $barang_masuk

        ];
        return view('dashboard/warehouse/jakarta/tambahbarangkeluar-jakarta', $data);
    }

    public function addBarangKeluar()
    {
        $tanggal = $this->request->getPost('tanggal');
        $nama_barang = $this->request->getPost('nama_barang');
        $qty = $this->request->getPost('qty');
        $total_resi = $this->request->getPost('total_resi');
        // cek jumlah array $nama barang

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
            $upload_bukti->move('bukti-barang-masuk-jkt', $namaFile);
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

        if ($this->barang_keluar->insert($data)) {
            // insert data 
            return json_encode([
                'message' => 'Data Barang Keluar Berhasil ditambahkan.',
                'status' => true
            ]);
        } else {
            return json_encode([
                'message' => 'Data Barang Keluar Gagal ditambahkan, lengkapi data',
                'status' => false
            ]);
        }
    }

    public function editBarangKeluar($id)
    {
        $barangkeluar = $this->barang_keluar->find($id);
        $id = $this->barang_masuk->where('nama_barang', $barangkeluar['nama_barang'])->first();
        $barang_masuk = $this->barang_masuk->where('nama_barang !=', $barangkeluar['nama_barang'])->findAll();

        $data = [
            'title' => 'Warehouse - jakarta',
            'data' => $barangkeluar,
            'barang' => $barang_masuk,
            'id_barang_masuk' => $id['id']

        ];
        return view('dashboard/warehouse/jakarta/editbarangkeluar-jakarta', $data);
    }

    public function updateBarangKeluar()
    {
        $id = $this->request->getPost('id');
        $nama_barang = $this->request->getPost('nama_barang');
        $qty = $this->request->getVar('qty');
        $qty_lama = $this->request->getVar('qty_lama');
        $total_resi = $this->request->getPost('total_resi');
        $upload_bukti = $this->request->getFile('upload_bukti');
        $bukti_transfer_lama = $this->request->getPost('bukti_transfer_lama');

        // cek apakah ada file yang diupload
        if ($upload_bukti) {
            // return json_encode(['data' => $upload_bukti->getName(), 'status' => false]);
            // generate nama file random
            $namaFile = $upload_bukti->getRandomName();
            // pindahkan file ke folder img
            $upload_bukti->move('bukti-barang-masuk-jkt', $namaFile);
            // hapus file lama
            try {
                unlink('bukti-barang-masuk-jkt/' . $bukti_transfer_lama);
            } catch (\Throwable $th) {
                json_encode(['data' => $th->getMessage(), 'status' => false]);
            }

            // return json_encode(['data' => $bukti_transfer_lama, 'status' => false]);
            $barang_masuk = $this->barang_masuk->find($nama_barang);

            if ($qty != $qty_lama) {
                // update barang_masuk dengan mengurangi qty yang didatabase dengan qty dari form
                $kurangQty = $barang_masuk['qty'] + $qty_lama;
                $tambahQty = $kurangQty - $qty;
                return json_encode(['data' => $tambahQty, 'status' => false]);
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
                // unlink('bukti-barang-masuk-jkt/' . $bukti_transfer_lama);
                return json_encode(['message' => 'Data Barang Keluar Berhasil diupdate.', 'status' => true]);
            } else {
                return json_encode(['message' => 'Data Barang Keluar Gagal diupdate.', 'status' => false]);
            }
        } else {
            $namaFile = $bukti_transfer_lama;
            $barang_masuk = $this->barang_masuk->find($nama_barang);

            if ($qty != $qty_lama) {
                // update barang_masuk dengan mengurangi qty yang didatabase dengan qty dari form
                $kurangQty = $barang_masuk['qty'] + $qty_lama;
                $tambahQty = $kurangQty - $qty;
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
                return redirect()->to('/dashboard/warehouse-jakarta')->with('success', 'Data Berhasil Diupdate!');
            } else {
                return redirect()->to('/dashboard/warehouse-jakarta/keluar/edit/' . $id)->withInput()->with('error', 'Data Gagal Diupdate!, Silahkan Periksa Kembali');
            }
        }
    }

    public function deleteBarangKeluar()
    {
        $id = $this->request->getPost('id');
        // unlink $bukti_pickup
        $barang_keluar = $this->barang_keluar->find($id);

        // mendapatkan data stok
        $qty_barang_masuk = $this->barang_masuk->where('nama_barang', $barang_keluar['nama_barang'])->first();
        $qty_barang_keluar = $barang_keluar['qty'];

        // tambah qty ke barang_masuk
        $tambah_qty = $qty_barang_masuk['qty'] + $qty_barang_keluar;

        $this->barang_masuk->update($qty_barang_masuk['id'], [
            'qty' => $tambah_qty
        ]);



        if ($barang_keluar['bukti_pickup'] == true) {
            unlink('bukti-barang-masuk-jkt/' . $barang_keluar['bukti_pickup']);
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
        } else {
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
    }

    public function stokBarang()
    {
        $stok = $this->stok_barang->findAll();
        $data = [
            'title' => 'Warehouse - jakarta',
            'stok' => $stok
        ];

        return view('dashboard/warehouse/jakarta/stokbarang-jakarta', $data);
    }
    public function tambahStokBarang()
    {
        $barang_masuk = $this->barang_masuk->findAll();
        $data = [
            'title' => 'Warehouse - jakarta',
            'barang_masuk' => $barang_masuk
        ];

        return view('dashboard/warehouse/jakarta/updatestokbarang-jakarta', $data);
    }

    public function addStokBarang()
    {
        $tanggal = $this->request->getPost('tanggal');
        $nama_barang_form = $this->request->getPost('nama_barang');
        $qty = $this->request->getPost('qty');
        $jenis_barang_masuk = $this->request->getPost('jenis_barang_masuk');
        $upload_bukti = $this->request->getFile('upload_bukti');

        if ($nama_barang_form == null) {
            return json_encode([
                'message' => 'Stok Barang Gagal ditambahkan, lengkapi data',
                'status' => false
            ]);
        } else if ($qty == null) {
            return json_encode([
                'message' => 'Stok Barang Gagal ditambahkan, lengkapi data',
                'status' => false
            ]);
        } else if ($jenis_barang_masuk == null) {
            return json_encode([
                'message' => 'Stok Barang Gagal ditambahkan, lengkapi data',
                'status' => false
            ]);
        } else if ($tanggal == null) {
            return json_encode([
                'message' => 'Stok Barang Gagal ditambahkan, lengkapi data',
                'status' => false
            ]);
        }

        // cek apakah ada file yang diupload
        // cek apakah ada file yang diupload
        $upload_bukti = $this->request->getFile('upload_bukti');
        if ($upload_bukti) {
            // generate nama file random
            $namaFile = $upload_bukti->getRandomName();
            // pindahkan file ke folder img
            $upload_bukti->move('bukti-barang-masuk-jkt', $namaFile);
        } else {
            return json_encode([
                'message' => 'Stok Barang Gagal ditambahkan, lengkapi data',
                'status' => false
            ]);
        }
        // mendapatkan nama_barang dari tabel barang masuk berdasarkan id
        $barang_masuk = $this->barang_masuk->find($nama_barang_form);
        $nama_barang = $barang_masuk['nama_barang'];

        if ($barang_masuk) {
            $data = [
                'tanggal' => $tanggal,
                'nama_barang' => $nama_barang,
                'qty' => $qty,
                'jenis_barang_masuk' => $jenis_barang_masuk,
                'upload_bukti' => $namaFile
            ];
            // update tabel barang_masuk
            $tambah_stok = $barang_masuk['qty'] + $qty;
            $update_stok = $this->barang_masuk->update($nama_barang_form, [
                'qty' => $tambah_stok
            ]);
            // insert
            $this->stok_barang->insert($data);
            return json_encode([
                'message' => 'Stok Barang Berhasil ditambahkan, lengkapi data',
                'status' => true
            ]);
        } else {
            return json_encode([
                'message' => 'Stok Barang Gagal ditambahkan, lengkapi data',
                'status' => false
            ]);
        }
    }

    public function deleteStokBarang()
    {
        $id = $this->request->getPost('id');

        // unlink $bukti_pickup
        $barang_keluar = $this->stok_barang->find($id);

        // mendapatkan data stok
        $qty_barang_masuk = $this->barang_masuk->where('nama_barang', $barang_keluar['nama_barang'])->first();
        $qty_barang_keluar = $barang_keluar['qty'];

        // tambah qty ke barang_masuk
        $tambah_qty = $qty_barang_masuk['qty'] - $qty_barang_keluar;

        $this->barang_masuk->update($qty_barang_masuk['id'], [
            'qty' => $tambah_qty
        ]);

        unlink('bukti-barang-masuk-jkt/' . $barang_keluar['upload_bukti']);
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
            'title' => 'Warehouse - jakarta',
            'data' => $stokBarang,
            'barang' => $barang,
            'id' => $idNamaBarang['id']

        ];
        return view('dashboard/warehouse/jakarta/editstokbarang-jakarta', $data);
    }

    public function updateStokBarang()
    {
        $id = $this->request->getPost('id');
        $tanggal = $this->request->getPost('tanggal');
        $nama_barang = $this->request->getPost('nama_barang');
        $qty = $this->request->getPost('qty');
        $qty_lama = $this->request->getPost('qty_lama');
        $upload_bukti = $this->request->getFile('upload_bukti');
        $jenis_barang_masuk = $this->request->getPost('jenis_barang_masuk');
        $bukti_transfer_lama = $this->request->getPost('bukti_transfer_lama');

        // cek apakah ada file yang diupload
        if ($upload_bukti) {
            // generate nama file random
            $namaFile = $upload_bukti->getRandomName();
            // pindahkan file ke folder img
            $upload_bukti->move('bukti-barang-masuk-jkt', $namaFile);
            // hapus file lama
            unlink('bukti-barang-masuk-jkt/' . $bukti_transfer_lama);
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
            'jenis_barang_masuk' => $jenis_barang_masuk,
            'upload_bukti' => $namaFile
        ];

        if ($data) {

            // insert data 
            $this->stok_barang->update($id, $data);
            // update qty barang_masuk
            $this->barang_masuk->update($nama_barang, [
                'qty' => $tambahQty
            ]);
            if ($upload_bukti) {

                return json_encode(['message' => 'Data Barang Berhasil diupdate.', 'status' => true]);
            }
            return redirect()->to('/dashboard/warehouse-jakarta/stok')->with('success', 'Data Berhasil Diupdate!');
        } else {
            return json_encode(['message' => 'Data Barang Keluar Gagal diupdate.', 'status' => false]);
        }
    }
    public function listBarangMasuk()
    {
        $db = db_connect();
        $builder = $db->table('barang_masuk_jkt')->select('id, tanggal, nama_barang, qty, hpp');
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
        })->format('hpp', function ($value) {
            if ($value == null) {
                $value = '0';
            }
            return number_format($value, 0, ',', '.');
        })->add('action', function ($row) {
            return '<div class="text-center"><a class="btn btn-success" title="Edit Bray" href="' . base_url('dashboard/warehouse-jakarta/edit/') . $row->id . '" role="button"><i class="fas fa-sm fa-pen"></i></a>
            <button class="btn btn-danger" title="Hapus Bray" onclick="deleteJktMasuk(' . $row->id . ')" role="button"><i class="fas fa-sm fa-trash"></i></button></div>';
        }, 'last')->toJson(true);
    }
    public function listBarangKeluarJkt()
    {
        $db = db_connect();
        $builder = $db->table('barang_keluar_jkt')->select('id, tanggal, nama_barang, qty, total_resi, bukti_pickup');
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
            return '<a href="' . base_url('bukti-barang-masuk-jkt/') . $value . '" target="_blank">
            <img src="' . base_url('bukti-barang-masuk-jkt/') . $value . '" alt="" style="height:50px; width:50px"></a>';
        })->add('action', function ($row) {
            return '<div class="text-center"><a class="btn btn-success" title="Edit Bray" href="' . base_url('dashboard/warehouse-jakarta/keluar/edit/') . $row->id . '" role="button"><i class="fas fa-sm fa-pen"></i></a>
            <button class="btn btn-danger" title="Hapus Bray" onclick="deleteJktKeluar(' . $row->id . ')" role="button"><i class="fas fa-sm fa-trash"></i></button></div>';
        }, 'last')->toJson(true);
    }
    public function listStokBarang()
    {
        $db = db_connect();
        $builder = $db->table('stok_barang_jkt')->select('id, tanggal, nama_barang, qty, jenis_barang_masuk, upload_bukti');
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
        })->format('upload_bukti', function ($value) {
            return '<a href="' . base_url('bukti-barang-masuk-jkt/') . $value . '" target="_blank">
            <img src="' . base_url('bukti-barang-masuk-jkt/') . $value . '" alt="" style="height:50px; width:50px"></a>';
        })->add('action', function ($row) {
            return '<div class="text-center"><a class="btn btn-success" title="Edit Bray" href="' . base_url('dashboard/warehouse-jakarta/stok/edit/') . $row->id . '" role="button"><i class="fas fa-sm fa-pen"></i></a>
            <button class="btn btn-danger" title="Hapus Bray" onclick="deleteStokJkt(' . $row->id . ')" role="button"><i class="fas fa-sm fa-trash"></i></button></div>';
        }, 'last')->toJson(true);
    }
}
