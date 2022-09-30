<?php

namespace App\Http\Controllers\POS;

use App\DataTables\ItemDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CafeController extends Controller
{
    public function index(ItemDataTable $dataTable)
    {
        $title = 'المنتجات';
        return $dataTable->render('common.table-page', compact('title'));
    }
}
