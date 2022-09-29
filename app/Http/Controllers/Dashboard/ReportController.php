<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->get('start_time');
        $end = $request->get('end_time');
        $bills = Bill::timeRangeBills($start, $end);
        $stats = Bill::timeRangeStats($start, $end);
        return view('dashboard.reports.index', compact('bills', 'stats'));
    }
}
