<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Salary;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric',
        ]);
        $request->has('is_bonus') ? $request->merge(['is_bonus' => 1]) : $request->merge(['is_bonus' => 0]);
        Salary::create($request->only(['user_id', 'amount','is_bonus']));
        return redirect()->back()->with('success', 'تم اضافة الراتب بنجاح');
    }
}
