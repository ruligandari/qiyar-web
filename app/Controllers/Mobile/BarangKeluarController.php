<?php

namespace App\Controllers\Mobile;

use App\Controllers\BaseController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class BarangKeluarController extends BaseController
{
    protected $barang_keluar_jkt;
    protected $master_jkt;
    protected $stok_barang_jkt;

    public function __construct()
    {
        $this->barang_keluar_jkt = new \App\Models\BarangKeluarJktModel();
        $this->master_jkt = new \App\Models\BarangMasukJktModel();
        $this->stok_barang_jkt = new \App\Models\StokBarangJktModel();
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
        
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');

        $stokModel = $this->barang_keluar_jkt;

        if ($search) {
            $stokModel->like('nama_barang', $search);
        }
        
        if ($startDate && $endDate) {
            $stokModel->where("tanggal >=", $startDate)->where("tanggal <=", $endDate);
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

    public function addBulk()
    {
        // Accept JSON because we will send complex data
        $input = json_decode($this->request->getBody(), true);
        
        if (!$input || !isset($input['items'])) {
            return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'Invalid Data']);
        }

        $items = $input['items'];
        $resi = $input['resi'];
        $date = date('Y-m-d');
        
        if (empty($resi)) {
             return $this->response->setJSON(['status' => 'error', 'message' => 'Resi wajib diisi']);
        }

        $successCount = 0;
        $errors = [];
        
        // Start Transaction
        $db = \Config\Database::connect();
        $db->transStart();

        foreach($items as $item) {
            $idMaster = $item['id_barang'];
            $qty = $item['qty'];
            $nama_barang = $item['nama_barang'];

            // 1. Get Master Stock
            // We use share lock or just simple find
            $masterData = $this->master_jkt->find($idMaster);
            
            if(!$masterData) {
                $errors[] = "$nama_barang tidak ditemukan.";
                continue;
            }

            // 2. Check Stock Availability
            if($masterData['qty'] < $qty) {
                 $errors[] = "stok barang $nama_barang sisa {$masterData['qty']} silahkan perbarui stok di master barang";
                 continue; 
            }

            // 3. Insert to Barang Keluar Log
            $data = [
                'nama_barang' => $nama_barang,
                'qty' => $qty,
                'tanggal' => $date,
                'total_resi' => 1, 
                'resi' => $resi,
            ];
            $this->barang_keluar_jkt->insert($data);

            // 4. Update Master Stock (Atomic Update)
            $this->master_jkt->where('id', $idMaster)->set('qty', 'qty - ' . $qty, false)->update();

            $successCount++;
        }
        
        $db->transComplete();

        if (count($errors) > 0) {
             // If absolute failure (0 successes), show just errors
             // If partial, show errors + success info
             $msg = implode("\n", $errors);
             if($successCount > 0) {
                 $msg .= "\n($successCount barang berhasil disimpan)";
             }

             return $this->response->setJSON([
                'status' => 'partial', 
                'message' => $msg,
                'errors' => $errors
            ]);
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

    public function exportExcel()
    {
        $startDate = $this->request->getGet('start_date');
        $endDate = $this->request->getGet('end_date');

        // Create Period Info String
        $periodeInfo = 'Periode: Semua Data';
        if ($startDate && $endDate) {
            $periodeInfo = "Periode: $startDate s/d $endDate";
        }

        $spreadsheet = new Spreadsheet();
        
        // Define Header Style
        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF4CAF50'], // Green
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ];

        $tableBodyStyle = [
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ];

        // ==========================================
        // SHEET 1: BARANG KELUAR
        // ==========================================
        $builderKeluar = $this->barang_keluar_jkt->builder();
        $builderKeluar->select('id, tanggal, nama_barang, qty, total_resi, resi');

        if ($startDate && $endDate) {
            $builderKeluar->where('tanggal >=', $startDate)->where('tanggal <=', $endDate);
        }
        $dataKeluar = $builderKeluar->get()->getResultArray();

        $sheet1 = $spreadsheet->getActiveSheet();
        $sheet1->setTitle('Barang Keluar');
        
        // Timestamp Header
        $exportTime = 'Waktu Export: ' . date('d-m-Y H:i:s');
        $sheet1->setCellValue('A1', $exportTime);
        $sheet1->mergeCells('A1:E1');

        // Periode Header
        $sheet1->setCellValue('A2', $periodeInfo);
        $sheet1->mergeCells('A2:E2');

        // Main Table Headers (Shifted to Row 4)
        $headers1 = ['No', 'Tanggal', 'Nama Barang', 'Qty', 'Resi', 'Total Resi'];
        $sheet1->fromArray($headers1, NULL, 'A4');
        $sheet1->getStyle('A4:F4')->applyFromArray($headerStyle);

        // Data & Summary Logic
        $row1 = 5;
        $no1 = 1;
        $summaryKeluar = [];

        foreach ($dataKeluar as $item) {
            $sheet1->setCellValue('A' . $row1, $no1++);
            $sheet1->setCellValue('B' . $row1, $item['tanggal']);
            $sheet1->setCellValue('C' . $row1, $item['nama_barang']);
            $sheet1->setCellValue('D' . $row1, $item['qty']);
            $sheet1->setCellValue('E' . $row1, $item['resi']);
            $sheet1->setCellValue('F' . $row1, $item['total_resi']);
            
            // Calculate Summary
            $nama = $item['nama_barang'];
            if (!isset($summaryKeluar[$nama])) {
                $summaryKeluar[$nama] = ['qty' => 0, 'total_resi' => 0];
            }
            $summaryKeluar[$nama]['qty'] += $item['qty'];
            $summaryKeluar[$nama]['total_resi'] += $item['total_resi'];

            $row1++;
        }
        
        // Apply Borders to Main Table
        if ($row1 > 5) {
             $sheet1->getStyle('A5:F' . ($row1 - 1))->applyFromArray($tableBodyStyle);
        }

        // Summary Table (Column H)
        $sumStartRow = 4; // Shifted to align with main table header
        $sheet1->setCellValue('H' . $sumStartRow, 'REKAP DATA');
        $sheet1->mergeCells('H4:K4');
        $sheet1->getStyle('H4:K4')->applyFromArray(array_merge($headerStyle, ['fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF2196F3']]])); // Blue header

        $sheet1->setCellValue('H5', 'No');
        $sheet1->setCellValue('I5', 'Nama Barang');
        $sheet1->setCellValue('J5', 'Total Qty');
        $sheet1->setCellValue('K5', 'Total Resi');
        $sheet1->getStyle('H5:K5')->applyFromArray($headerStyle);

        $rowSum1 = 6;
        $noSum1 = 1;
        foreach ($summaryKeluar as $nama => $stats) {
            $sheet1->setCellValue('H' . $rowSum1, $noSum1++);
            $sheet1->setCellValue('I' . $rowSum1, $nama);
            $sheet1->setCellValue('J' . $rowSum1, $stats['qty']);
            $sheet1->setCellValue('K' . $rowSum1, $stats['total_resi']);
            $rowSum1++;
        }
        
        // Apply Borders to Summary Table
        if ($rowSum1 > 6) {
            $sheet1->getStyle('H6:K' . ($rowSum1 - 1))->applyFromArray($tableBodyStyle);
        }

        // Auto Size Columns
        foreach (range('A', 'K') as $col) {
            $sheet1->getColumnDimension($col)->setAutoSize(true);
        }

        // ==========================================
        // SHEET 2: BARANG MASUK
        // ==========================================
        $builderMasuk = $this->stok_barang_jkt->builder();
        $builderMasuk->select('id, tanggal, nama_barang, qty, jenis_barang_masuk');

        if ($startDate && $endDate) {
            $builderMasuk->where('tanggal >=', $startDate)->where('tanggal <=', $endDate);
        }
        $dataMasuk = $builderMasuk->get()->getResultArray();

        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Barang Masuk');

        // Timestamp Header
        $sheet2->setCellValue('A1', $exportTime);
        $sheet2->mergeCells('A1:E1');
        
        // Periode Header
        $sheet2->setCellValue('A2', $periodeInfo);
        $sheet2->mergeCells('A2:E2');

        // Main Table Headers (Shifted to Row 4)
        $headers2 = ['No', 'Tanggal', 'Nama Barang', 'Qty', 'Jenis Masuk'];
        $sheet2->fromArray($headers2, NULL, 'A4');
        $sheet2->getStyle('A4:E4')->applyFromArray($headerStyle);

        $row2 = 5;
        $no2 = 1;
        $summaryMasuk = [];

        foreach ($dataMasuk as $item) {
            $sheet2->setCellValue('A' . $row2, $no2++);
            $sheet2->setCellValue('B' . $row2, $item['tanggal']);
            $sheet2->setCellValue('C' . $row2, $item['nama_barang']);
            $sheet2->setCellValue('D' . $row2, $item['qty']);
            $sheet2->setCellValue('E' . $row2, $item['jenis_barang_masuk']);

            // Calculate Summary (Group by Name AND Type)
            $key = $item['nama_barang'] . '||' . $item['jenis_barang_masuk'];
            if (!isset($summaryMasuk[$key])) {
                $summaryMasuk[$key] = [
                    'nama' => $item['nama_barang'],
                    'jenis' => $item['jenis_barang_masuk'],
                    'qty' => 0
                ];
            }
            $summaryMasuk[$key]['qty'] += $item['qty'];

            $row2++;
        }

        // Apply Borders to Main Table
        if ($row2 > 5) {
             $sheet2->getStyle('A5:E' . ($row2 - 1))->applyFromArray($tableBodyStyle);
        }

        // Summary Table (Column G)
        $sumStartRow2 = 4;
        $sheet2->setCellValue('G' . $sumStartRow2, 'REKAP DATA');
        $sheet2->mergeCells('G4:J4');
        $sheet2->getStyle('G4:J4')->applyFromArray(array_merge($headerStyle, ['fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF2196F3']]]));

        $sheet2->setCellValue('G5', 'No');
        $sheet2->setCellValue('H5', 'Nama Barang');
        $sheet2->setCellValue('I5', 'Jenis Masuk');
        $sheet2->setCellValue('J5', 'Total Qty');
        $sheet2->getStyle('G5:J5')->applyFromArray($headerStyle);

        $rowSum2 = 6;
        $noSum2 = 1;
        
        // Sort summary by name for better readability
        ksort($summaryMasuk);

        foreach ($summaryMasuk as $stats) {
            $sheet2->setCellValue('G' . $rowSum2, $noSum2++);
            $sheet2->setCellValue('H' . $rowSum2, $stats['nama']);
            $sheet2->setCellValue('I' . $rowSum2, $stats['jenis']);
            $sheet2->setCellValue('J' . $rowSum2, $stats['qty']);
            $rowSum2++;
        }

        // Apply Borders to Summary Table
        if ($rowSum2 > 6) {
            $sheet2->getStyle('G6:J' . ($rowSum2 - 1))->applyFromArray($tableBodyStyle);
        }

        foreach (range('A', 'J') as $col) {
            $sheet2->getColumnDimension($col)->setAutoSize(true);
        }

        // ==========================================
        // SHEET 3: SISA STOK
        // ==========================================
        // 1. Get unique items involved in Barang Keluar
        $includedItems = array_unique(array_column($dataKeluar, 'nama_barang'));
        
        // 2. Fetch Current Stock for these items
        if (!empty($includedItems)) {
            $currentStocks = $this->master_jkt->whereIn('nama_barang', $includedItems)->findAll();
        } else {
            $currentStocks = [];
        }

        $sheet3 = $spreadsheet->createSheet();
        $sheet3->setTitle('Sisa Stok');

        // Timestamp Header
        $sheet3->setCellValue('A1', $exportTime);
        $sheet3->mergeCells('A1:C1');

        // Periode Header
        $sheet3->setCellValue('A2', $periodeInfo);
        $sheet3->mergeCells('A2:C2');

        // Headers (Shifted to Row 4)
        $headers3 = ['No', 'Nama Barang', 'Sisa Stok Saat Ini'];
        $sheet3->fromArray($headers3, NULL, 'A4');
        $sheet3->getStyle('A4:C4')->applyFromArray($headerStyle);

        $row3 = 5;
        $no3 = 1;

        // Map stocks for easy lookup or just iterate result if it matches 1-to-1 unique names
        // But better to loop through $currentStocks as that is the source of truth for Qty
        foreach ($currentStocks as $stock) {
            $sheet3->setCellValue('A' . $row3, $no3++);
            $sheet3->setCellValue('B' . $row3, $stock['nama_barang']);
            $sheet3->setCellValue('C' . $row3, $stock['qty']);
            $row3++;
        }

        // Apply Borders
        if ($row3 > 5) {
             $sheet3->getStyle('A5:C' . ($row3 - 1))->applyFromArray($tableBodyStyle);
        }

        foreach (range('A', 'C') as $col) {
            $sheet3->getColumnDimension($col)->setAutoSize(true);
        }

        // Reset Active Sheet
        $spreadsheet->setActiveSheetIndex(0);

        $writer = new Xlsx($spreadsheet);
        
        if ($startDate && $endDate) {
            $filename = "Laporan_Stok_Periode_{$startDate}_sd_{$endDate}";
        } else {
            $filename = 'Laporan_Stok_All_' . date('Y-m-d_H-i-s');
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }

    public function checkResi()
    {
        $resi = $this->request->getPost('resi');
        if(!$resi) return $this->response->setJSON(['status' => 'error', 'message' => 'Resi empty']);

        $exists = $this->barang_keluar_jkt->where('resi', $resi)->countAllResults() > 0;
        
        return $this->response->setJSON(['status' => 'success', 'exists' => $exists]);
    }
}
