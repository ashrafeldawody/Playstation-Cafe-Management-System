<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\deviceCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\DeviceCategory;
use Illuminate\Http\Request;

class DeviceCategoryController extends Controller
{
    public function index(deviceCategoryDataTable $dataTable)
    {
        return $dataTable->render('dashboard.device-categories.index');
    }

    public function create()
    {
        return view('dashboard.device-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'multi_price' => 'numeric',
            'discount' => 'numeric',
        ]);
        DeviceCategory::create($request->all());

        return redirect()->route('device-categories.index');
    }

    public function edit(DeviceCategory $deviceCategory)
    {
        return view('dashboard.device-categories.edit', compact('deviceCategory'));
    }

    public function update(Request $request, DeviceCategory $deviceCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'multi_price' => 'numeric',
            'discount' => 'numeric',
        ]);

        $deviceCategory->update($request->all());

        return redirect()->route('device-categories.index');
    }

    public function destroy(DeviceCategory $deviceCategory)
    {
        try {
            $deviceCategory->delete();
            return redirect()->route('device-categories.index');
        } catch (\Exception $e) {
            return redirect()->route('device-categories.index')->with('error', 'لا يمكن حذف هذا النوع لوجود اجهزة مرتبطة به');
        }}

}
