<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\itemsCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CafeController extends Controller
{
    public function index()
    {
        return ItemsCategory::with('items')->get();
    }
}
