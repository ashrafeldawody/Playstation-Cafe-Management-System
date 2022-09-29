<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = Item::all();
        return view('pos.shop.index', compact('items'));
    }

}
