<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\DevicesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\DeviceCategory;
use App\Models\Game;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index(DevicesDataTable $dataTable)
    {
        return $dataTable->render('dashboard.devices.index');
    }
    public function create()
    {
        $deviceCategories = DeviceCategory::all();
        $games = Game::all();
        return view('dashboard.devices.create', compact('deviceCategories', 'games'));
    }

    public function edit(Device $device)
    {
        $deviceCategories = DeviceCategory::all();
        $games = Game::all();
        return view('dashboard.devices.edit', compact('device', 'deviceCategories', 'games'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'devices_category_id' => 'required'
        ]);
        $device = Device::create($request->except('games'));
        $device->games()->sync($request->games);

        return redirect()->route('devices.index')->with('success', 'تم إضافة الجهاز بنجاح');
    }


    public function destroy(Device $device)
    {
        try {
            $device->delete();
            return redirect()->route('devices.index')->with('success', 'تم حذف الجهاز بنجاح');
        } catch (\Exception $ex) {
            return redirect()->route('devices.index')->with('error', 'حدث خطأ ما يرجى المحاولة لاحقا');
        }
    }
}
