<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\ExpenseDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(ExpenseDataTable $dataTable)
    {
        return $dataTable->render('dashboard.expenses.index');
    }
}
