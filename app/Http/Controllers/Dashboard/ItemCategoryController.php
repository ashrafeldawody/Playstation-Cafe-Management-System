<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\itemsCategoryDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ItemCategoryController extends Controller
{
    public function index(itemsCategoryDataTable $dataTable)
    {
        return $dataTable->render('dashboard.items.index');
    }
}
