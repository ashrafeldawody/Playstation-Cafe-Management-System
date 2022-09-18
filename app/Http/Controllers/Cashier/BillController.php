<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Device;
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

    public function swap(Request $request)
    {
        $bill = Bill::find($request->bill_id);
        $device = Device::find($request->device_id);
        if($device->activeBill){
            return response()->json(['message' => 'لا يمكنك تغيير الفاتوره لهذا الجهاز'], 400);
        }
        $bill->update([
            'device_id' => $request->device_id,
        ]);
        return response()->json(null,200);
    }


}
