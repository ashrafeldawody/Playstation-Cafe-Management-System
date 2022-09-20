<?php

namespace App\DataTables;

use App\Models\Bill;
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
            ->with('total', function() use ($query) {
                return $query->sum('paid');
            })
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
        return $model->with('items','sessions','device')
            ->newQuery();
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
