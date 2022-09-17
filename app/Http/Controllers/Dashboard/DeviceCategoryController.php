<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\deviceCategoryDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeviceCategoryController extends Controller
{
    public function index(deviceCategoryDataTable $dataTable)
    {
        return $dataTable->render('dashboard.device-categories.index');
    }

}
