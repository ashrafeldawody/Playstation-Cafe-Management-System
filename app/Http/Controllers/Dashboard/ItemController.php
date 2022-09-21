<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\ItemDataTable;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(ItemDataTable $dataTable)
    {
        return $dataTable->render('dashboard.items.index');
    }

    public function create()
    {
        $itemCategories = ItemCategory::all();
        return view('dashboard.items.create',compact('itemCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'items_category_id' => 'numeric',
            'buy_price' => 'numeric',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $item = Item::create([
            'name' => $request->name,
            'price' => $request->price,
            'items_category_id' => $request->items_category_id,
            'buy_price' => $request->buy_price,
        ]);

        if ($request->hasFile('image')) {
            $item->update([
                'image' => $request->image->store('items','public'),
            ]);
        }
        return redirect()->route('items.index')->with('success','تمت الاضافة بنجاح');
    }

    public function edit(Item $item)
    {
        $itemCategories = ItemCategory::all();
        return view('dashboard.items.edit',compact('item','itemCategories'));
    }


    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'items_category_id' => 'numeric',
            'buy_price' => 'numeric',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $item->update($request->only(
            'name',
            'price',
            'items_category_id',
            'buy_price',
        ));
        if ($request->hasFile('image')) {
            $item->update([
                'image' => $request->image->store('items','public'),
            ]);
        }
        return redirect()->route('items.index')->with('success','تم التعديل بنجاح');

    }

    public function destroy(Item $item)
    {
        try {
            $item->delete();
            return redirect()->back()->with(['success' => 'تم الحذف بنجاح']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => 'حدث خطأ ما يرجى المحاولة لاحقا']);
        }
    }
}
