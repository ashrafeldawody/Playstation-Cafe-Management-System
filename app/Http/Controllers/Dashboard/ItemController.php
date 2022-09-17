<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\ItemDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(ItemDataTable $dataTable)
    {
        return $dataTable->render('dashboard.items.index');
    }
}
