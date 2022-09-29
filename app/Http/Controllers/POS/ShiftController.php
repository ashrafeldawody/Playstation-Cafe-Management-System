<?php

namespace App\Http\Controllers\POS;

use App\DataTables\BillDataTable;
use App\Http\Controllers\Controller;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index(Request $request)
    {
        $shifts = Shift::with('bills')->get();
        return view('pos.shifts.index', compact('shifts'));
    }

    public function start()
    {
        auth()->user()->active_shift()->create([
            'start_time' => Carbon::now(),
        ]);
        return redirect()->route('pos.index');
    }

    public function end()
    {
        auth()->user()->active_shift()->update([
            'end_time' => Carbon::now(),
        ]);
        return redirect()->route('pos.shift.index')->with('success', 'تم انهاء الشيفت بنجاح');
    }

    public function stats(BillDataTable $dataTable){
        $shift = auth()->user()->active_shift;
        $bills = $shift->bills;
        $stats = $shift->stats();
        return $dataTable->render('pos.stats.index', compact('bills', 'stats'));
    }
}
