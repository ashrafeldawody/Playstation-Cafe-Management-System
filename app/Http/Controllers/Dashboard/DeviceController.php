<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\DevicesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(DevicesDataTable $dataTable)
    {
        return $dataTable->render('dashboard.devices.index');
    }
    public function create()
    {
        return view('dashboard.devices.create');
    }
    public function delete($id)
    {
        $device = Device::findOrFail($id);
        return view('dashboard.devices.delete', compact('device'));
    }
}
