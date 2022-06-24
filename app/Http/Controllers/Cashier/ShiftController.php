<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\shift;
use Illuminate\Http\Request;

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
            return response()->json(['message' => 'الشيفت تم بدءها سابقا'], 400);
        $new_shift = Shift::create([
            'start_time' => now()
        ]);
        return response()->json($new_shift);
    }
    public function end()
    {
        $shift = Shift::where('end_time', null)->first();
        if (!$shift)
            return response()->json(['message' => 'الشيفت غير متوفرة'], 400);
        $shift->update([
            'end_time' => now()
        ]);
        return response()->json($shift);
    }
}
