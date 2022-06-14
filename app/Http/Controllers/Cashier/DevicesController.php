<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DevicesController extends Controller
{
    public function index()
    {
        $devices = Device::with('activeBill','activeBill.sessions')->get();
        return  view('cashier.devices', compact('devices'));
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
        $bill = Bill::where('device_id',$request->device_id)->whereHas('activeSession')->first();
        if($bill)
            return response()->json(['message' => 'يرجي انهاء الفاتوره السابقه أولا'], 404);

        $request->merge([
            'user_id' => 1,
        ]);
        $bill = Bill::create($request->only(['device_id','user_id']));
        $bill->sessions()->create([
            'start_time' => Carbon::now()->toDateTime(),
            'time_limit' => $request->time_limit,
            'is_multi' => $request->is_multi,
        ]);
        return response()->json($bill);
    }

    public function finish($device_id,Request $request)
    {
        $bill = Bill::where('device_id',$request->device_id)->whereHas('activeSession')->first();

        if(!$bill)
            return response()->json(['message' => 'لا يوجد فاتوره للجهاز'], 404);
        $activeSession = $bill->activeSession->first();
        $duration = Carbon::now()->diffInSeconds($activeSession->start_time);
        $pricePerHour = $activeSession->is_multi ? $bill->device->category->multi_price : $bill->device->category->price;
        $cost = round(($duration / 3600) * $pricePerHour);
        $afterDiscount = $this->custom_round($pricePerHour,$cost);

        $activeSession->update([
            'end_time' => Carbon::now(),
            'cost' => $cost,
            'duration' => $duration,
        ]);
        return response()->json($bill);
    }
    private function delete_bill($device_id)
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
    private function custom_round($pricePerHour,$price):float{
        if($price <= 5)
            return 5;
        if($price > ($pricePerHour * 3))
            return floor( $price / 5 ) * 5;

        return floor( $price / 2 ) * 2;
    }

}