<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Invoice;

class ShiftController extends Controller
{
    public function check(){
        $shift = Shift::where('end_time', null)->first();
        if($shift){
            return response()->json($shift);
        }
        return response()->json(['message' => 'لا يوجد شيفت'], 400);
    }
    public function start(){
        $shift = Shift::where('end_time', null)->first();
        if($shift)
            return response()->json(['message' => 'الوردية تم بدءها سابقا'], 400);
        $new_shift = Shift::create([
            'start_time' => now()
        ]);
        return response()->json($new_shift);
    }
    public function end()
    {
        $shift = Shift::where('end_time', null)->with('bills.sessions','bills.items','bills.items.item')->first();
        if (!$shift)
            return response()->json(['message' => 'الوردية غير متوفرة'], 400);
        $shift->update([
            'end_time' => now()
        ]);

        return response()->json($shift);
    }

}
