<?php

namespace App\Http\Controllers\POS;

use App\Http\Controllers\Controller;
use App\Http\Resources\CashierDeviceResource;
use App\Models\Bill;
use App\Models\Device;
use App\Models\Item;
use App\Models\setting;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Http\Request;
use League\Flysystem\Config;

class PlayController extends Controller
{
    public function index(Request $request)
    {
        $devices = Device::with('category','activeBill')->get()->toJson();
        $items = Item::all()->toJson();
        return view('pos.index', compact('devices', 'items'));
    }
    public function start(Request $request)
    {
        $bill = Bill::where('device_id',$request->device_id)->whereHas('activeSession')->first();
        if($bill)
            return redirect()->back()->with('error', 'يرجي انهاء الفاتوره السابقه أولا');
        $request->merge(['shift_id' => auth()->user()->active_shift->id]);
        $bill = Bill::create($request->only(['device_id','shift_id','time_limit']));
        $bill->sessions()->create([
            'start_time' => Carbon::now(),
            'is_multi' => $request->is_multi ? 1 : 0,
        ]);
        return redirect()->back()->with('success', 'تم بدء الجهاز بنجاح');
    }


    public function toggle_multi()
    {
        $bill = Bill::find(request()->bill_id);

        $last_session = $bill->sessions->last();

        $duration = Carbon::now()->diffInSeconds($last_session->start_time);

        $pricePerHour = $last_session->is_multi ? $bill->device->category->multi_price : $bill->device->category->price;

        $cost = round(($duration / 3600) * $pricePerHour) ;

        $last_session->update([
            'end_time' => Carbon::now(),
            'cost' => $cost,
            'duration' => $duration,
        ]);

        $bill->sessions()->create([
            'start_time' => Carbon::now(),
            'is_multi' => !$last_session->is_multi,
        ]);
        return response()->json(['status' => 'success', 'message' => 'تم تغيير الحاله بنجاح'], 200);
    }

}
