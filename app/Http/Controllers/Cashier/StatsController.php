<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Carbon\CarbonInterval;

class StatsController extends Controller
{
    public function index()
    {
        $current_shift = Shift::where('end_time', null)->first();
        $cafeTotal = $current_shift->bills->sum('cafe_total');
        $playTotal = $current_shift->bills->sum('play_total');
        $totalDiscount = $current_shift->bills->sum('discount');
        $totalPaid = $current_shift->bills->sum('paid');
        $stats = [
            [
                'label' => 'مبيعات الكافيه',
                'value' => $current_shift->items->sum('quantity'),
                'unit' => 'قطعه',
            ],
            [
                'label' => 'دخل الكافيه',
                'value' => $cafeTotal,
                'unit' => 'جنيه',
            ],
            [
                'label' => 'ساعات اللعب',
                'value' => CarbonInterval::seconds($current_shift->sessions->sum('duration'))->cascade()->format('%h:%I'),
                'unit' => '',
            ],
            [
                'label' => 'دخل اللعب',
                'value' => $playTotal,
                'unit' => 'جنيه',
            ],
            [
                'label' => 'اجمالي الخصم',
                'value' => $totalDiscount,
                'unit' => 'جنيه',
            ],
            [
                'label' => 'اجمالي الدخل',
                'value' => $playTotal + $cafeTotal,
                'unit' => 'جنيه',
            ],
            [
                'label' => 'اجمالي المدفوع',
                'value' => $playTotal + $cafeTotal - $totalDiscount,
                'unit' => 'جنيه',
            ],
        ];
        return response()->json($stats);
    }
    public function overtime(){
        $shifts = Shift::whereNot('end_time', null)->whereMonth('start_time', '=', date('m'))->whereYear('start_time', '=', date('Y'))->get();

        return response()->json($shifts);
    }
}
