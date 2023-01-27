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
                if(!$shift->end_time) return 'لم ينتهي بعد';
                if($shift->overtime > 0)
                    return '<span class="text-success">+' . CarbonInterval::minutes($shift->overtime)->cascade()->format('%h:%I') . '</span>';
                return '<span class="text-danger">-' . CarbonInterval::minutes($shift->overtime)->cascade()->format('%h:%I') . '</span>';
            })->addColumn('last_session_end_time', function ($shift) {
                $last = $shift->last_session_end_time();
                return $last ? Carbon::parse($last)->format('Y-m-d h:i:s A') : 'لا يوجد';
            })
            ->rawColumns(['overtime'])
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
        if (auth()->user()->hasRole('admin')) {
            return $model->newQuery()->with('bills','items','sessions')->orderBy('id', 'desc');
        }
        return $model->newQuery()->with('bills','items','sessions')->whereMonth('start_time', Carbon::now()->month);

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
        $mandatoryColumns = [
            Column::make('id'),
            Column::make('start_time')->title('بداية الوردية'),
            Column::make('end_time')->title('نهاية الوردية'),
            Column::make('last_session_end_time')->title('اخر فاتورة'),
            Column::make('duration')->title('مدة الوردية'),
            Column::make('overtime')->title('الوقت الإضافي'),
        ];
        if (auth()->user()->hasRole('admin')) {
            $adminColumns = [
                Column::make('play_total')->title('إجمالي اللعب'),
                Column::make('cafe_total')->title('إجمالي الكافيه'),
                Column::make('total_discount')->title('إجمالي الخصم'),
                Column::make('total_paid')->title('إجمالي المدفوع'),
            ];
            return array_merge($mandatoryColumns, $adminColumns);
        }
        return $mandatoryColumns;
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
