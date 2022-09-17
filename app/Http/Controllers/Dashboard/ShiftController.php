<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\ShiftDataTable;
use App\Http\Controllers\Controller;

class ShiftController extends Controller
{
    public function index(ShiftDataTable $dataTable)
    {
        return $dataTable->render('dashboard.shifts.index');
    }
}
