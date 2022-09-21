<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\ExpenseDataTable;
use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(ExpenseDataTable $dataTable)
    {
        return $dataTable->render('dashboard.expenses.index');
    }

    public function create()
    {
        return view('dashboard.expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'amount' => 'required|numeric',
            'description' => 'string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);

        $expense = Expense::create([
            'type' => $request->type,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);

        if ($request->hasFile('image')) {
            $expense->update([
                'image' => $request->image->store('expenses', 'public'),
            ]);
        }

        return redirect()->route('expenses.index')->with('success', 'تم تسجيل المصروف بنجاح');
    }

    public function edit(Expense $expense)
    {
        return view('dashboard.expenses.edit', compact('expense'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'type' => 'required',
            'amount' => 'required|numeric',
            'description' => 'string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:5048',
        ]);

        $expense->update([
            'type' => $request->type,
            'amount' => $request->amount,
            'description' => $request->description,
        ]);

        if ($request->hasFile('image')) {
            $expense->update([
                'image' => $request->image->store('expenses', 'public'),
            ]);
        }

        return redirect()->route('expenses.index')->with('success', 'تم تعديل المصروف بنجاح');
    }

    public function destroy(Expense $expense)
    {
        //
    }
}
