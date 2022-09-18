<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Resources\CashierDeviceResource;
use App\Models\Bill;
use App\Models\CafeBillItem;
use App\Models\Device;
use App\Models\Shift;
use App\Models\TempBillItem;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DevicesController extends Controller
{
    public function index()
    {
        return CashierDeviceResource::collection(Device::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function start(Request $request)
    {
        $shift = shift::where('end_time', null)->first();
        if (!$shift) {
            return response()->json(['message' => 'يرجي بدء الشيفت اولا'], 400);
        }
        $bill = Bill::where('device_id',$request->device_id)->whereHas('activeSession')->first();
        if($bill)
            return response()->json(['message' => 'يرجي انهاء الفاتوره السابقه أولا'], 400);
        $request->merge(['shift_id' => $shift->id]);
        $bill = Bill::create($request->only(['device_id','shift_id','time_limit']));
        $bill->sessions()->create([
            'start_time' => Carbon::now(),
            'is_multi' => $request->is_multi ? 1 : 0,
        ]);
        return response()->json(Bill::with('sessions','tempItems')->find($bill->id));
    }
    public function toggleMulti($device_id)
    {
        $bill = Bill::where('device_id',$device_id)->whereHas('activeSession')->first();
        if(!$bill)
            return response()->json(['message' => 'لا يوجد فاتوره للجهاز'], 404);

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
        return response()->json(Bill::with('sessions','tempItems')->find($bill->id));
    }
    public function changeLimit($device_id,$time_limit)
    {
        $bill = Bill::where('device_id',$device_id)->whereHas('activeSession')->first();
        if(!$bill)
            return response()->json(['message' => 'لا يوجد فاتوره للجهاز'], 404);

        $bill->update([
            'time_limit' => $time_limit,
        ]);
        return response()->json(null,200);
    }

    public function finish(Request $request)
    {
        $bill = Bill::find($request->bill_id);

        if(!$bill)
            return response()->json(['message' => 'لا يوجد فاتوره للجهاز'], 404);

        $activeSession = $bill->activeSession->first();

        $duration = Carbon::now()->diffInSeconds($activeSession->start_time);

        $pricePerHour = $activeSession->is_multi ? $bill->device->category->multi_price : $bill->device->category->price;

        $cost = round(($duration / 3600) * $pricePerHour) ;

        $activeSession->update([
            'end_time' => Carbon::now(),
            'cost' => $cost,
            'duration' => $duration,
        ]);

        $tempBillItems = TempBillItem::where('bill_id',$bill->id)->get();
        $total_cafe_cost = 0;
        foreach ($tempBillItems as $tempBillItem) {
            $total_cafe_cost += $tempBillItem->price * $tempBillItem->quantity;
            CafeBillItem::create([
                'bill_id' => $tempBillItem->bill_id,
                'item_id' => $tempBillItem->item_id,
                'quantity' => $tempBillItem->quantity,
                'price' => $tempBillItem->price,
            ]);
            $tempBillItem->delete();
        }

        $bill->update([
            'cafe_total' => $total_cafe_cost,
            'play_total' => $bill->sessions->sum('cost') < 5 ? 5 : $bill->sessions->sum('cost'),
            'discount' => $request->discount ? $request->discount : 0,
            'paid' => $request->paid < 5 ? 5 : $request->paid,
        ]);

        return CashierDeviceResource::make(Device::find($bill->device_id));
    }
    public function updateCart($bill_id,Request $request){

        TempBillItem::where('bill_id',$bill_id)->delete();
        foreach ($request->items as $item) {
            TempBillItem::updateOrCreate(
                ['bill_id' => $bill_id, 'item_id' => $item['item_id']],
                ['quantity' => $item['quantity'],'price'=> $item['price']]
            );
        }

        return response()->json(null,200);
    }
    public function delete_bill($device_id)
    {
        $bill = Bill::where('device_id',$device_id)->whereHas('activeSession')->first();
        if(!$bill)
            return response()->json(['message' => 'لا يوجد فاتوره للجهاز'], 404);
        $duration = Carbon::now()->diffInSeconds($bill->created_at);
        if($duration > (10 * 60))
            return response()->json(['message' => 'لا يمكن حذف الفاتوره بعد مرور 10 دقائق'], 404);
        if($bill->delete())
            return response()->json(['message' => 'تم حذف الفاتوره بنجاح'], 200);
    }


    public function get_available_devices()
    {
        $devices = Device::whereDoesntHave('activeBill')->get();
        return response()->json($devices);
    }
}
