<?php

namespace App\Http\Controllers\POS;

use App\DataTables\ExpenseDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(ExpenseDataTable $dataTable)
    {
        $title = 'المصروفات';
        return $dataTable->render('common.table-page', compact('title'));
    }
}
