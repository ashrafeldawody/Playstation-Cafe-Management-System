<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\CafeBillItem;
use App\Models\Device;
use App\Models\Item;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $stats = Bill::timeRangeStats($request->get('start_time'), $request->get('end_time'));
        $topSelling = Item::top5($request->get('start_time'), $request->get('end_time'));
        $mostActiveDevice = Device::top5($request->get('start_time'), $request->get('end_time'));
        return view('dashboard.home',compact('stats','topSelling','mostActiveDevice'));
    }

}
