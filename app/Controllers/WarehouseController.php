<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class WarehouseController extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Warehouse',
            'active' => 'warehouse'
        ];
        return view('dashboard/warehouse/warehouse', $data);
    }
}
