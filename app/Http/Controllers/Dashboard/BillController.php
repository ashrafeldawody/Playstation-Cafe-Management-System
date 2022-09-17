<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\BillDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function index(BillDataTable $dataTable)
    {
        return $dataTable->render('dashboard.bills.index');
    }
}
