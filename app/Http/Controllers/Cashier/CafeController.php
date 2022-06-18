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
        $categories = ItemsCategory::with('items')->get();
        return Inertia::render('Cafe', [
            'categories' => $categories,
        ]);
    }
}
