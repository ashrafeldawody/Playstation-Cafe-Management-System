<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\SettingDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(SettingDataTable $dataTable)
    {
        return $dataTable->render('dashboard.settings.index');
    }
    public function store(Request $request){
        dd($request->all());
    }
}
