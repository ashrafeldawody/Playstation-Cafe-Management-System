<?php

namespace App\DataTables;

use App\Models\Bill;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class BillDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('device', function ($bill) {
                return $bill->device ? $bill->device->name : 'بلا جهاز';
            })
            ->addColumn('created_at', function ($bill) {
                return $bill->created_at->format('Y-m-d h:i a');
            })
            ->addColumn('updated_at', function ($bill) {
                return $bill->updated_at->format('Y-m-d h:i a');
            })
            ->addColumn('items', function ($bill) {
                if ($bill->items->count() == 0) {
                    return 'لا يوجد';
                }
                return '<table class="table table-bordered table-striped rtl">
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>السعر</th>
                            <th>الكمية</th>
                            <th>الاجمالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' . $bill->items->map(function ($item) {
                    return '<tr>
                                <td>' . $item->item->name . '</td>
                                <td>' . $item->item->price . '</td>
                                <td>' . $item->quantity . '</td>
                                <td>' . $item->item->price * $item->quantity . '</td>
                            </tr>';
                })->implode('') . '
                    </tbody>
                </table>';
            })
            ->addColumn('sessions', function ($bill) {
                if($bill->sessions->count() == 0){
                    return 'لا يوجد';
                }
                return '<table class="table table-bordered table-striped rtl">
                    <thead>
                        <tr>
                            <th>البداية</th>
                            <th>النهاية</th>
                            <th>المدة</th>
                            <th>السعر</th>
                        </tr>
                    </thead>
                    <tbody>
                        ' . $bill->sessions->map(function ($session) {
                    return '<tr>
                                <td>' . Carbon::parse($session->start_time)->format('h:i a') . '</td>
                                <td>' . ($session->end_time ? Carbon::parse($session->end_time)->format('h:i a') : 'لا يوجد') . '</td>
                                <td>' . round($session->duration / 60) . '</td>
                                <td>' . $session->cost . '</td>
                            </tr>';
                })->implode('') . '
                    </tbody>
                </table>';
            })
            ->rawColumns(['items', 'sessions'])
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Bill $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Bill $model): QueryBuilder
    {
        if(Auth()->user()->hasRole('admin')){
            return $model->newQuery()->with('sessions', 'items', 'device', 'device.category')->whereDoesntHave('activeSession')->orderBy('updated_at', 'desc');
        }else{
            return $model->newQuery()->with('sessions', 'items', 'device', 'device.category')->where('shift_id', Auth()->user()->active_shift->id)->whereDoesntHave('activeSession')->orderBy('updated_at', 'desc');;
        }
    }
    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('bill-table')
                    ->columns($this->getColumns())
                    ->ajax()
                    ->dom('Bfrtip')
                    ->orderBy(0)
                    ->footerCallback('function (row, data, start, end, display) {
                        var api = this.api(), data;
                        var total = api.column(4).data().reduce(function (a, b) {
                            return a + b;
                        }, 0);
                        $(api.column(4).footer()).html(total);
                    }')
                    ->buttons(
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('device')->title('الجهاز'),
            Column::make('shift_id')->title('الوردية'),
            Column::make('items')->title('المشروبات'),
            Column::make('sessions')->title('اللعب'),
            Column::make('time_limit')->title('الوقت المحدد'),
            Column::make('cafe_total')->title('إجمالي الكافيه'),
            Column::make('play_total')->title('إجمالي اللعب'),
            Column::make('discount')->title('الخصم'),
            Column::make('paid')->title('المدفوع'),
            Column::make('created_at')->title('تاريخ الفاتورة'),
            Column::make('updated_at')->title('تاريخ التعديل'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Bill_' . date('YmdHis');
    }
}
