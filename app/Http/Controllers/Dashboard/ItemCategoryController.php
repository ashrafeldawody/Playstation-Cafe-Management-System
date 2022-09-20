<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\itemsCategoryDataTable;
use App\Http\Controllers\Controller;
use App\Models\ItemCategory;
use Illuminate\Http\Request;

class ItemCategoryController extends Controller
{
    public function index(itemsCategoryDataTable $dataTable)
    {
        return $dataTable->render('dashboard.item-categories.index');
    }

    public function create()
    {
        return view('dashboard.item-categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        ItemCategory::create($request->all());

        return redirect()->route('item-categories.index');
    }

    public function edit(ItemCategory $itemCategory)
    {
        return view('dashboard.item-categories.edit', compact('itemCategory'));
    }

    public function update(Request $request, ItemCategory $itemCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $itemCategory->update($request->all());

        return redirect()->route('item-categories.index');
    }

    public function destroy(ItemCategory $itemCategory)
    {
        try {
            $itemCategory->delete();
            return redirect()->route('item-categories.index');
        } catch (\Exception $e) {
            return redirect()->route('item-categories.index')->with('error', 'لا يمكن حذف هذا النوع لوجود اجهزة مرتبطة به');
        }
    }
}
