<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\CafeBillItem;
use App\Models\Inventory;
use App\Models\Item;
use App\Models\ItemCategory;
use App\Models\Shift;
use Illuminate\Http\Request;

class CafeController extends Controller
{
    public function index()
    {
        return ItemCategory::with('items')->get();
    }
    public function list(Request $request)
    {
        $items = Item::select('id','name')->get();
        return response()->json($items);
    }
    public function addInventoryItem(Request $request)
    {
        Inventory::create([
            'item_id' => $request->item_id,
            'quantity' => $request->quantity,
            'type' => 'BUY',
        ]);
        return response()->json(['message' => 'Item added to inventory'], 201);
    }

    public function save(Request $request)
    {
        if(count($request->cart) == 0)
            return response()->json(['message' => 'لا يوجد منتجات'], 400);
        $bill = Bill::create([
            'shift_id' => Shift::where('end_time', null)->first()->id
        ]);
        CafeBillItem::where('bill_id',$bill->id)->delete();
        $total = 0;
        foreach ($request->cart as $item) {
            CafeBillItem::create([
                    'bill_id' => $bill->id,
                    'item_id' => $item['item_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            $total += $item['price'] * $item['quantity'];
        }
        $bill->update([
            'cafe_total'=> $total,
            'paid' => $request->paid
        ]);
        return response()->json(null,200);
    }
    public function getInventory()
    {
        $inventory = Item::all();
        return response()->json($inventory);
    }
}
