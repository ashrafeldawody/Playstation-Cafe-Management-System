<?php

namespace App\Http\Controllers\POS;

use App\DataTables\BillDataTable;
use App\DataTables\ShiftDataTable;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\Mail\ShiftStarted;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
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
        if(!auth()->user()->active_shift)
            auth()->user()->active_shift()->create(['start_time' => Carbon::now()]);

        SendEmail::dispatch('ashraf6450@gmail.com',new ShiftStarted());
        return redirect()->route('pos.index');
    }

    public function end()
    {
        $shift = auth()->user()->active_shift;
        $adminMails = User::role('admin')->pluck('email')->toArray();

        foreach ($adminMails as $mail) {
            $shift->sendMail($mail);
        }

        $shift->update([
            'end_time' => Carbon::now(),
        ]);

        return redirect()->route('pos.shift.index')->with('success', 'تم انهاء الوردية بنجاح');
    }

    public function stats(BillDataTable $dataTable){
        $shift = auth()->user()->active_shift;
        $bills = $shift->bills;
        $stats = $shift->stats();
        $title = 'احصائيات الوردية';
        return $dataTable->render('common.table-page', compact('bills', 'stats', 'title'));

    }

    public function monthlyShifts(ShiftDataTable $dataTable){
        $shifts = auth()->user()->shifts()->whereMonth('start_time', Carbon::now()->month)->with('bills')->get();
        $stats = [
            [
                'title' => 'اجمالي الوقت الإضافي',
                'value' => CarbonInterval::minutes($shifts->sum('overtime'))->cascade()->format('%h:%I'),
                'icon' => 'fa fa-clock',
                'bg-color' => 'bg-primary',
                'append' => '',
            ],
            [
                'title' => 'سعر الوقت الإضافي',
                'value' => $shifts->sum('overtimePrice'),
                'icon' => 'fa fa-money-bill-wave',
                'bg-color' => 'bg-success',
                'append' => 'جنيه',
            ],
            [
                'title' => 'المدفوع لهذا الشهر',
                'value' => auth()->user()->paid_this_month(),
                'icon' => 'fa fa-money-bill',
                'bg-color' => 'bg-warning',
                'append' => 'جنيه',
            ],
            [
                'title' => 'المتبقي لهذا الشهر',
                'value' => auth()->user()->remaining_this_month(),
                'icon' => 'fa fa-money-bill-wave',
                'bg-color' => 'bg-success',
                'append' => 'جنيه',
            ],
        ];
        $title = 'الورديات الشهرية';
        return $dataTable->render('common.table-page', compact('stats', 'title'));
    }
}
