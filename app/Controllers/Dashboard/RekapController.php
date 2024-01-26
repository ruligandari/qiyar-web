<?php

namespace App\Controllers\Dashboard;

use App\Controllers\BaseController;
use App\Models\RekapIklanModel;
use Hermawan\DataTables\DataTable;
use DateTime;

class RekapController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Rekap Data',
        ];

        return view('dashboard/rekap/index', $data);
    }

    public function dataRekap()
    {
        $rekapIklanModel = new RekapIklanModel();
        $dates = $this->request->getVar('dates');
        $id_adv = $this->request->getPost('id_adv');
        $dates = explode(' - ', $dates);
        $min = DateTime::createFromFormat('m/d/Y', $dates[0])->format('Y-m-d');
        $max = DateTime::createFromFormat('m/d/Y', $dates[1])->format('Y-m-d');

        $data = $rekapIklanModel->where('tanggal >=', $min)->where('tanggal <=', $max)->where('id_adv', $id_adv)->find();
        return json_encode($data);
    }

    function detailPengiriman()
    {
        $id_order = $this->request->getPost('id_order');
        $rekapIklanModel = new RekapIklanModel();
        $data = $rekapIklanModel->where('id_order', $id_order)->find();
        return json_encode($data);
    }

    public function list()
    {
        $id_adv = $this->request->getPost('id_adv');
        $db = db_connect();
        $builder = $db->table('rekap_iklan')->select('id_order, tanggal,name, product, hpp_barang, nominal_cod,fee_cod, setelah_diskon,laba, remarks')->where('id_adv', $id_adv);
        return DataTable::of($builder)->addNumbering()->filter(function ($builder, $request) {
            if ($request->remarks) {
                $builder->where('remarks', $request->remarks)->where('id_adv', $request->id_adv);
            } else if ($request->dates) {
                // ambil rentang tanggal 09/01/2023 - 09/01/2023
                $dates = explode(' - ', $request->dates);
                $min = DateTime::createFromFormat('m/d/Y', $dates[0])->format('Y-m-d');
                $max = DateTime::createFromFormat('m/d/Y', $dates[1])->format('Y-m-d');
                $builder->where('tanggal >=', $min)->where('tanggal <=', $max);
            }
        })->add('action', function ($row) {
            return '<div class="dropdown no-arrow">
            <button class="dropdown-toggle btn btn-transparent" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" role="button" data-toggle="modal" data-target="#detail-pengiriman" onClick="detailPengiriman(' . $row->id_order . ')">Detail Pengiriman</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-secondary" href="#">Edit</a>
                <a class="dropdown-item text-danger" href="' . base_url('dashboard/rekap/delete-rekap/') . $row->id_order . '">Hapus</a>
            </div>
        </div>';
        }, 'last')->toJson();
    }

    public function downloadFile()
    {
        $path = 'rekap/template_rekap.xlsx';
        return $this->response->download($path, null);
    }

    public function import()
    {
        $rekapIklanModel = new RekapIklanModel();
        $fileEcxel = $this->request->getFile('file_excel');
        $checkExt = $fileEcxel->getClientExtension();
        $id_adv = $this->request->getPost('id_adv');

        if ($checkExt == 'xlsx' || $checkExt == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet = $render->load($fileEcxel);
        $dataExcel = $spreadsheet->getActiveSheet()->toArray();
        $dataLenght = 0;
        foreach ($dataExcel as $x => $row) {
            if ($x == 0) {
                continue;
            }
            // hanya memasukan data yang memiliki order_id
            if ($row[1] == '') {
                continue;
            }

            // order_id tanggal	product	name	resi 	pengirim	remarks	barang	qty	hpp_barang	laba	phone	nominal_cod	fee_cod	biaya_standar_pengiriman	pengiriman_setelah_diskon	setelah_diskon	address	province	city	subdistrict	zip	status	payment_status	payment_method	payment_info	product_price
            // pisahkan tanggal 6/10/2023 menjadi 2023-10-06
            $data = [
                'id_adv' => $id_adv,
                'id_order' => $row[1],
                'tanggal' => $row[0],
                'product' => $row[2],
                'name' => $row[3],
                'resi' => $row[4],
                'pengirim' => $row[5],
                'remarks' => $row[6],
                'barang' => $row[7],
                'qty' => $row[8],
                'hpp_barang' => $row[9],
                'laba' => $row[10],
                'phone' => $row[11],
                'nominal_cod' => $row[12],
                'fee_cod' => $row[13],
                'biaya_standar_pengiriman' => $row[14],
                'pengiriman_setelah_diskon' => $row[15],
                'setelah_diskon' => $row[16],
                'address' => $row[17],
                'province' => $row[18],
                'city' => $row[19],
                'subdistrict' => $row[20],
                'zip' => $row[21],
                'status' => $row[22],
                'payment_status' => $row[23],
                'payment_method' => $row[24],
                'payment_info' => $row[25],
                'product_price' => $row[26],
            ];

            // check order_id apakah ada yang sama
            $checkOrderId = $rekapIklanModel->where('id_order', $row[1])->findAll();
            if (count($checkOrderId) > 0) {
                return redirect()->back()->with('error', 'Order ID' . $row[1] . 'sudah ada');
            } else {
                $rekapIklanModel->insert($data);
                // simpan excel dengan nama file yang berbeda kombinasi tanggal dan random string
                $dataLenght++;
            }
        }

        return redirect()->back()->with('success', 'Data berhasil import ' . $dataLenght . ' data');
    }
}
