<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Shift;
use Illuminate\Http\Request;

class BillController extends Controller
{

    public function index(Request $request)
    {
        $current_shift = Shift::where('end_time', null)->first();
        $bills = Bill::with('sessions','items','device','device.category')->whereDoesntHave('activeSession')
            ->orderBy('updated_at', 'desc')
            ->where('shift_id', $current_shift->id)
            ->get();
        return response()->json($bills);
    }

}
