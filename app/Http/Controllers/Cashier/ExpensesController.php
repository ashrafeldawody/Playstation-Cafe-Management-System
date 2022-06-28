<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Shift;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    public function index()
    {
        return Expense::whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->get();
    }

    public function store(Request $request)
    {
        $current_shift = Shift::where('end_time', null)->first();
        $request->merge(['shift_id' => $current_shift->id]);
        $expense = Expense::create($request->all());
        return response()->json($expense,201);
    }

}
