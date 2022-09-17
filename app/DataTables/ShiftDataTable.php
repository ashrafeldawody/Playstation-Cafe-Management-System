<?php

namespace App\DataTables;

use App\Models\Shift;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ShiftDataTable extends DataTable
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
            ->addColumn('start_time', function ($shift) {
                return Carbon::parse($shift->start_time)->format('Y-m-d h:i:s A');
            })
            ->addColumn('end_time', function ($shift) {
                return $shift->end_time ? Carbon::parse($shift->end_time)->format('Y-m-d h:i:s A') : 'لم ينتهي بعد';
            })
            ->addColumn('duration', function ($shift) {
                return CarbonInterval::minutes($shift->duration)->cascade()->format('%h:%I');
            })
            ->addColumn('overtime', function ($shift) {
                return CarbonInterval::minutes($shift->overtime)->cascade()->format('%h:%I');
            })
            ->setRowId('id');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Shift $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Shift $model): QueryBuilder
    {
        return $model->with('bills','items','sessions')
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
                    ->setTableId('shift-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
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
            Column::make('start_time')->title('بداية الوردية'),
            Column::make('end_time')->title('نهاية الوردية'),
            Column::make('duration')->title('مدة الوردية'),
            Column::make('play_total')->title('إجمالي اللعب'),
            Column::make('cafe_total')->title('إجمالي الكافيه'),
            Column::make('total_discount')->title('إجمالي الخصم'),
            Column::make('total_paid')->title('إجمالي المدفوع'),
            Column::make('overtime')->title('الوقت الإضافي'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Shift_' . date('YmdHis');
    }
}
